<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  
  <title>{{ config('app.name', 'Laravel')}} | {{ $title }}</title>
  <link rel="icon" href="{{ asset('img/logo putih.png') }}" type="image/x-icon">
  <!-- Fonts -->
  @include('layouts._style')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="{{ asset('img/logokotak.png') }}" alt="AdminLTELogo" height="60" width="60">
    </div>
    @include('layouts.header')
    @if (Auth::check())
    @include('layouts.sidebar')
    @endif
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <!-- Main content -->
      @yield('content')
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
      <div class="p-3">
        <h5>Title</h5>
        <p>Sidebar content</p>
      </div>
    </aside>
    <!-- /.control-sidebar -->
    @include('layouts.footer')
  </div>

  @include('layouts._scripts')
  @stack('script')
</body>

</html>