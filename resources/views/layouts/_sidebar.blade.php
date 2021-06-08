<div class="list-group list-group-transparent mb-0">
    <a class="list-group-item list-group-item-action {{ setActive(['/']) }}" aria-current="page" href="{{ route('root_path') }}">
      <span class="icon mr-2">
        <i class="fas fa-home"></i>
      </span>
      Página inicial
    </a>

    <a class="list-group-item list-group-item-action {{ setActive(['edicts*']) }}" href="{{ route('public.edicts') }}">
      <span class="icon mr-2 h4">
        <i class="fas fa-file-alt"></i>
      </span>
      Editais
    </a>
</div>
