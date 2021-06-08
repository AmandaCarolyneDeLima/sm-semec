@extends('layouts.session')
@section('title', 'Modificar Senha')

@section('content')

<form class="card" method="POST" action="{{ route($passwordUpdateRoute) }}" >
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <div class="card-body p-4">

      <div class="card-title">{{ __('Reset Password')}}</div>
      <div class="form-group">
        <label class="form-label">{{ __('E-Mail Address')}}</label>
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
        @error('email')
        <span class="invalid-feedback" role="alert">
           <strong>{{ $message }}</strong>
        </span>
        @enderror
      </div>
      <div class="form-group">
        <label class="form-label">{{ __('New Password')}}</label>
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
      </div>
      <div class="form-group">
        <label class="form-label">{{ __('Confirm Password')}}</label>
        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
      </div>
      <div class="form-footer">
        <button type="submit" class="btn btn-primary btn-block">{{ __('Reset Password')}}</button>
      </div>
    </div>
</form>
@endsection
