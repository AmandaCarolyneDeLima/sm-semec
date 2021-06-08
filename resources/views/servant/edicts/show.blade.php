@extends('layouts.servant.app')

@section('title', 'Edital')
@section('content')

<div class="card">
  <div class="card-body">
    <p><strong>Título: </strong> {{ $edict->title }}</p>
    <p><strong>Decrição: </strong></p>
    {!! nl2br($edict->description) !!}
    <p></p>
    <p><strong>Aberto em: </strong> {{ $edict->started_at->toShortDateTime() }}</p>
    <p><strong>Válido até: </strong> {{ $edict->ended_at->toShortDateTime() }}</p>
  </div>
</div>

@component('components.links.back_and_edit', ['back_url' => route('servant.edicts')]) @endcomponent

@endsection
