@extends('layouts.admin.app')

@section('title', 'Novo Edital')
@section('content')

@include('admin.edicts._form', ['route' => route('admin.create.edict'), 'method' => 'POST', 'submit' => 'Criar Edital'])

@endsection
