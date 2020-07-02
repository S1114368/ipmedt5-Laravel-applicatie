@extends('layouts.app')
@section('content')
<header>
  <h1 class="headerH1Text">Accounts</h1>
</header>

@foreach($users as $user)
@if($user->name == "Everyone")

@else
<form action="/home/delete" method="post"><!-- zorgt voor communicatie met backend door het form-->
  {{ csrf_field() }}
  {{ method_field('PATCH') }}<!--patch want het word geupdated-->
  <div class="contentScreen ">
    <div class="overviewItem">
      <p class="overviewText"><b>Name:</b> {{$user->name}}</p>
      <p class="overviewText"><b>User-ID:</b> {{$user->id}}</p>
      <input type="hidden" name="id" value="{{$user->id}}">
      @if($user->role == "admin")<!-- geen delete knop laten zien als de user admin is-->
      @elseif($user->id == 3)<!-- geen delete knop laten zien als de user everyone is is-->
      @else
      <button type="submit" class="overviewText blueButton" name="button">Delete account ></button>
      @endif
    </div>
  </div>
</form>
@endif
@endforeach
@if($deleted_at == 'null')

@elseif($deleted_at == 'notnull')
  <div class="buttonWrapper"><!--restored het verwijderde account-->
    <a class="blueButton " href="{{url('/home/admin/undo')}}">Restore removed accounts</a>
  </div>
@endif
@endsection
