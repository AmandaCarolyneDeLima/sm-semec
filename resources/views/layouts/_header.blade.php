<div class="fixed-top header py-4">
  <div class="container-fluid">
    <div class="d-flex">
      <a class="header-brand mr-0" href="/">
        <img src="{{ asset('assets/images/brasao-prefeitura.png') }}" class="header-brand-img" alt="tabler logo">
      </a>
      <span class="d-lg-block mt-1 text-muted font-weight-bold">
        SEMEC
      </span>
      <div class="d-flex order-lg-2 ml-auto">
        <div class="dropdown">
          <a href="#" class="btn btn-outline-primary" data-toggle="dropdown">
            Entrar
          </a>
          <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
            <a class="dropdown-item" href="{{ route('admin.dashboard') }}"> <i class="dropdown-icon fa fa-user-circle-o"></i> Administrador </a>
            <a class="dropdown-item" href="{{ route('servant.dashboard') }}"> <i class="dropdown-icon fas fa-user"></i> Servidor </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
