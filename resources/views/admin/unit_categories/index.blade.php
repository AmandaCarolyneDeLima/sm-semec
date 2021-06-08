@extends('layouts.admin.app')

@section('title', 'Categorias de Unidades')
@section('content')

@component('components.index.header', ['base_search_path' => route('admin.unit_categories'),
                                       'new_url' => route('admin.new.unit_category'),
                                       'new_btn_name' => 'Nova Categoria']) @endcomponent

<div class="table-responsive mt-3">
@component('components.index.page_entries_info', ['entries' => $categories]) @endcomponent

  <table class="table card-table table-striped table-vcenter table-data">
    <thead>
      <tr>
        <th>Nome</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @each('admin.unit_categories._category_row', $categories, 'category')
    </tbody>
  </table>
  <div class="mt-5 float-right flex-wrap">
    {!! prettyPaginationLinks($categories->links()) !!}
  </div>
</div>
@endsection
