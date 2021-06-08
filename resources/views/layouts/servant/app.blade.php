<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('shared/_favicon')

    <title>@include('shared/_full_title')</title>

     <!--Icons-->
     <script src="https://kit.fontawesome.com/826671e166.js" crossorigin="anonymous"></script>

    <!-- Scripts -->
    <script src="{{ asset(mix('assets/js/servants/app.js')) }}" defer></script>
    <script src="{{ asset(mix('assets/vendor/selectize/js/selectize.min.js')) }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset(mix('assets/vendor/tabler/css/tabler-dashboard.css')) }}" rel="stylesheet">
    <link href="{{ asset(mix('assets/css/servants/app.css')) }}" rel="stylesheet">
</head>
<body>
  <div id="app" class="page">
    <div class="page-main">
      <div class="container-fluid m-0">
        <div class="row">

          @include('layouts/servant/_header')
          @include('layouts/servant/_sidebar')

          <div class="col-md-9 col-lg-10">

            @include('shared/_breadcrumbs')

            <div class="card" id="main-card">
              <div class="card-header">
                <h1 class="page-title mb-3">
                  @yield('title')
                </h1>
              </div>

              <div class="card-body">
                @include('shared/_flash')
                @yield('content')
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
