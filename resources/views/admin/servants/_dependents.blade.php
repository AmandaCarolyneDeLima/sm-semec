<h3><i>Dependentes:</i></h3>
<div class="table-responsive">
  <table class="table table-striped table-vcenter">
    <thead>
      <tr>
        <th>Nome</th>
        <th>Nascimento</th>
        <th>Grau</th>
        <th>Estuda</th>
        <th>Trabalha</th>
      </tr>
    </thead>
    <tbody>
      @foreach($servant->dependents as $dependent)
        <tr>
          <td>{{ $dependent->name }}</td>
          <td>{{ $dependent->birthed_at->toShortDate() }}</td>
          <td>{{ $dependent->degree }}</td>
          <td>{{ $dependent->study }}</td>
          <td>{{ $dependent->works }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
