@extends('front.layouts.master')
@section('title', 'Horseyard | Edit Profile')
@section('canonical-content')
  <link rel="canonical" href="{{URL::current()}}"/>
@endsection
@section('css-content')
  <link rel="stylesheet" type="text/css" href="{{ asset('/frontend/css/sweetalert.min.css') }}?v={{ CSS_JS_VER }}">
  <link rel="stylesheet" href="{{ asset('/frontend/css/bootstrap-datetimepicker.min.css') }}?v={{ CSS_JS_VER }}">
  <link rel="stylesheet" href="{{ asset('/frontend/css/custom.min.css') }}?v={{ CSS_JS_VER }}">  
  <link rel="stylesheet" href="{{ asset('/frontend/custom_js_css/css/custom.css') }}?v={{ CSS_JS_VER }}"> 
@endsection

@section('content')
  <div id="main">
    <section id="inbox">
      <div class="container">
        <div class="d-block d-lg-none inbox-menu mb-3">
          <div class="d-flex align-items-center">
            <span class="icon inbox-menu mr-2"></span> Edit Profile
          </div>
        </div>
        @include('front.account.account_layout.left_menu')
        <div class="inbox-right edit">
          <h3 class="create-listing-title d-flex align-items-center d-none d-lg-flex">
            <span class="icon profile"></span> Edit profile
          </h3>
          <div class="card">
            <div class="card-content">
              @include('shared.errors')
              <form action="{{ url('my-profile')}}" method="POST" class="user_profile_form">
                @csrf
                <div class="info-details">
                  <div class="row mb-md-3 align-items-center">
                    <div class="col col-12 col-md-2 text-md-right">
                      <label for="" class="mb-2 mb-md-0">First name<!-- <span class="text-red">*</span> --></label>
                    </div>
                    <div class="col col-12 col-md-4 pl-md-0 mb-3 mb-md-0">
                      <input type="text" value="{{ !empty(Auth()->user()->first_name) ? Auth()->user()->first_name : ''}}" class="form-control" placeholder="First name" name="first_name" id="first_name">
                    </div>
                    <div class="col col-12 col-md-2 text-md-right">
                      <label for="" class="mb-2 mb-md-0">Last name<!-- <span class="text-red">*</span> --></label>
                    </div>
                    <div class="col col-12 col-md-4 pl-md-0 mb-3 mb-md-0">
                      <input type="text" value="{{ !empty(Auth()->user()->last_name) ? Auth()->user()->last_name : ''}}" class="form-control" placeholder="Last name" name="last_name" id="last_name">
                    </div>
                  </div>
                  <div class="row mb-md-3 align-items-center">
                    <div class="col col-12 col-md-2 text-md-right">
                      <label for="" class="mb-2 mb-md-0">Gender</label>
                    </div>
                    <div class="col col-12 col-md-4 pl-md-0 mb-3 mb-md-0 selectParent">
                      <select name="gender" id="gender">
                        <option value="">Select</option>
                        <option value="male" {{ Auth()->user()->gender == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ Auth()->user()->gender == 'female' ? 'selected' : '' }}>Female</option>
                      </select>
                    </div>
                    <div class="col col-12 col-md-2 text-md-right">
                      <label for="" class="mb-2 mb-md-0">DOB</label>
                    </div>
                    <div class="col col-12 col-md-4 pl-md-0 mb-3 mb-md-0">
                      <input type="text" value="{{ !empty(Auth()->user()->date_of_birth) ? Auth()->user()->date_of_birth : ''}}" class="form-control" placeholder="DOB" name="date_of_birth"  id="dobDatePicker">
                    </div>
                  </div>
                  <div class="row mb-md-3 align-items-center">
                    <div class="col col-12 col-md-2 text-md-right">
                      <label for="" class="mb-2 mb-md-0">email<span class="text-red">*</span></label>
                    </div>
                    <div class="col col-12 col-md-4 pl-md-0 mb-3 mb-md-0">
                      <input type="text" id="email" name="email" class="form-control" placeholder="email" value="{{ Auth()->user()->email }}" readonly>
                    </div>
                    <div class="col col-12 col-md-2 text-md-right">
                      <label for="" class="mb-2 mb-md-0">Phone number<span class="text-red">*</span></label>
                    </div>
                    <div class="col col-12 col-md-4 pl-md-0 mb-3 mb-md-0">
                      <input type="text" class="form-control check-validity" placeholder="Phone number" value="{{ !empty(Auth()->user()->phone_number) ? Auth()->user()->phone_number : ''}}" name="phone_number" id="phone_number" onkeypress='return event.charCode >= 48 && event.charCode <= 57' required>
                      <span class="errorMessage"></span>
                    </div>
                  </div>
                  <div class="row mb-md-3 align-items-center">
                    <div class="col col-12 col-md-2 text-md-right">
                      <label for="" class="mb-2 mb-md-0">Address</label>
                    </div>
                    <div class="col col-12 col-md-4 pl-md-0 mb-3 mb-md-0">
                      <input type="text" class="form-control" placeholder="Address" value="{{ !empty(Auth()->user()->address_line_1) ? Auth()->user()->address_line_1 : ''}}" name="address_line_1" id="address_line_1">
                    </div>
                    <div class="col col-12 col-md-2 text-md-right">
                      <label for="" class="mb-2 mb-md-0">Company name</label>
                    </div>
                    <div class="col col-12 col-md-4 pl-md-0 mb-3 mb-md-0">
                      <input type="text" class="form-control" placeholder="Company name"  value="{{ !empty(Auth()->user()->company_name) ? Auth()->user()->company_name : ''}}" name="company_name" id="company_name">
                    </div>
                  </div>
                  <div class="row mb-md-3 align-items-center">
                    <div class="col col-12 col-md-2 text-md-right">
                      <label for="" class="mb-2 mb-md-0">State</label>
                    </div>
                    <div class="col col-12 col-md-4 pl-md-0 mb-3 mb-md-0 selectParent ">
                      <select name="state" id="state" class="state_list">
                        <option value="" selected>Select</option>
                        @foreach($states as $key => $state)
                          <option value="{{$state->id}}" {{ Auth()->user()->state == $state->id ? 'selected' : '' }}>{{$state->state_name}}</option>                          
                        @endforeach
                      </select>                        
                    </div>
                    <div class="col col-12 col-md-2 text-md-right">
                      <label for="" class="mb-2 mb-md-0">Suburb</label>
                    </div>
                    <div class="col col-12 col-md-4 pl-md-0 mb-3 mb-md-0 selectParent suburb_div">
                      <select name="suburb" id="suburb">
                        <option value="">Select</option>
                          @if(!empty($suburb_list))
                            @foreach($suburb_list as $key => $suburb)
                              <option value="{{$suburb->id}}" {{ Auth()->user()->suburb == $suburb->id ? 'selected' : '' }}>{{$suburb->suburb_name}}</option>
                            @endforeach
                          @endif
                      </select>
                    </div>
                  </div>
                  <div class="row mb-md-3 align-items-center">
                    <div class="col col-12 col-md-2 text-md-right">
                      <label for="postal_code" class="mb-2 mb-md-0">Postcode</label>
                    </div>
                    <div class="col col-12 col-md-4 pl-md-0 mb-3 mb-md-0">
                      <input type="text" id="postal_code" name="postal_code" class="form-control" placeholder="Postcode" value="{{ !empty(Auth()->user()->postal_code) ? Auth()->user()->postal_code : ''}}">
                    </div>
                  </div>
                </div>
                <div class="d-flex align-items-center justify-content-end">
                  <button type="submit" class="btn btn-primary">Save</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
