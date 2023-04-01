<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  
  <title>{{ config('app.name', 'Laravel')}} | {{ $title }}</title>
  <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">
  <!-- Fonts -->
  @include('layouts._style')
</head>

<body class="hold-transition sidebar-mini layout-fixed text-sm">
  <div class="wrapper">
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="{{ asset('img/logokotak.png') }}" alt="AdminLTELogo" height="60" width="60">
    </div>
    @include('layouts.header')
    @if (Auth::check())
    @include('layouts.sidebar')
    @endif
    <div class="content-wrapper">
      @yield('content')
    </div>
    @include('layouts.footer')
  </div>

  @include('layouts._scripts')
  @stack('script')
</body>

</html>