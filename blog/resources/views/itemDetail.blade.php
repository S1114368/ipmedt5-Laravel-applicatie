@extends('layouts.app')
@section('content')
  <header>
    <h1 class="headerH1Text">{{$data->naam}}</h1><!--pakt naam van item als titel-->
  </header>

  <div class="contentScreen">
    <div class="detailScreen">

      <form action="/home/edit" method="post" id="itemEditForm"><!-- zorgt voor communicatie met backend door het form-->
        {{ csrf_field() }}
        {{ method_field('PATCH') }}<!--patch want het word geupdated-->
        <img class="itemImageDetail" src="{{asset($data->image_url)}}" alt="">

        <span><p class="detailText">Name: <input class="detailTextInput" type="text" name="naam" value="{{$data->naam}}"></p></span>
        <span><p class="detailText">Expire Date: <input class="detailTextInput" type="date" name="houdbaarheidsdatum" value="{{$data->houdbaarheidsdatum}}"></p></span>
        <span><p class="detailText">Owned by: <br><select form="itemEditForm" name="user_id"  style="max-height: 100px!important; overflow: scroll!important;">
        @foreach ($users as $user)<option value="{{$user->id}}">{{$user->name}}</option>@endforeach</select></p></span><!-- elke user als waarde geven bij het editen-->


        <span><p class="detailText">Weight (gr): <input class="detailTextInput" type="text" name="gewicht_huidig" maxlength="6" value="{{$data->gewicht_huidig}}"></p></span>
        <span><p class="detailText">Shelf: <input class="detailTextInput" type="text" name="plank_positie" value="{{$data->plank_positie}}"></p></span>
        <span><p class="detailText">Barcode: <input class="detailTextInput" readonly type="text" name="barcode" value="{{$data->barcode}}"></p></span>
        <span><input type="hidden" name="id" value="{{$data->id}}">
        <button class="blueButton detailButton" name="button" type="submit" value="save">Save & Go back</button>
        <button class="redButton detailButton" name="button" type="submit" value="delete">Delete Item</button>
      </form>

    </div>
  </div>
</div>
@endsection
