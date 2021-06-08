@if(Session::has('fail'))
  <div class="alert alert-warning alert-dismissible" role="alert alert-dismissible">
    <button type="button" class="close" data-dismiss="alert"></button>
    {{ Session::get('fail') }}
  </div>
@endif

@if(Session('success'))
  <div class="alert alert-success alert-dismissible" role="alert alert-dismissible">
    <button type="button" class="close" data-dismiss="alert"></button>
    {{ session('success') }}
  </div>
@endif

@if (session('status'))
  <div class="alert alert-success" role="alert alert-dismissible">
    <button type="button" class="close" data-dismiss="alert"></button>
    {{ session('status') }}
  </div>
@endif

@if (session('danger'))
  <div class="alert alert-danger" role="alert alert-dismissible">
    <button type="button" class="close" data-dismiss="alert"></button>
    {{ session('danger') }}
  </div>
@endif
