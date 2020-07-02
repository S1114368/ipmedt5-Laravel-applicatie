import time
import serial
import mysql.connector
import time
import os
from serpwow.google_search_results import GoogleSearchResults
import json
import mimetypes
import magic
import urllib
import datetime

mydb = mysql.connector.connect( #database connectie opzetten
  host="localhost",
  user="admin",
  passwd="voorraadkast123",
  database="voorraadkast"
)

mycursor = mydb.cursor(buffered=True) #database communicator opzetten


#Auth vars
authPort = serial.Serial("/dev/ttyUSB2", baudrate=115200, timeout=1.0)
userSet = False
userKey = ""

#Scale vars
barcodeScanned = False
val_list = []
weight = 0
count = 0
sendData = True

#NFC chip uitlezen en opslaan
def checkForUser():
 #output van serial port uitlezen
 uval = authPort.readline().strip('\r\n')
 data = ""
 #checken of er een hashtag wordt gevonden in de serial port.
 if('#' in uval):
  #serial port waarde splitten op # en de opeenvolgende waarde opslaan in data var(NFC UID).
  data = uval.split('#')[1]
  #check of data var gevuld is
  if(len(data) > 0):
   print("UID: " + data)
   #waarde vergelijken met waardes in de database
   mycursor.execute("SELECT name, COUNT(*) FROM users WHERE uid = %s", (data,))
   qresult = mycursor.fetchone()[0]
  else:
   return False
  #checken of er een overeenkomende waarde is gevonden in de database
  if qresult:
   print("User Found!")
   username = qresult
   authPort.write(("s6!" + username).encode() + "\n")
   print("readLine: " + authPort.readline())	   
   print(str(qresult))
   global userSet 
   global userKey
   userSet = True #aangeven dat er een user is ingelogd
   userKey = data #UID opslaan in globale variabele voor later gebruik
  else:
   print(":( User not found with uid: " + data) 
   authPort.write("s5\n")
   time.sleep(.5)
   return False

#het downloaden van de image file die opgevraagd wordt wanneer de barcode wordt ingescanned
def dl_jpg(url, file_path, file_name, mime):
    full_path = file_path + file_name # create full path to save file and name to
    urllib.urlretrieve(url, full_path) # retrieve the file from url
    mimes = mime.from_file(full_path) # get the mime type of the file
    global ext #zetten van globaal variabelen voor later gebruik
    ext = mimetypes.guess_all_extensions(mimes)[0] #guess the extension based on mimes
    os.rename(full_path, full_path+ext) #rename file to file name + guess filetype extension
    

def addItem(barcode_in, uid, naam, img_url, ext):
    #uid sturen
    #barcode sturen
    naam = naam.replace("_", " ")

    if(uid != None): #toevoegen van items als er een user gevonden is
     mycursor.execute("SELECT id FROM users where uid = %s", (uid,)) # user opvragen
     
     iresult = mycursor.fetchall()[0]#user opslaan in variabele
     
     mycursor.execute("INSERT INTO items (user_id, houdbaarheid_id, barcode, naam, gewicht_nieuw, gewicht_huidig, plank_positie, image_url) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)", (iresult[0], None, barcode_in, naam, None, None, None,img_url+ext)) #item toevoegen aan database
     
     mydb.commit() #queued queries doorvoeren naar database
     
     mycursor.execute("SELECT id FROM items where barcode = %s ORDER BY id DESC LIMIT 1", (barcode_in,)) #opvragen van id van zojuist toegevoegde item
     
     result = mycursor.fetchall()[0] #id opslaan in variabele
     
     mycursor.execute("INSERT INTO houdbaarheid (item_id, houdbaarheidsdatum, aantal_dagen_houdbaar) VALUES (%s, %s, %s)", (result[0], None, None)) #bijbehorend houdbaarheid tabel aanmaken met item_id
    else: #toevoegen aan items zonder user
     mycursor.execute("INSERT INTO items (user_id, houdbaarheid_id, barcode, naam, gewicht_nieuw, gewicht_huidig, plank_positie, image_url) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)", (3, None,barcode_in, naam, None, None, None,img_url+ext))
     
     mydb.commit()
    
     mycursor.execute("SELECT id FROM items where barcode = %s ORDER BY id DESC LIMIT 1", (barcode_in,))
     
     result = mycursor.fetchall()[0]
     
     mycursor.execute("INSERT INTO houdbaarheid (item_id, houdbaarheidsdatum, aantal_dagen_houdbaar) VALUES (%s, %s, %s)", (result[0], None, None))
    
    mydb.commit()

