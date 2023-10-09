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
        <a href="index.html">          
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
        <form action="{{ url('admin/forgotpassword') }}" class="admin_forgot_password_email_verify" method="post">
          @csrf
          <h1>Verify your email address</h1>
          <div class="form-field">
            <div class="form-group">
              <label htmlFor="">Email ID</label>
              <input type="text" class="form-control" placeholder="jon.doe@gmail.com" name="email" />
            </div>
          </div>
          <button type="submit" class="btn btn-secondary btn-submit">Verify</button>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript" src="{{ asset('/admin/custom_js_css/js/login.js') }}?v={{CSS_JS_VER}}"></script>
</body>
</html>
