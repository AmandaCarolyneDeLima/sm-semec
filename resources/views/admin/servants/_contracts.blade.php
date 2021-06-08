:<h3><i>Contratos:</i></h3>
<div class="table-responsive">
  <table class="table table-striped table-vcenter">
    <thead>
      <tr>
        <th>Mátricula</th>
        <th>Cargo</th>
        <th>Secretaria</th>
        <th>Local</th>
        <th>Vínculo</th>
        <th>Data Admissão</th>
        <th>Data de Rescisão</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @foreach($servant->contracts as $contract)
      <tr>
        <td>{{ $contract->registration }}</td>
        <td>{{ $contract->role }}</td>
        <td>{{ $contract->secretary }}</td>
        <td>{{ $contract->place }}</td>
        <td>{{ $contract->link }}</td>
        <td>{{ $contract->admission_at->toShortDate() }}</td>
        <td>{{ $contract->termination_at->toShortDate() }}</td>
        <td>
          <button type="button" class="btn btn-link" data-toggle="modal" data-target="#actsModal-{{ $contract->id }}">
            Atos
          </button>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

@foreach($servant->contracts as $contract)
  @include('admin.servants._acts')
@endforeach


