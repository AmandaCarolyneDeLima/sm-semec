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
    <script src="{{ asset(mix('/assets/js/app.js')) }}" defer></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset(mix('assets/vendor/tabler/css/tabler.min.css')) }}" rel="stylesheet">
    <link href="{{ asset(mix('assets/css/login/session.css')) }}" rel="stylesheet">
  </head>

  <body class="">
    <div class="page ">
      <div class="page-single ">
        <div class="container">
          <div class="row">

            <div class="col col-login mx-auto">

              <div class="text-center mb-3 ">
                <img src="{{ asset('assets/images/logo.png') }}" class="h-8" alt="">
              </div>

              @include('shared/_flash')

              @yield('content')

            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
