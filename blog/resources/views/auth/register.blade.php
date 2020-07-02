@extends('layouts.app')

@section('content')
<header>
  <h1 class="headerH1Text">Welcome</h1>
</header>

<div class="contentScreen">
 <div class="detailScreen">
    <h2 class="loginText gap">{{ __('Register') }}</h2>
    <!-- zorgt voor communicatie met backend door het form -->
    <form method="POST" action="{{ route('register') }}">
    @csrf
      <label for="name" class="col-md-4 col-form-label text-md-right loginLabel">{{ __('Name') }}</label>
      <input id="name" type="text" class="form-control @error('name') is-invalid @enderror loginInput gap" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
      @error('name')<!--error text in rood laten komen-->
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
      @enderror
      <label for="email" class="col-md-4 col-form-label text-md-right loginLabel">{{ __('E-Mail Address') }}</label>
      <input id="email" type="email" class="form-control @error('email') is-invalid @enderror loginInput gap" name="email" value="{{ old('email') }}" required autocomplete="email">
      @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
      @enderror
      <label for="password" class="col-md-4 col-form-label text-md-right loginLabel">{{ __('Password') }}</label>
      <input id="password" type="password" class="form-control @error('password') is-invalid @enderror loginInput gap" name="password" required autocomplete="new-password">
      @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
      @enderror
      <label for="password-confirm" class="col-md-4 col-form-label text-md-right loginLabel">{{ __('Confirm Password') }}</label>
      <input id="password-confirm" type="password" class="form-control loginInput gap" name="password_confirmation" required autocomplete="new-password">

      <button type="submit" class="btn btn-primary blueButton loginButton">
        {{ __('Register') }}
      </button>
    </form>
    <p class="loginNew">Not new?</p>
    <p class="loginNew gap"><a class="href" href="{{ __('login') }}"><u class="href">Login</u></a></p>
  </div>
</div>
@endsection
