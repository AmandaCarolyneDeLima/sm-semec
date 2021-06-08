@extends('layouts.admin.app')

@section('title', 'Unidades')
@section('content')

@component('components.index.header', ['base_search_path' => route('admin.units'),
                                       'new_url' => route('admin.new.unit'),
                                       'new_btn_name' => 'Nova Unidade']) @endcomponent

<div class="table-responsive mt-3">
  @component('components.index.page_entries_info', ['entries' => $units]) @endcomponent

  <table class="table card-table table-striped table-vcenter table-data">
    <thead>
      <tr>
        <th>Nome</th>
        <th>Endereço</th>
        <th>Telefone</th>
        <th>Categoria</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @each('admin.units._unit_row', $units, 'unit')
    </tbody>
  </table>
  <div class="mt-5 float-right flex-wrap">
    {!! prettyPaginationLinks($units->links()) !!}
  </div>
</div>
@endsection
