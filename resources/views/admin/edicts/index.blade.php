@extends('layouts.admin.app')

@section('title', 'Editais')
@section('content')

@component('components.index.header', ['base_search_path' => route('admin.edicts'),
                                       'new_url' => route('admin.new.edict'),
                                       'new_btn_name' => 'Novo Edital']) @endcomponent

<div class="table-responsive mt-3">
@component('components.index.page_entries_info', ['entries' => $edicts]) @endcomponent

  <table class="table card-table table-striped table-vcenter table-data">
    <thead>
      <tr>
        <th>Título</th>
        <th>Aberto em</th>
        <th>Válido até</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @each('admin.edicts._edict_row', $edicts, 'edict')
    </tbody>
  </table>
  <div class="mt-5 float-right flex-wrap">
    {!! prettyPaginationLinks($edicts->links()) !!}
  </div>
</div>
@endsection
