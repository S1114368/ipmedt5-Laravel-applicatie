@extends('layouts.app')
@section('content')
  <header>
    <h1 class="headerH1Text">Item overview</h1>
  </header>
  <div class="overviewHeader">

    <form class="sortItem" action="/home/overzicht/search" method="post"> <!-- zorgt voor communicatie met backend door het form -->
      @csrf
      <input class="overviewTextInput" type="text" name="q" placeholder="Search an item">
      <button type="submit" name="button">search</button>
    </form>

    <form  class="sortItem"action="/home/overzicht/filter" method="get">
      <div class="overviewTextFilters">
        <select name="sort" onchange="this.form.submit()">
          <option value="0">Sort by</option>
          <option value="asc">Expire date ASC</option>
          <option value="desc">Expire date DESC</option>
          <option value="a-z">Name A-Z</option>
          <option value="z-a">Name Z-A</option>
        </select>
      </div>
    </form>

    @if($checked == 'false')<!--verschillende windows laten zien per checkbox value-->
      <input onclick="if(this.checked){window.location = this.value;}" value="<?php echo htmlspecialchars("/home/overzicht/itemsWithoutUser")?>" class="overviewTextFilters overviewTextCheck" type="checkbox">
    @elseif($checked == 'true')
      <input checked="true" onclick="if(this.checked){window.location = this.value;}" value="<?php echo htmlspecialchars("/home/overzicht")?>" class="overviewTextFilters overviewTextCheck" type="checkbox">
    @endif
    <label class="overviewTextFilters overviewTextLabel" for="show">Show items without user</label>

  </div>

  <div class="overviewGrid" >

    @foreach($data as $item)<!--voor elk item in de database dezelfde opmaak, en in grid zetten-->
    <form action="{{ route('edit', $item->id)}}" method="get">
      <div class="overviewScreen">
        <div class="overviewItem">
          <img class="itemImageOverview" src="{{asset($item->image_url)}}" alt="">
          <p class="overviewText"><b>Name:</b> {{$item->naam}}</p>
          <p class="overviewText"><b>Expire date: </b>
            @if($item->aantal_dagen_houdbaar <= 7)<!--geeft items rode achtergrond als ze nog minder dan 7 dagen goed zijn-->
            <span class="expireDateTextRed">{{$item->houdbaarheidsdatum}}</span></p>
            @else<!--anders blauwe achtergrond-->
            <span class="expireDateTextBlue">{{$item->houdbaarheidsdatum}}</span></p>
            @endif
          <button type="submit" class="overviewButton blueButton" name="button">Show details ></button>
        </div>
      </div>
    </form>
    @endforeach
  </div>
</div>
@endsection
