<!-- Modal -->
<div class="modal fade" id="actsModal-{{ $contract->id }}" tabindex="-1" role="dialog" aria-labelledby="actsModalCenterTitle-{{ $contract->id }}" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="actsModalCenterTitle-{{ $contract->id }}">
          Atos do contrato {{ $contract->registration }}
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        </button>
      </div>
      <div class="modal-body">

        <div class="table-responsive">
          <table class="table table-striped table-vcenter">
            <thead>
              <tr>
                <th>Ato</th>
                <th>Início</th>
                <th>Fim</th>
                <th>Número</th>
                <th>Tempo</th>
              </tr>
            </thead>
            <tbody>
              @foreach($contract->acts as $act)
              <tr>
                <td> {{ $act->name }}</td>
                <td> {{ $act->started_at->toShortDate() }}</td>
                <td> {{ $act->ended_at->toShortDate() }}</td>
                <td> {{ $act->number }}</td>
                <td> {{ $act->time }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>
