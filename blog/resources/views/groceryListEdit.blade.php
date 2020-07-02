@extends('layouts.app')
@section('content')
  <header>
      <h1 class="headerH1Text">Grocery List</h1>
  </header>
<div class="wrapperGroceryList">
  <div class="groceryListGrid">
    <div class="gridScreen box a ">
      <h2 class="boxHeader">Your grocery list</h2>
      @csrf
      <table id= "groceryListContent">
        <tr>
          <th>Product</th>
          <th>Amount</th>
        </tr>
        <!-- Hier worden de laatste 3 items die zijn uitegscanned weergegeven -->
        @foreach($boodschappenitems as $groceryitem)
        <form action="/home/grocerylist/editItem" method="post">
          {{ csrf_field() }}
          {{ method_field('PATCH') }}
          <tr>
            <td><input name="naam" value="{{ $groceryitem->naam }}"class="groceryList__item__edit"></input></td>
            <input type="hidden" name="itemEdit" value="{{ $groceryitem->naam }}">
            <td>
              <div class="scrollableEdit">
                <select name="aantal" style="max-height: 100px!important; overflow: scroll!important;">
                  <option value="{{$groceryitem->aantal}}">{{$groceryitem->aantal}}</option>
                  @for($i = 1; $i <= 50; $i++)
                  <option value={{$i}}>{{$i}}</option>
                  @endfor
                </select>
              </div>
            </td>
            <td>
              <div class="buttonBoxGrocery">
                <button class="blueButtonEditItem" name="button" value="edit" type="submit">&#10003;</button>
                <input type="hidden" name="itemNaam" value="{{$groceryitem->naam}}">
                <button class="redButtonRemoveItem" name="button" value="remove" type="submit">-</button>
              </div>
            </td>
          </tr>
      </form>
      @endforeach
    </table>
    </div>
    <div class="box b">

      <div class="gridScreen box d">
        <!-- Hier worden de laatste 3 items die zijn uitegscanned weergegeven -->
        <h2 class="boxHeader">Recently removed items</h2>
        <div class="box e">
        @foreach($deletedItems as $item)
        <form class="box f" action="/home/grocerylist/add" method="post">
          {{ csrf_field() }}
          {{ method_field('PATCH') }}

            <div class = "box g">
              <div class = "overviewRemovedItems">
                <input type="hidden" name="productNaam" value="{{$item->naam}}">
                <input type="hidden" name="productAantal" value="1">
                <input type="hidden" name="product_id" value="{{$item->id}}">
                <img class="recentlyRemoved__item__image" src="{{asset($item->image_url)}}" alt="">
                <p class="recentlyRemoved__item">{{$item->naam}}</p>
                <div class="buttonBox">
                  <button type="submit" class="blueButton recentlyRemoved__blueButtonAddItem">+</button>
                </div>
              </div>
            </div>
        </form>
        @endforeach
      </div>
      </div>

      <div class="gridScreen box c ">
        <h2 class="boxHeader">Add it yourself</h2>
          <div class="addItYourselfItemBox">
            <form action="/home/grocerylist/add" method="post">
              {{ csrf_field() }}
              {{ method_field('PATCH') }}
              <input class="groceryLoginTextInput gap"type="text" name="productNaam" value="" placeholder="Product">
              <div class="scrollable">
                <select name="productAantal" style="max-height: 100px!important; overflow: scroll!important;">
                  <option value="Quantity">Quantity</option>
                  @for($i = 1; $i <= 50; $i++)
                  <option value={{$i}}>{{$i}}</option>
                  @endfor
                </select>
              </div>
              <div class="addGroceryBox">
              <button class="blueButtonAddGrocery" type="submit">+ Add</button>
              </div>
            </form>
          </div>
      </div>
    </div>
  </div>
</div>
@endsection
