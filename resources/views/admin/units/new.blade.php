@extends('layouts.admin.app')

@section('title', 'Nova Unidade')
@section('content')

@include('admin.units._form', ['route' => route('admin.create.unit'), 'method' => 'POST', 'submit' => 'Criar Unidade'])

@endsection
