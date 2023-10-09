<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/admin/images/favicon.png') }}?v={{CSS_JS_VER}}">
  <title>Horseyard | Admin</title>
  <link rel="stylesheet" type="text/css" href="{{ asset('/admin/css/bootstrap.min.css') }}?v={{CSS_JS_VER}}">
  <link rel="stylesheet" type="text/css" href="{{ asset('/admin/css/select2.min.css') }}?v={{CSS_JS_VER}}">
  <link rel="stylesheet" type="text/css" href="{{ asset('/admin/css/fonts.css') }}?v={{CSS_JS_VER}}">  
  <link rel="stylesheet" type="text/css" href="{{ asset('/admin/css/materialize-stepper.min.css') }}?v={{CSS_JS_VER}}">
  <link rel="stylesheet" type="text/css" href="{{ asset('/admin/css/sweetalert.css') }}?v={{CSS_JS_VER}}">
  <link rel="stylesheet" type="text/css" href="{{ asset('/admin/css/quill.snow.css') }}?v={{CSS_JS_VER}}">
  <link rel="stylesheet" type="text/css" href="{{ asset('/admin/css/custom.css') }}?v={{CSS_JS_VER}}">
  <link rel="stylesheet" type="text/css" href="{{ asset('/admin/custom_js_css/css/custom.css') }}?v={{CSS_JS_VER}}">
</head>
<body>
  <div id="main" class="d-flex">
    <div class="leftColumn">
      <div class="brand-logo">
        <a href="{{ url('admin/dashboard')}}" class="d-flex align-items-center">
          <img src="{{ asset('admin/images/logo.png') }}" alt="HorseYard" class="img-fluid main" />
          <img src="{{ asset('admin/images/logo-collapse.png') }}" alt="HorseYard" class="img-fluid collapsed" />
          <span class="collapse-icon icon arrow"></span>
        </a>
      </div>
      @include('admin.layouts.leftnav')
    </div>
    <div class="rightColumn">
      <header>
        <div class="d-flex align-items-center justify-content-between w-100">
          <h1 class="page-title">@yield('pagetitle', 'Dashboard')</h1>
          <p class="welcome-text m-0 d-flex align-items-center">
            Welcome, @if(Auth()->user()->first_name != "")
              {{Auth()->user()->first_name}} {{Auth()->user()->last_name}}
            @else
              {{explode('@',Auth()->user()->email)[0]}}
            @endif <span class="icon user ml-3"></span></p>
        </div>
      </header>
      @yield('content')
    </div>
  </div>

  @include('admin.layouts.js_list')
  @stack('plugin-scripts')
  @stack('custom-scripts')
</body>
</html>