@section('js-content')
  <script type="text/javascript" src="{{ asset('frontend/js/select2.min.js') }}?v={{ CSS_JS_VER }}"></script>  
  <script type="text/javascript" src="{{ asset('frontend/js/jquery-ui.min.js') }}?v={{ CSS_JS_VER }}"></script>
  <script type="text/javascript" src="{{ asset('frontend/js/jquery.validate.min.js') }}?v={{ CSS_JS_VER }}"></script>
  <script type="text/javascript" src="{{ asset('frontend/js/additional-methods.min.js') }}?v={{ CSS_JS_VER }}"></script>
  <script type="text/javascript" src="{{ asset('frontend/js/moment.min.js') }}?v={{ CSS_JS_VER }}"></script>
  <script type="text/javascript" src="{{ asset('frontend/js/bootstrap-datetimepicker.min.js') }}?v={{ CSS_JS_VER }}"></script>
  <script type="text/javascript" src="{{ asset('frontend/js/sweetalert.min.js') }}?v={{ CSS_JS_VER }}"></script>
  <script type="text/javascript" src="{{ asset('frontend/js/custom.min.js') }}?v={{ CSS_JS_VER }}"></script>
@endsection
@push('custom-scripts')
  <script type="text/javascript" src="{{ asset('/frontend/custom_js_css/js/profile.js') }}?v={{CSS_JS_VER}}"></script>
@endpush
