@extends('layouts.admin.app')

@section('title', 'Editar Administrador')
@section('content')

@include('admin.users._form', ['route' => route('admin.update.user', $user->id), 'method' => 'patch', 'submit' => 'Atualizar Admnistrador'])

@endsection
