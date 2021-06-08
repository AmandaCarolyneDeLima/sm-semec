@extends('layouts.admin.app')

@section('title', 'Administrador')
@section('content')

<div class="card">
  <div class="card-body">
    <img class="card-profile-img mt-1" src="{{ $user->image_path }}">
    <p><strong>Nome: </strong> {{ $user->name }}</p>
    <p><strong>Email: </strong> {{ $user->email }}</p>
    <p><strong>Criado em: </strong> {{ $user->created_at->toShortDateTime() }}</p>
    <p><strong>Atualizado em: </strong> {{ $user->updated_at->toShortDateTime() }}</p>
  </div>
</div>

@component('components.links.back_and_edit', ['edit_url' => route('admin.edit.user', $user->id),
                                              'back_url' => route('admin.users')]) @endcomponent

@endsection
