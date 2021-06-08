@extends('layouts.admin.app')

@section('title', 'Servidores')
@section('content')

@component('components.index.header', ['base_search_path' => route('admin.servants')]) @endcomponent

@component('components.index.page_entries_info', ['entries' => $servants]) @endcomponent

<div class="table-responsive mt-3">
  <table class="table card-table table-striped table-vcenter">
    <thead>
      <tr>
        <th>Nome</th>
        <th>CPF</th>
        <th>
          <span data-toggle="tooltip" data-placement="top" title="Referente ao último contrato">
            Matrícula<i class="fas fa-info-circle d-inline ml-1"></i>
          </span>
        </th>
        <th>
          <span data-toggle="tooltip" data-placement="top" title="Referente ao último contrato">
            Cargo<i class="fas fa-info-circle d-inline ml-1"></i>
          </span>
        </th>
        <th>
          <span data-toggle="tooltip" data-placement="top" title="Referente ao último contrato">
            Local de trabalho<i class="fas fa-info-circle d-inline ml-1"></i>
          </span>
        </th>
      </tr>
    </thead>
    <tbody>
      @each('admin.servants._servant_row', $servants, 'servant')
    </tbody>
  </table>
</div>

<div class="mt-5 float-right flex-wrap">
  {!! prettyPaginationLinks($servants->links()) !!}
</div>

@endsection
