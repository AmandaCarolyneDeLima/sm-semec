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
    <link href="{{ asset(mix('assets/vendor/tabler/css/tabler-dashboard.css')) }}" rel="stylesheet">
    <link href="{{ asset(mix('assets/css/app.css')) }}" rel="stylesheet">
  </head>
  <body>
    <div class="page">
      <div class="flex-fill">
        @include('layouts/_header')

        <div class="my-3 my-md-5">
          <div class="container">

            <div class="page-header">
              <h1 class="page-title">
                @yield('title')
              </h1>
            </div>

            <div class="row">

              <div class="col-lg-3 order-lg-1 mb-4">
                @include('layouts/_sidebar')
              </div>

              <div class="col-lg-9">
                @include('shared/_flash')

                @yield('content')
              </div>
            </div>
          </div>
        </div>
      </div>
      @include('layouts/_footer')
    </div>
  </body>
</html>
