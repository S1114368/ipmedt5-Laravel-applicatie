@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="/home" method="post">
                      {{ csrf_field() }}
                      <input type="text" name="item" value="">
                      <input type="text" name="name" value="">
                      <button type="submit" name="button">Add item</button>
                    </form>


                    <form action="/home" method="delete">
                     <select class="" name="user">
                       @foreach($users as $user)
                        <option value={{$user->name}}>{{$user->name}}</option>
                        @endforeach
                      </select>
                      <button type="submit" name="button" method="delete">Delete account</button>
                    </form>
                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