def removeItem(barcode_out, uid):
     mycursor.execute("SELECT id, barcode FROM items where barcode = %s AND deleted_at IS NULL LIMIT 1", (barcode_out,)) #te verwijderen item opvragen in database
     if(mycursor.rowcount > 0): #checken of er een resultaat is gevonden
      if uid != None: #checken of er een user is gevonden
       print("user check removeItem() PASSED")
       mycursor.execute("SELECT id FROM users where uid = %s", (uid,)) #user opvragen
       iresult = mycursor.fetchall()[0] # user in variabele stoppen
       mycursor.execute("UPDATE items SET deleted_at = %s, deleted_by_id = %s WHERE barcode = %s AND user_id = %s AND deleted_at IS NULL LIMIT 1", (datetime.datetime.now(), iresult[0], barcode_out, iresult[0],)) #item verwijderen en bijbehorende user mee geven
       mydb.commit() #queries doorvoeren naar database
       print("ok, " + str(barcode_out) + " is removed")
       authPort.write("s4* \n")
      else:
       print("user check removeItem() FAILED")
       mycursor.execute("UPDATE items SET deleted_at = %s, deleted_by_id = %s WHERE barcode = %s AND deleted_at IS NULL AND user_id = %s LIMIT 1", (datetime.datetime.now(), None, barcode_out, 3,))
      #mycursor.execute("DELETE FROM items WHERE barcode = %s LIMIT 1", (barcode_out,))
       mydb.commit() #queries doorvoeren naar database
       print("ok, " + str(barcode_out) + " is removed")
       authPort.write("s4* \n")
     else: # geen barcode gevonden
      print(str(barcode_out) + " wasn't found! Please try again or check if it's scanned in.")
      authPort.write("s3 \n")
     
     
def setScale(barcode_in): #Wegen van items na inscannen
 print("Barcode in: " + str(barcode_in))
 global sendData
 if sendData == True:
  authPort.write("s7\n")
  sendData = False
 try: #probeer waarde uit te lezen, zo niet geef de error door en ga verder
  time.sleep(.1) 
  val = int(authPort.readline().split(":")[1].strip(" ")) # lees waarde uit de serial port en sla op in variabele
 except ValueError as ex:
  print("faulty input skipped")
 except IndexError as ie:
  print("Index Error Skipped: " + str(ie))
 except NameError  as ne:
  print("Name Error Skipped: " + str(ie))
 global val
 global val_list
 global count
 global barcodeScanned
 if count == 10: # als de count op 10 staat, zet barcode scanned op false
  barcodeScanned = False
  sendData = True
 if barcodeScanned == True: # als barcodeScanned op true staat, run de volgende code
  if count < 10 and not val_list: # als count kleiner is dan 10 en val_list niet gevuld is
   count = count+1
   print("count: " + str(count))
  if -5 <= val <= 5: #als de uitgelezen waarde niet groter is dan 5 gram en kleiner dan -5 gram maak de val_list leeg
   val_list = []
   return
  else:
   if len(val_list) < 5: # minder dan 5 waardes in de list voeg de nieuwe value aan de list toe
    print(val_list)
    val_list.append(val)
   elif len(val_list) == 5: # check of de list gelijk is aan 5
    if val_list[-1] == val_list[-4]: # vergelijk eerste en een na laatste waarde met elkaar. Komt het overeen, sla deze waarde dan in een nieuwe variabele en voeg het toe aan het item
     weight = val_list[-1]
     authPort.flush()
     
     print("Weight Set: " + str(weight))
     authPort.write("s8|" + str(weight) + "\n")
     mycursor.execute("UPDATE items SET gewicht_huidig = %s, gewicht_nieuw = %s, plank_positie = '1' WHERE barcode = %s ORDER BY id DESC LIMIT 1", (weight, weight, barcode_in,)) # waarde doorvoeren naar database
     mydb.commit() # query door voeren naar data base
     barcodeScanned = False # gewicht scan legen
     sendData = True
     val_list = [] # leeg de lijst
     count = 0
    else: # waardes komen niet overeen, probeer het opnieuw
     print(str(val_list[-1]) + " is First")
     print(str(val_list[-4]) + " is last")
     print("Weight is not consistent, trying again")
     val_list = []
 else:
  print("Please Scan Barcode")
  authPort.write("s8|error\n")
  count = 0
  val_list = []


