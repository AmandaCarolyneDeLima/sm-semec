@extends('layouts.admin.app')

@section('title', "Servidor $servant->name")
@section('content')

<div class="card">
  <div class="card-body">
    <p><strong>Nome:</strong>       {{ $servant->name }}</p>
    <p><strong>Nascimento:</strong> {{ $servant->birthed_at }}</p>
    <p><strong>Natural de:</strong> {{ $servant->natural_from }}</p>
    <p><strong>Est. Civil:</strong> {{ $servant->marital_status }}</p>
    <p><strong>Nome Mãe:</strong>   {{ $servant->mother_name }}</p>
    <p><strong>Nome Pai:</strong>   {{ $servant->father_name }}</p>
    <p><strong>CPF:</strong>        {{ $servant->CPF }}</p>
    <p><strong>RG:</strong>         {{ $servant->RG }}</p>
    <p><strong>PIS:</strong>        {{ $servant->PIS }}</p>
    <p><strong>CTPS:</strong>       {{ $servant->CTPS }}</p>
    <p><strong>Título:</strong>     {{ $servant->title }}</p>
    <p><strong>Endereço:</strong>   {{ $servant->address }}</p>
    <p><strong>Fone:</strong>       {{ $servant->phone }}</p>
    <p><strong>E-mail:</strong>     {{ $servant->email }}</p>
    <p><strong>Criado em:</strong>  {{ $servant->created_at->toShortDateTime() }}</p>
    <p><strong>Atualizado em:</strong> {{ $servant->updated_at->toShortDateTime() }}</p>

    @include('admin/servants/_contracts')
    <br/>
    @include('admin/servants/_dependents')
    <br/>
    @include('admin/servants/_licenses')
  </div>

  <div class="card-footer">
    @component('components.links.back_and_edit', ['back_url' => route('admin.servants')]) @endcomponent
  </div>
</div>

@endsection
