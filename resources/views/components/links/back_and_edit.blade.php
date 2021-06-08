<div class="d-flex">
  <a class="btn btn-secondary" href="{{ $back_url }}">{{ $back_name ?? 'Voltar'}}</a>
  @isset($edit_url)
    <a href="{{ $edit_url }}" class="btn btn-primary ml-auto">Editar</i></a>
  @endisset
</div>
