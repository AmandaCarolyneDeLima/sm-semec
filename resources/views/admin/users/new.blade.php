@extends('layouts.admin.app')

@section('title', 'Novo Administrador')
@section('content')

@include('admin.users._form', ['route' => route('admin.create.user'), 'method' => 'POST', 'submit' => 'Criar Admnistrador'])

@endsection
