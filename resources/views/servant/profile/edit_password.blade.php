@extends('layouts.servant.app')
@section('title', 'Modificar Senha')

@section('content')

<form  action="{{route('servant.profile.password.update')}}" method="POST" novalidate>
  @csrf
   @component('components.form.input_password', ['field'    => 'current_password',
                                                 'label'    => 'Senha Atual',
                                                 'hint'     => 'precisamos da sua senha atual para confirmar suas mudanças',
                                                 'model'    => 'servant',
	                                               'required' => true,
                                                 'errors'   => $errors])
   @endcomponent


   @component('components.form.input_password', ['field'    => 'password',
                                                 'label'    => 'Nova Senha',
                                                 'model'    => 'servant',
	                                               'required' => true,
                                                 'errors'   => $errors])
   @endcomponent

   @component('components.form.input_password', ['field'    => 'password_confirmation',
                                                 'label'    => 'Confirme a senha',
                                                 'model'    => 'servant',
	                                               'required' => true,
                                                 'errors'   => $errors])
   @endcomponent

   @component('components.form.input_submit', ['value' => 'Alterar senha', 'back_url' => route('servant.dashboard')]) @endcomponent
</form>
@endsection