#Scanner 1 - INSCAN
ser = serial.Serial(
 port='/dev/ttyUSB0',
 baudrate = 9600,
 parity=serial.PARITY_NONE,
 stopbits=serial.STOPBITS_ONE,
 bytesize=serial.EIGHTBITS,
 timeout=1
)

#Scanner 2 - UITSCAN
ser2 = serial.Serial(
 port='/dev/ttyUSB1',
 baudrate = 9600,
 parity=serial.PARITY_NONE,
 stopbits=serial.STOPBITS_ONE,
 bytesize=serial.EIGHTBITS,
 timeout=1
)

#scanner vars
counter=0
barcode = ""
stap = 0
x=""
x1=""

while 1:
 if barcodeScanned == True: #check of barcodeScanned waar is
  setScale(x) # run set scale functie en stuur de barcode door
 else:
  checkForUser() #check of een user zich aanmeld via NFC
  
  stap = stap + 1
  x=ser.readline().strip('\r\n') #Scanner 1 input uitlezen
  x1=ser2.readline().strip('\r\n') #Scanner 2 input uitlezen

  #Scanner 1
  if len(x) == 0:
   #Er wordt niks gescand
   print ( "Scanner 1: Scan iets in")
   barcodeScanned = False
  else:
   barcodeScanned = True
   print ( "In: ", x)
   authPort.write("s2\n")
   #Image Search
   # create the serpwow object, passing in our API key
   serpwow = GoogleSearchResults("4F87B9EDF89C4E7F8E5648AF0D257DAC")
    # set up a dict for the search parameters
   params = {
     "q" : x,
     "search_type" : "images"
   }
   mime = magic.Magic(mime=True)

   # retrieve the search results as JSON
   result = serpwow.get_json(params)

   # define name for file name
   try:
    name = result['image_results'][0]['title']
    # get imageurl value of json result
    imgurl = result['image_results'][0]['image']
   # check for errors
   except KeyError as ke:
    name = "Product name not found"
    imgurl = "https://i.pinimg.com/originals/c5/f0/fa/c5f0fa5ac14327b8330fde1c621ffa8a.jpg"

   #set product name to file name
   file_name = name.replace(" ", "_");

   #define the complete url
   final_url = 'css/img/' + file_name

   #trigger the download function
   dl_jpg(imgurl, 'css/img/', file_name, mime)

   # pretty-print the result
   #print(json.dumps(imgurl, indent=2, sort_keys=True))
   print("userSet before insert check: " + str(userSet) )
   if (userSet == True): 
    addItem(x, userKey, file_name, final_url, ext)
   else:
    addItem(x, None, file_name, final_url, ext)


  #Scanner 2
  if len(x1) == 0:
   #Er wordt niks gescand
   print ( "Scanner 2: Scan iets uit")
  else: 
    #Barcode is nog niet ingescand
   print ( "Scanner 2: Product is nog niet ingescand: ", x1)
   if userSet == True: #check of de user is aangemeld
    print("The userkey: " + str(userKey))
    removeItem(x1, userKey)# stuur de user mee
   else:
    removeItem(x1, None)# stuur geen user mee

