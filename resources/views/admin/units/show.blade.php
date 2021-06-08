@extends('layouts.admin.app')

@section('title', 'Unidade')
@section('content')

<div class="card">
  <div class="card-body">
  <p><strong>Nome: </strong> {{ $unit->name }}</p>
  <p><strong>Endereço: </strong> {{ $unit->address}}</p>
  <p><strong>Telefone: </strong> {{ $unit->phone }}</p>
  <p><strong>Categoria: </strong> {{ $unit->category->name}}</p>
  </div>
</div>

@component('components.links.back_and_edit', ['edit_url' => route('admin.edit.unit', $unit->id),
                                              'back_url' => route('admin.units')]) @endcomponent

@endsection
