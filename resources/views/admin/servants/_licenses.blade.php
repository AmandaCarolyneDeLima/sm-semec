<h3><i>Licenças:</i></h3>
<div class="table-responsive">
  <table class="table table-striped table-vcenter">
    <thead>
      <tr>
        <th>Matrícula</th>
        <th>Data Início</th>
        <th>Data Término</th>
        <th>Tipo Licença</th>
        <th>Dias</th>
      </tr>
    </thead>
    <tbody>
      @foreach($servant->licenses as $license)
        <tr>
          <td>{{ $license->contract->registration }}</td>
          <td>{{ $license->started_at->toShortDate() }}</td>
          <td>{{ $license->ended_at->toShortDate() }}</td>
          <td>{{ $license->license_type }}</td>
          <td>{{ $license->days }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
