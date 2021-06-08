@extends('layouts.admin.app')

@section('title', 'Editar Unidade')
@section('content')

@include('admin.units._form', ['route' => route('admin.update.unit', $unit->id), 'method' => 'patch', 'submit' => 'Atualizar Unidade'])

@endsection
