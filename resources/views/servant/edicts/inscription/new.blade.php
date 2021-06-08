@extends('layouts.servant.app')

@section('title', 'Inscreva-se')

@section('content')

<form action="{{route('servant.create.inscription', $edict->id)}}" method="post" novalidate>

  @csrf

  @component('components.form.input_select',['field' => 'contract_id',
             'label'    => 'Matrícula',
             'model'    => 'inscription',
             'value'    => $inscription->contract_id,
             'options'  => $contracts,
             'default'  => 'Selecione uma Matricula:',
             'value_method' => 'id',
             'label_method' => 'registration',
             'required' => true,
             'errors'   => $errors]) @endcomponent

  @component('components.form.input_select',['field' => 'removal_type_id',
             'label'    => 'Tipo de remoção',
             'model'    => 'inscription',
             'value'    => $inscription->removal_type_id,
             'options'  => $removal_types,
             'default' => 'Selecione um Tipo de Remoção:',
             'value_method' => 'id',
             'label_method' => 'name',
             'required' => true,
             'errors'   => $errors]) @endcomponent

  @component('components.form.input_text',['field' => 'current_unit_id',
             'label'    => 'Unidade atual',
             'model'    => 'inscription',
             'value'    => $inscription->currentUnit->name,
             'disabled' => 'disabled',
             'required' => true,
             'errors'   => $errors]) @endcomponent

  @component('components.form.input_select',['field' => 'interested_unit_id',
             'label'    => 'Unidade de interesse',
             'model'    => 'inscription',
             'value'    => $inscription->interested_unit_id,
             'options'  => $units,
             'default'  => 'Selecione uma Unidade:',
             'required' => true,
             'errors'   => $errors]) @endcomponent

  @component('components.form.input_textarea',['field' => 'reason',
             'label'    => 'Motivo',
             'model'    => 'inscription',
             'value'    => $inscription->reason,
             'required' => true,
             'errors'   => $errors]) @endcomponent

   @component('components.form.input_submit', ['value' => 'Enviar', 'back_url' => route('servant.edicts')]) @endcomponent
</form>
@endsection
