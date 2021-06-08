@extends('layouts.admin.app')

@section('title', 'Editar Categorias')
@section('content')

@include('admin.unit_categories._form', ['route' => route('admin.update.unit_category', $category->id),
                                          'method' => 'patch', 'submit' => 'Atualizar Categoria'])

@endsection
