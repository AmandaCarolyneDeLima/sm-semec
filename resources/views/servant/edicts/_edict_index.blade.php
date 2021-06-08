@component('components.index.header', ['base_search_path' => $base_search_path,
                                       'search_class' => 'col-sm-12 col-lg-12']) @endcomponent

@component('components.index.page_entries_info', ['entries' => $edicts]) @endcomponent


<ul class="nav nav-tabs mb-6">
  <li class="nav-item">
    <a class="nav-link {{ setActive('servant/edicts/open*') }}" href="{{ route('servant.edicts') }} ">Editais Abertos</a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ setActive('servant/edicts/close*') }}" href="{{ route('servant.edicts.close') }}" >Editais Fechados</a>
  </li>
</ul>


<div class="tab-content">
  <div role="tabPanel" class="tab-pane active " id="edicts-open" href="{{ route('servant.edicts.close') }}">
  <div class="table-responsive mt-3">
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
        @each($each, $edicts, 'edict')
      </tbody>
    </table>
    <div class="mt-5 float-right flex-wrap">
      {!! prettyPaginationLinks($edicts->links()) !!}
    </div>
  </div>
  </div>
</div>
