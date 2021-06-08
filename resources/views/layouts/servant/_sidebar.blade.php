 <div id="headerMenuCollapse" class="col-sm-12 col-md-3 col-lg-2 collapse d-md-flex align-items-start" >
  <div class="list-group list-group-transparent mb-2 sidebar">
    <span class="sidebar-heading pl-0 pt-2 pb-2">
      <i class="fas fa-compass mr-2"></i>
      Servidores
    </span>

    <a class="list-group-item list-group-item-action {{ setActive(['servant']) }}" aria-current="page" href="/servant">
      <span class="icon mr-2">
        <i class="fas fa-home"></i>
      </span>
      Página inicial
    </a>

    <a class="list-group-item list-group-item-action {{ setActive(['servant/edicts*']) }}" href="{{ route('servant.edicts') }}">
      <span class="icon mr-2 h4">
      <i class="fas fa-file-alt"></i>
      </span>
      Editais
    </a>
  
  </div>
</div>
