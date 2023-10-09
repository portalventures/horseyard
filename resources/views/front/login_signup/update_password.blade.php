@extends('front.layouts.master')
@section('title', 'Horseyard | Change Password')
@section('css-content')  
  <link rel="stylesheet" type="text/css" href="{{ asset('/frontend/css/sweetalert.min.css') }}?v={{ CSS_JS_VER }}">  
  <link rel="stylesheet" href="{{ asset('/frontend/css/custom.min.css') }}?v={{ CSS_JS_VER }}">
  <link rel="stylesheet" href="{{ asset('/frontend/css/login.min.css') }}?v={{ CSS_JS_VER }}">
  <link rel="stylesheet" href="{{ asset('/frontend/custom_js_css/css/custom.css') }}?v={{ CSS_JS_VER }}"> 
@endsection
@section('content')
  <div class="authscreen">
    <div class="authscreen-bg"></div>
    <div class="container">
      <div class="d-flex w-100 flex-sm-wrap flex-sm-col">
        <div class="col authInfo">
          <h2>Member Features</h2>
          <p>Becoming a member on Horseyard unlocks a range of benefits.</p>
          <ul>
            <li>Place a list for your horse, vehicle, property or horse tack.</li>
            <li>Manage and update all your ads in the one place.</li>
            <li>Manage and update all your ads in the one place.</li>
            <li>Communicate with buyers and sellers using our secure messaging platform.</li>
            <li>Favoties ads you're most interested in and come back and review them anywehere, anytime.</li>
            <li>Save and manage your favorite searches in one place.</li>
            <li>Get notified for any message posted on your listing.</li>
          </ul>
        </div>
        <div class="col">
          @include('shared.errors')
          <form action="{{ url('changepassword') }}" class="change_password_form" method="post">
            @csrf
            <h1>Change password</h1>
            <input type="hidden" name="token" value="{{ $getauthuser_details->token }}" />
            <div class="form-field">
              <div class="form-group">
                <label for="password">Password</label>
                <div class="withIcon">
                  <input type="password" class="form-control" placeholder="Password" id="password" name="password" />
                  <span class="viewPsw icon eye-slash d-none"></span>
                  <span class="viewPsw icon eye"></span>
                </div>
              </div>
            </div>
            <div class="form-field">
              <div class="form-group">
                <label for="confpassword">Confirm Password</label>
                <div class="withIcon">
                  <input type="password" class="form-control" placeholder="Confirm password" id="confpassword" name="confpassword" />
                  <span class="viewPsw icon eye-slash d-none"></span>
                  <span class="viewPsw icon eye"></span>
                </div>
              </div>
            </div>
            <div class="form-field">
              <div class="form-group">
                <button type="submit" class="btn btn-submit">Change password</button>
              </div>
            </div>
            <!-- <span class="separater">
              <span>Or</span>
            </span>
            <a href="{{ url('auth/google') }}" class="blockLink">
              <span class="icon google"></span> Sign In with Google
            </a> -->
            <div class="form-field">
              <div class="form-group">
                <p class="auth-footer">Not a member yet?&nbsp;<a href="{{ url('signup')}}" class="blueLink">Sign Up</a></p>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('js-content')  
  <script type="text/javascript" src="{{ asset('frontend/js/jquery-ui.min.js') }}?v={{ CSS_JS_VER }}"></script>
  <script type="text/javascript" src="{{ asset('frontend/js/jquery.validate.min.js') }}?v={{ CSS_JS_VER }}"></script>
  <script type="text/javascript" src="{{ asset('frontend/js/additional-methods.min.js') }}?v={{ CSS_JS_VER }}"></script>  
  <script type="text/javascript" src="{{ asset('frontend/js/sweetalert.min.js') }}?v={{ CSS_JS_VER }}"></script>
  <script type="text/javascript" src="{{ asset('frontend/js/custom.min.js') }}?v={{ CSS_JS_VER }}"></script>
@endsection
@push('custom-scripts')
<script type="text/javascript" src="{{ asset('/frontend/custom_js_css/js/login_signup.js') }}?v={{CSS_JS_VER}}"></script>
@endpush
