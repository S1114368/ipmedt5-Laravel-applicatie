@extends('layouts.app')

@section('content')

  <header>
    <h1 class="headerH1Text">Welcome</h1>
  </header>

 <div class="contentScreen">
   <div class="detailScreen">

    <h2 class="loginText gap">Login</h2>
    <!-- zorgt voor communicatie met backend door het form -->
    <form method="POST" action="{{ route('login') }}">
    @csrf
      <label for="email" class="col-md-4 col-form-label text-md-right loginLabel">{{ __('E-Mail Address') }}</label>
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror loginInput gap" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
        @error('email')<!-- Laat de error komen in rode text -->
          <span class="invalid-feedback loginText" role="alert">
            <strong>{{ $message }}</strong>
          </span>
        @enderror
        <label for="password" class="col-md-4 col-form-label text-md-right loginLabel">{{ __('Password') }}</label>
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror loginInput gap" name="password" required autocomplete="current-password">
        @error('password')<!--en weer -->
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
        @enderror
        <input class="form-check-input loginCheckbox" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
        <label class="form-check-label loginCheckLabel" for="remember">
          {{ __('Remember Me') }}
        </label>
        <button type="submit" class="btn btn-primary blueButton loginButton">
          {{ __('Login') }}
        </button>
      </form>
      <p class="loginNew">New?</p>
      <p class="loginNew gap"><a class="href" href="{{ __('register') }}"><u class="href">Register now</u></a></p>
    </div>
</div>
@endsection
