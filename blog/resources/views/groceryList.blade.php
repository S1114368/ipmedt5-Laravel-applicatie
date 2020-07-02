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
        <!--hier wordt je toegevoegde boodschappen weergegeven met naam en aantal  -->
        @foreach($boodschappenitems as $groceryitem)
        <form action="/home/grocerylist/delete" method="post">
          {{ csrf_field() }}
          {{ method_field('PATCH') }}
          <tr>
            <td class="groceryList__item__naam">{{ $groceryitem->naam }}</td>
            <td class="groceryList__item__amount">{{ $groceryitem->aantal }}</td>
            <td>
              <div class="buttonBoxGrocery">
                <button class="blueButtonEditItem" name="button" value="edit" type="submit">&#x270E;</button>
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
              <input required class="groceryLoginTextInput gap"type="text" name="productNaam" value="" placeholder="Product">
              <div class="scrollable">
                <select  required name="productAantal" style="max-height: 100px!important; overflow: scroll!important;">
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
