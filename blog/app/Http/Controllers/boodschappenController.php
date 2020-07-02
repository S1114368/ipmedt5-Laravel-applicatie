<?php

namespace App\Http\Controllers;
use App\User;
use App\item;
use App\houdbaarheid;
use App\boodschappenitem;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Http\Request;

class boodschappenController extends Controller
{
    //verwijderd item uit boodschappenlijst
    public function delete(Request $request){
      switch($request->button){
        case  'remove':
          $post = DB::table('boodschappenitem')->where('naam', $request->itemNaam);
          $post->delete();
          return redirect('/home/grocerylist');
        break;

        case 'edit':
          return redirect('/home/grocerylist/edit');
        break;
      }
    }
    //laat de edit view zien van de boodschappenlijst
    public function edit(){
      $user = Auth::user();
      $boodschappenitems = DB::table('boodschappenitem')->where('boodschappenitem.user_id', $user->id)->get();
      $deletedItems = DB::Table('items')->where("user_id", $user->id)->whereNotNull('deleted_at')->orderby('deleted_at', 'desc')->limit(3)->get();
      $boodschappenitems = DB::table('boodschappenitem')->where('boodschappenitem.user_id', $user->id)->get();
      return view('groceryListEdit')->with('boodschappenitems', $boodschappenitems)->with('deletedItems', $deletedItems);
    }

    //edit item in boodschappenlijst
    public function editItem(Request $request){
      switch($request->button){
        case 'edit':
          boodschappenitem::where('naam', $request->itemEdit)->update([
          'naam' => $request->naam,
          'aantal' => $request->aantal
        ]);
          return redirect('/home/grocerylist');
        break;

        case 'remove':
          $post = DB::table('boodschappenitem')->where('naam', $request->itemNaam);
          $post->delete();
          return redirect('/home/grocerylist');
        }

    }

    //voegt item toe aan de boodschappenlijst
    public function add(Request $request){

        DB::table('items')->where('id', $request->product_id)->delete();


      $user = Auth::user();
      $item = new boodschappenitem;
      $item->naam =  $request->input('productNaam');
      $item->aantal = (int)$request->input('productAantal');
      $item->user_id = (int)$user->id;
      $item->item_id = null;
      $item->gewicht = null;

      try{
        $item->save();
        return redirect('/home/grocerylist');
      }

      catch(Exception $e){
        return redirect('/home/grocerylist');
      }
    }

}
