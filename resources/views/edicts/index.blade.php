@extends('layouts.app')

@section('title', 'Lista de Editais')
@section('content')

@foreach ($edicts as $year => $edicts)
  <div class="card mb-2" id="accordion">

    <div class="card-header collapse-edicts" id="edict">
        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#edict{{$year}}" aria-expanded="false" aria-controls="edict">
          {{$year}}
        </button>
    </div>

    <div id="edict{{$year}}" class="collapse" aria-labelledby="edict" data-parent="#accordion">
          @foreach ($edicts as $edict)
      <div class="card-header collapse-edicts d-flex ml-2" id="edict">
          <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#edict{{$edict->id}}" aria-expanded="false" aria-controls="edict">
            {{$edict->title}}
          </button>
          <span class='text-muted small ml-auto'>Período: {{ $edict->started_at->toShortDateTime() }} - {{ $edict->ended_at->toShortDateTime() }}</span>
      </div>

      <div id="edict{{$edict->id}}" class="collapse">
        <div class="card-body m-2 border">
            @each('edicts._edict_row', $edict->pdfs, 'pdf')
        </div>
      </div>
          @endforeach
    </div>
  </div>
@endforeach

@endsection
