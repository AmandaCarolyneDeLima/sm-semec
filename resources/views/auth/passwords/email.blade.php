@extends('layouts.session')
@section('title', 'Esqueceu senha')

@section('content')

<form class="card" method="POST" action="{{ route($passwordEmailRoute) }}">
  @csrf
    <div class="card-body p-6">
      <div class="card-title">
          {{ __('Reset Password') }}
        </div>
        <p class="text-muted">{{ __('Enter your email address and your password will be reset and emailed to you.') }}</p>
        <div class="form-group">
          <label class="form-label" for="email">{{ __('E-Mail Address') }}</label>
          <input id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            @error('email')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
           @enderror
        </div>
    <div class="form-footer">
      <button type="submit" class="btn btn-primary btn-block">
        {{ __('Send Password Reset Link') }}
      </button>
    </div>
  </div>
</form>
<div class="text-center text-muted">{{ __('Forget it,')}} <a href="{{ route($loginRoute) }}">{{ __('send me back') }}</a> {{ __('to the sign in screen.')}} </div>

@endsection
