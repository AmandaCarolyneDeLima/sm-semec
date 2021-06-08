@extends('layouts.admin.app')

@section('title', 'Nova Categoria')
@section('content')

@include('admin.unit_categories._form', ['route' => route('admin.create.unit_category'), 'method' => 'POST', 'submit' => 'Criar Categoria'])

@endsection
