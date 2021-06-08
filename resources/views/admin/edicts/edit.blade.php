@extends('layouts.admin.app')

@section('title', 'Editar Edital')
@section('content')

@include('admin.edicts._form', ['route' => route('admin.update.edict', $edict->id), 'method' => 'patch', 'submit' => 'Atualizar Edital'])

@endsection
