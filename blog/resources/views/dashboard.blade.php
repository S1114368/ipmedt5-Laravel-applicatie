@extends('layouts.app')

@section('content')
  <header>
      <h1 class="headerH1Text">Dashboard</h1>
  </header>
  @csrf
<div class="wrapper">
    <div class="dashboardGrid">
      <div class="gridScreen box a">
        <h2 class="boxHeader"><a class="links" href="/home/grocerylist">Grocerylist -></a></h2>
        <ul class= "dashboardListContent">
          <!--hier wordt je toegevoegde boodschappen weergegeven met naam en aantal  -->
          @foreach($groceryitems as $groceryitem)
            <li class="groceryList__item">{{$groceryitem->naam}}  ({{$groceryitem->aantal}})</li>
          @endforeach
        </ul>
      </div>
      <div class="box b">
          <div class="gridScreen box c">
            <!-- hier worden de items die over de datum gaan bijgehouden en in de header gestopt -->
            <h2 class="boxHeader"><a href="/home/overzicht/houdbaarheid">
	    @if($houdbaaritems->count() > 0)
            <span style="color: red;">{{$houdbaaritems->count()}}</span>
            @else
            {{$houdbaaritems->count()}}
            @endif
            item(s) expiring this week</a></h2>
          </div>

            <div class="gridScreen box d">
              <h2 class="boxHeader">Recently added items</h2>
              <!--De laatste 3 items die zijn ingescanned worden hier via deze foreach weergegeven-->
              @foreach($data as $item)
                <form action="{{ route('edit', $item->id)}}" method="get">
                <div class="overviewItem">
                  <img class="itemImage" src="{{asset($item->image_url)}}" alt="">
                  <p class="overviewText"><b>Name:</b> {{$item->naam}}</p>
                  <p class="overviewText"><b>Expire date:</b>
                    <!-- de items kunnen een houdbaarheidsdatum aan worden gegeven, als deze kleiner of gelijk is aan 7 dagen dan zal de achtergrondkleur van blauw naar rood veranderen. -->
                    @if($item->aantal_dagen_houdbaar <= 7)
                    <span class="expireDateTextRed"> {{$item->houdbaarheidsdatum}}</span></p>
                    @else
                    <span class="expireDateTextBlue"> {{$item->houdbaarheidsdatum}}</span></p>
                    @endif
                  <button name="button" type="submit" class="blueButton overviewText">Show Details></button>
                </div>
                </form>
		<hr>
              @endforeach
                <div class="linksBox">
                  <h3 class="links"><a class="links" href="/home/overzicht"><u>Show all items -></a></h3>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
