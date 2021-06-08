@extends('layouts.admin.app')
@section('title', 'Modificar Senha')

@section('content')

<form  action="{{route('admin.password.update')}}" method="POST" novalidate>
  @csrf
   @component('components.form.input_password', ['field'    => 'current_password',
                                                 'label'    => 'Senha Atual',
                                                 'hint'     => 'precisamos da sua senha atual para confirmar suas mudanças',
                                                 'model'    => 'user',
	                                               'required' => true,
                                                 'errors'   => $errors])
   @endcomponent


   @component('components.form.input_password', ['field'    => 'password',
                                                 'label'    => 'Nova Senha',
                                                 'model'    => 'user',
	                                               'required' => true,
                                                 'errors'   => $errors])
   @endcomponent

   @component('components.form.input_password', ['field'    => 'password_confirmation',
                                                 'label'    => 'Confirme a senha',
                                                 'model'    => 'user',
	                                               'required' => true,
                                                 'errors'   => $errors])
   @endcomponent

   @component('components.form.input_submit', ['value' => 'Alterar senha', 'back_url' => route('admin.dashboard')]) @endcomponent
</form>
@endsection
