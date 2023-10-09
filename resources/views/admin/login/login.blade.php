<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>HorseYard | Admin Login</title>
  <meta name="_token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('/admin/css/bootstrap.min.css') }}?v={{CSS_JS_VER}}">
  <link rel="stylesheet" href="{{ asset('/admin/css/login.css') }}?v={{CSS_JS_VER}}">
  <link rel="stylesheet" href="{{ asset('/admin/css/fonts.css') }}?v={{CSS_JS_VER}}">
  <link rel="stylesheet" href="{{ asset('/admin/css/custom.css') }}?v={{CSS_JS_VER}}">
</head>
<body>
<header>
  <div class="container-fluid">
    <div class="d-flex align-items-center flex-sm-wrap">
      <div class="logo">
        <a href="{{ url('dashboard')}}">          
          <img src="{{ asset('admin/images/login-logo.png') }}" alt="HorseYard">          
        </a>
      </div>
    </div>
  </div>
</header>
<div class="authscreen">
  <div class="authscreen-bg"></div>
  <div class="container">
    <div class="d-flex">
      <div class="mx-auto">
        @include('shared.errors')
        <form action="{{ url('siteadmin') }}" class="admin_login_form" method="post">
          @csrf
          <h1>Sign In</h1>
          <div class="form-field">
            <div class="form-group">
              <label htmlFor="">Email ID</label>
              <input type="text" class="form-control" placeholder="jon.doe@gmail.com" name="email" />
            </div>
          </div>
          <div class="form-field">
            <div class="form-group">
              <label htmlFor="">Password</label>
              <div class="withIcon">
                <input type="password" class="form-control" placeholder="Password" name="password" />
                <span class="icon viewPsw eye-slash"></span>
                <span class="icon viewPsw eye d-none"></span>
              </div>
              <div class="d-flex justify-content-end">
                <a href="{{ url('admin/forgotpassword')}}" class="blueLink midlink">Forgot Password?</a>
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-secondary btn-submit">Sign in</button>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript" src="{{ asset('/admin/custom_js_css/js/login.js') }}?v={{CSS_JS_VER}}"></script>
</body>
</html>
