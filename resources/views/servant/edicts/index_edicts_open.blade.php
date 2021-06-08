@extends('layouts.servant.app')

@section('title', 'Editais')
@section('content')

  @include('servant.edicts._edict_index', ['each' => 'servant.edicts._edict_open_row',
                                           'base_search_path' => route('servant.edicts')])

@endsection
