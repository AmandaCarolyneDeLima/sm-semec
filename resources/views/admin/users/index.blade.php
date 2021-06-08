@extends('layouts.admin.app')

@section('title', 'Administradores')
@section('content')

@component('components.index.header', ['base_search_path' => route('admin.users'),
                                       'new_url' => route('admin.new.user'),
                                       'new_btn_name' => 'Novo Administrador']) @endcomponent

<div class="table-responsive mt-3">
  <table class="table card-table table-striped table-vcenter table-data">
    <thead>
      <tr>
        <th>Nome</th>
        <th>Email</th>
        <th>Criado em</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @each('admin.users._user_row', $users, 'user')
    </tbody>
  </table>
</div>

@endsection
