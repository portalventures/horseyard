@extends('front.layouts.master')
@section('title', explode("@",Auth()->user()->email)[0].' | Horseyard')
@section('canonical-content')
  <link rel="canonical" href="{{URL::current()}}"/>
@endsection
@section('css-content')    
  <link rel="stylesheet" href="{{ asset('/frontend/css/custom.min.css') }}?v={{CSS_JS_VER}}">  
  <link rel="stylesheet" href="{{ asset('/frontend/custom_js_css/css/custom.css') }}?v={{CSS_JS_VER}}"> 
@endsection

@section('content')
  <div id="main">
    <section id="inbox">
      <div class="container">
        <div class="d-block d-lg-none inbox-menu mb-3">
          <div class="d-flex align-items-center">
            <span class="icon inbox-menu mr-2"></span> Profile
          </div>
        </div>
        @include('front.account.account_layout.left_menu')
        <div class="inbox-right">
          <h3 class="create-listing-title d-flex align-items-center d-none d-lg-flex">
            <span class="icon profile"></span> profile
          </h3>
          <div class="card">
            <div class="card-content">
              @include('shared.errors')
              <div class="d-flex align-items-center justify-content-between">
                <h5 class="card-title">Basic info</h5>
                <a href="{{ url('edit-my-profile') }}" class="btn btn-primary">Edit</a>
              </div>
              <div class="info-details">
                <div class="row">
                  <div class="col col-12 col-md-3">
                    <label for="">First name</label>
                  </div>
                  <div class="col">
                    <p>{{ !empty(Auth()->user()->first_name) ? Auth()->user()->first_name : ''}}</p>
                  </div>
                </div>
                <div class="row">
                  <div class="col col-12 col-md-3">
                    <label for="">Last name</label>
                  </div>
                  <div class="col">
                    <p>{{ !empty(Auth()->user()->last_name) ? Auth()->user()->last_name : ''}}</p>
                  </div>
                </div>
                <div class="row">
                  <div class="col col-12 col-md-3">
                    <label for="">Gender</label>
                  </div>
                  <div class="col">
                    <p>{{ucfirst(Auth()->user()->gender)}}</p>
                  </div>
                </div>
                <div class="row">
                  <div class="col col-12 col-md-3">
                    <label for="">DOB</label>
                  </div>
                  <div class="col">
                    <p>{{ !empty(Auth()->user()->date_of_birth) ? date('d/m/Y', strtotime(Auth()->user()->date_of_birth)) : ''}}</p>
                  </div>
                </div>
              </div>
              <div class="d-flex align-items-center justify-content-between">
                <h5 class="card-title">Contact info</h5>
              </div>
              <div class="info-details">
                <div class="row">
                  <div class="col col-12 col-md-3">
                    <label for="">email</label>
                  </div>
                  <div class="col">
                    <p>{{ Auth()->user()->email }}</p>
                  </div>
                </div>
                <div class="row">
                  <div class="col col-12 col-md-3">
                    <label for="">Phone number</label>
                  </div>
                  <div class="col">
                    <p>{{ !empty(Auth()->user()->phone_number) ? Auth()->user()->phone_number : ''}}</p>
                  </div>
                </div>
                <div class="row">
                  <div class="col col-12 col-md-3">
                    <label for="">Company name</label>
                  </div>
                  <div class="col">
                    <p>{{ !empty(Auth()->user()->company_name) ? Auth()->user()->company_name : ''}}</p>
                  </div>
                </div>
                <div class="row">
                  <div class="col col-12 col-md-3">
                    <label for="">Address</label>
                  </div>
                  <div class="col">
                    <p>{{ !empty(Auth()->user()->address_line_1) ? Auth()->user()->address_line_1 : ''}}</p>
                  </div>
                </div>
                <div class="row">
                  <div class="col col-12 col-md-3">
                    <label for="">Suburb</label>
                  </div>
                  <div class="col">
                    <p>{{ !empty(Auth()->user()->suburb) ? get_suburb_name(Auth()->user()->suburb) : ''}}</p>
                  </div>
                </div>
                <div class="row">
                  <div class="col col-12 col-md-3">
                    <label for="">State</label>
                  </div>
                  <div class="col">
                    <p>{{ !empty(Auth()->user()->state) ? get_state_name(Auth()->user()->state) : ''}}</p>
                  </div>
                </div>
                <div class="row">
                  <div class="col col-12 col-md-3">
                    <label for="">Postcode</label>
                  </div>
                  <div class="col">
                    <p>{{ !empty(Auth()->user()->postal_code) ? Auth()->user()->postal_code : ''}}</p>
                  </div>
                </div>
                <div class="row">
                  <div class="col col-12 col-md-3">
                    <label for="">Password</label>
                  </div>
                  <div class="col">
                    <p>******</p>
                  </div>
                </div>
              </div>
              <a href="javascript:void(0)" data-toggle="modal" data-target="#changePassword" class="link"><span class="text-red">Change Password</span></a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
  <div class="modal" id="changePassword">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Change Password</h5>
        </div>
        <div class="modal-body">
          <form action="{{ url('user_change_password')}}" method="POST" class="user_change_password_form">
            @csrf
            <div class="form-group">
              <label for="">Old Password</label>
              <div class="withIcon">
                <input type="password" class="form-control" placeholder="Old password" name="oldpassword" id="oldpassword" required>
                <span class="viewPsw icon eye-slash"></span>
                <span class="viewPsw icon eye d-none"></span>
              </div>
            </div>
            <div class="form-group">
              <label for="">New Password</label>
              <div class="withIcon">
                <input type="password" class="form-control" placeholder="New password" name="new_password" id="new_password" required>
                <span class="viewPsw icon eye-slash"></span>
                <span class="viewPsw icon eye d-none"></span>
              </div>
            </div>
            <div class="form-group">
              <label for="">Confirm Password</label>
              <div class="withIcon">
                <input type="password" class="form-control" placeholder="Confirm password" name="confpassword" id="confpassword" required>
                <span class="viewPsw icon eye-slash"></span>
                <span class="viewPsw icon eye d-none"></span>
              </div>
            </div>
            <div class="d-flex justify-content-end align-items-center">
              <button type="submit" class="btn btn-primary">Save</button>
              <a href="javascript:void(0)" class="link ml-3" data-dismiss="modal"><span class="text-red">Cancel</span></a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@section('js-content')
  <script type="text/javascript" src="{{ asset('frontend/js/jquery-ui.min.js') }}?v={{CSS_JS_VER}}"></script>
  <script type="text/javascript" src="{{ asset('frontend/js/jquery.validate.min.js') }}?v={{CSS_JS_VER}}"></script>
  <script type="text/javascript" src="{{ asset('frontend/js/additional-methods.min.js') }}?v={{CSS_JS_VER}}"></script>
  <script type="text/javascript" src="{{ asset('frontend/js/moment.min.js') }}?v={{CSS_JS_VER}}"></script>
  <script type="text/javascript" src="{{ asset('frontend/js/bootstrap-datetimepicker.min.js') }}?v={{CSS_JS_VER}}"></script>
  <script type="text/javascript" src="{{ asset('frontend/js/sweetalert.min.js') }}?v={{CSS_JS_VER}}"></script>
  <script type="text/javascript" src="{{ asset('frontend/js/custom.min.js') }}?v={{CSS_JS_VER}}"></script>
@endsection  
@push('custom-scripts')
  <script type="text/javascript" src="{{ asset('/frontend/custom_js_css/js/profile.js') }}?v={{CSS_JS_VER}}"></script>
@endpush
