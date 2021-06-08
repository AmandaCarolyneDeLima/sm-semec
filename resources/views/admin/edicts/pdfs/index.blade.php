@extends('layouts.admin.app')

@section('title', 'Novo PDF')
@section('content')

<form action="{{route('admin.create.pdf', $edict->id)}}" method="POST" enctype="multipart/form-data" novalidate>
    @csrf

    @component('components.form.input_text', ['field'    => 'name',
                                              'label'    => 'Nome',
                                              'value'    => $pdf->name,
                                              'model'    => 'pdf',
                                              'required' => true,
                                              'errors'   => $errors]) @endcomponent

  @component('components.form.input_file',['field'    => 'pdf',
                                           'model'    => 'pdf',
                                           'required' => true,
                                           'errors'   => $errors]) @endcomponent

  @component('components.form.input_submit', ['value' => 'Adicionar PDF', 'back_url' => route('admin.edicts')]) @endcomponent
</form>

@isset($edict)
<div class="table-responsive mt-8">

  <table class="table card-table table-striped table-vcenter table-data">
    <thead>
      <tr>
        <th>Título</th>
        <th>Edital</th>
        <th>Criado em</th>
        <th>Atualizado em</th>
         <th></th>
      </tr>
    </thead>
    <tbody>
        @each('admin.edicts.pdfs._pdf_row', $edict->pdfs, 'pdfs')
    </tbody>
  </table>
</div>
@endisset

@endsection
