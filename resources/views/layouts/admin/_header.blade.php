<div class="fixed-top header py-4">
  <div class="container-fluid">
    <div class="d-flex">
      <a class="header-brand mr-0" href="./index.html">
        <img src="{{ asset('assets/images/brasao-prefeitura.png') }}" class="header-brand-img" alt="tabler logo">
      </a>
      <span class="d-lg-block mt-1 text-muted font-weight-bold">
        SEMEC
      </span>
      <div class="d-flex order-lg-2 ml-auto">
        <div class="dropdown">
          <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">

            <span class="avatar" style="background-image: url({{ auth()->user()->image_path }})"></span>

            <span class="ml-2 d-none d-lg-block">
              <span class="text-default">  {{ Auth::user()->name }}</span>
              <small class="text-muted d-block mt-1">  {{ Auth::user()->email }}</small>
            </span>
          </a>
          <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
            <a class="dropdown-item" href="{{route('admin.profile.edit')}}"> <i class="dropdown-icon far fa-user"></i>  Meu Perfil </a>
            <a class="dropdown-item" href="{{route('admin.password.edit')}}"> <i class="dropdown-icon fas fa-unlock-alt"></i>Alterar Senha</a>
            <a class="dropdown-item" rel="nofollow" data-method="delete" href="{{ route('admin.logout') }}" id="logout"> <i class="dropdown-icon fas fa-sign-out-alt"></i> {{__('Logout') }}
            </a>
          </div>
        </div>
      </div>
      <a href="#" class="header-toggler d-lg-none d-md-none ml-3" data-toggle="collapse" data-target="#headerMenuCollapse" aria-expanded="true">
        <i class= "header-toggler-icon"></i>
      </a>
    </div>
  </div>
</div>
