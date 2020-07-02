<?php



namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\item;
use App\houdbaarheid;
use App\boodschappenitem;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;
use DateTime;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {





    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
   }

   //laat het dashboard zien
    public function index()
    {
        $user = Auth::user();
        $datumVandaag = Carbon::now();
        $datumVolgendeWeek = Carbon::now()->addDays(7);
        $data = DB::table('houdbaarheid')->join('items', 'items.id', '=', 'houdbaarheid.item_id')->where("user_id", $user->id)->orderby('items.id', 'desc')->where('deleted_at', null)->limit(3)->get();
        foreach ($data as $item){
          $houdbaardatum = $item->houdbaarheidsdatum;
          $formatted_datum = Carbon::parse($houdbaardatum);
          $verschilInDagen =  $formatted_datum->diffInDays(Carbon::now());
          DB::table('houdbaarheid')->join('items', 'items.id', '=', 'houdbaarheid.item_id')->where("item_id", $item->id)->update([
            'aantal_dagen_houdbaar' => $verschilInDagen + 1,
          ]);
        }
        $groceryitems = DB::table('boodschappenitem')->where('user_id', $user->id)->get();
        $houdbaaritems = DB::table('houdbaarheid')
        ->join('items', 'items.id', '=', 'houdbaarheid.item_id')
        ->whereBetween('houdbaarheidsdatum', [$datumVandaag, $datumVolgendeWeek])->get();
        return view('dashboard')->with('data', $data)
        ->with('houdbaaritems', $houdbaaritems)
        ->with('groceryitems', $groceryitems);
    }

    //laat het overzicht van de items zonder user zien
    public function overviewWithoutUser(){
      $items = DB::table('houdbaarheid')->join('items', 'items.id', '=', 'houdbaarheid.item_id')->where("user_id", 3)->where('deleted_at', null)->orderby('items.id', 'desc')->get();
      return view('overview')->with('data', $items)->with('checked', 'true');
    }


    public function admin(){
      $user = User::orderBy('deleted_at')->first();
      if(User::onlyTrashed()->orderBy('deleted_at')->first() === NULL){
        return view('auth/admin')->with('users', User::all())->with('deleted_at', 'null');}
      else{
        return view('auth/admin')->with('users', User::all())->with('deleted_at', 'notnull');}
    }

    //haalt de laatst verwijderde account terug
    public function recover(Request $request){
      $lastRemovedUser = User::orderBy('deleted_at')->first();
      User::onlyTrashed()->orderBy('deleted_at')->first()->restore();
      return redirect ('/home/admin');
    }


    public function detail(){
      return view('itemDetail');
    }


    //laat de view van itemdetail zien
    public function editItem($id){
      $currentUser = Auth::user()->id;
      $users = DB::table('users')->get();
      $data = DB::table('houdbaarheid')->join('items', 'items.id', '=', 'houdbaarheid.item_id')->where("items.id", $id)->first();
      return view('itemDetail')->with('data', $data)->with('users', $users)->with('currentUser', $currentUser);
    }


    //update het item in de db die is aangepast in itemdetail
    public function updateItem(Request $request){
      switch($request->button){
        case 'save':
          item::where('id', $request->id)->update([
          'user_id' => $request->user_id,
          'naam' => $request->naam,
          'plank_positie' => $request->plank_positie,
          'barcode' => $request->barcode,
          'gewicht_huidig' => $request->gewicht_huidig
          ]);

          DB::table('houdbaarheid')->join('items', 'items.id', '=', 'houdbaarheid.item_id')->where('items.id', $request->id)->update([
            'houdbaarheidsdatum' => $request->houdbaarheidsdatum
          ]);
            return redirect('/home/overzicht');
        break;

        case 'delete':
        item::where('id', $request->id)->delete();
        return redirect('/home/overzicht');
      }
    }

    public function logout(){
      Auth::logout();
      return redirect("/login");
    }



    public function overzicht(Request $request){
      $user = Auth::user();
      $datumVandaag = Carbon::now();
      $datumVolgendeWeek = Carbon::now()->addDays(7);
      $data = DB::table('houdbaarheid')->join('items', 'items.id', '=', 'houdbaarheid.item_id')->where("user_id", $user->id)->orderby('items.id', 'desc')->where('deleted_at', null)->get();
      foreach ($data as $item){
        $houdbaardatum = $item->houdbaarheidsdatum;
        $formatted_datum = Carbon::parse($houdbaardatum);
        $verschilInDagen =  $formatted_datum->diffInDays(Carbon::now());
        DB::table('houdbaarheid')->join('items', 'items.id', '=', 'houdbaarheid.item_id')->where("item_id", $item->id)->update([
          'aantal_dagen_houdbaar' => $verschilInDagen + 1,
        ]);
      }
      $check = 'false';
      return view('overview')->with('data', $data)->with('checked', $check);
    }
    //zoekbal functie in overzicht
    public function search(Request $request){
      $q = $request->q;
      $user = Auth::user();
      $item = DB::table('houdbaarheid')->join('items', 'items.id', '=', 'houdbaarheid.item_id')->where("user_id", $user->id)->where('naam', 'LIKE', '%'.$q.'%')->get();
      if(count($item) > 0)
        return view('overview')->with('data', $item)->with('checked', 'false');
      else return view('overview')->with('data', $item)->with('checked', 'false')->withMessage('No details found. Try to search again');
    }
    //filter functie in overzicht
    public function filter(Request $request){
      $filter = $request->sort;
      $user = Auth::user();
      $itemsasc = DB::table('houdbaarheid')->join('items', 'items.id', '=', 'houdbaarheid.item_id')->where("user_id", $user->id)->where("deleted_at", NULL)->orderBy('houdbaarheidsdatum', 'asc')->get();
      $itemsdesc = DB::table('houdbaarheid')->join('items', 'items.id', '=', 'houdbaarheid.item_id')->where("user_id", $user->id)->where("deleted_at", NULL)->orderBy('houdbaarheidsdatum', 'desc')->get();
      $itemsaz = DB::table('houdbaarheid')->join('items', 'items.id', '=', 'houdbaarheid.item_id')->where("user_id", $user->id)->where("deleted_at", NULL)->orderBy('naam', 'asc')->get();
      $itemsza = DB::table('houdbaarheid')->join('items', 'items.id', '=', 'houdbaarheid.item_id')->where("user_id", $user->id)->where("deleted_at", NULL)->orderBy('naam', 'desc')->get();
      switch($filter){
        case 'asc':
        return view('overview')->with('data', $itemsasc)->with('checked', 'false');
        break;
        case 'desc':
        return view('overview')->with('data', $itemsdesc)->with('checked', 'false');
        break;
        case 'a-z':
        return view('overview')->with('data', $itemsaz)->with('checked', 'false');
        break;
        case 'z-a':
        return view('overview')->with('data', $itemsza)->with('checked', 'false');
        }
    }
    //laat overzicht zien van items die bijna over datum
    public function overzichtHoudbaar(Request $request){
      $user = Auth::user();
      $data = DB::table('houdbaarheid')->join('items', 'items.id', '=', 'houdbaarheid.item_id')->where("user_id", $user->id)->where('houdbaarheidsdatum', '!=', "NULL")->orderBy('houdbaarheidsdatum', 'asc')->get();
      return view('overview')->with('data', $data)->with('checked', 'false');
    }



    public function grocerylist(){
      $user = Auth::user();
      $deletedItems = DB::Table('items')->where("user_id", $user->id)->whereNotNull('deleted_at')->orderby('deleted_at', 'desc')->limit(3)->get();
      $boodschappenitems = DB::table('boodschappenitem')->where('boodschappenitem.user_id', $user->id)->get();
      return view('groceryList')->with('boodschappenitems', $boodschappenitems)->with('deletedItems', $deletedItems);
    }


    //verwijderd user
    public function delete(Request $request){
      $post = User::where('id', $request->id);
      $post->delete();
      return redirect ('/home/admin');
    }
}
