@extends('layouts.session')
@section('title', 'Login')
@section('content')

<form class="card" action="{{route($loginRoute)}}" method="POST">
    @csrf

    <div class="card-body p-4">

      <div class="card-title">{{ __('Login to your account')}}</div>
      <div class="form-group">
        <label class="form-label">{{ __('CPF')}}</label>
        <input type="number" class="form-control" id="cpf" name="CPF" aria-describedby="emailHelp" placeholder="CPF" autofocus="">
    </div>

    <div class="form-group">
        <label class="form-label">{{ __('Password')}}</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
    </div>
    <div class="form-group">
        <label class="custom-control custom-checkbox">
          <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
          <span class="form-check-label remember ml-1" for="remember">
            {{ __('Remember Me')}}
        </span>

    </label>
    </div>
    <div class="form-footer">
        <button type="submit" class="btn btn-primary btn-block">{{ __('Login')}}</button>
          @if (Route::has('password.request'))
        <a class="btn-link float-right" href="{{ route($forgotPasswordRoute) }}"> {{ __('Forgot Your Password?') }} </a>
         @endif
    </div>
    </div>
</form>
@endsection
