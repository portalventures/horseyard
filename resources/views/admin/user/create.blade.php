@extends('admin.layouts.master')
@section('pagetitle', 'Manage Users')
@section('content')
<div class="main-content">
    <section>
        <div class="d-flex align-items-center justify-content-between">
           <h2 class="page-title">Add New Users</h2>
        </div>
        <div class="card">
            <div class="card-content">
                
              <form action="{{ url('admin/save_user')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group row align-items-start justify-content-between">
                  <label for="first name" class="col-12 col-md-2 text-right m-0 mt-2">First Name <span class="text-orange">*</span></label>
                  <div class="col col-md-4 mr-auto pl-0">
                    <input type="text" class="form-control" value="{{ old('first_name') }}" id="first_name" name="first_name" placeholder="Enter First Name" autocomplete="off">
                    @error('first_name')
                    <span class="errorMessage">{{ $message }}</span>
                    @enderror
                  </div>
                  <label for="company name" class="col-12 col-md-2 text-right m-0 mt-2">Company Name</label>
                  <div class="col col-md-4 mr-auto pl-0">
                    <input type="text" class="form-control userhiddenForm" value="{{ old('company_name') }}" id="company_name" name="company_name" placeholder="Enter Company Name" autocomplete="off">
                    <span class="errorMessage"></span>
                  </div>
                </div>
                <div class="form-group row align-items-start justify-content-between">
                  <label for="last name" class="col-12 col-md-2 text-right m-0 mt-2">Last Name <span class="text-orange">*</span></label>
                  <div class="col col-md-4 mr-auto pl-0">
                    <input type="text" class="form-control userhiddenForm" value="{{ old('last_name') }}" id="last_name" name="last_name" placeholder="Enter Last Name" autocomplete="off">
                    @error('last_name')
                    <span class="errorMessage">{{ $message }}</span>
                    @enderror
                  </div>
                  <label for="address" class="col-12 col-md-2 text-right m-0 mt-2">Address</label>
                  <div class="col col-md-4 mr-auto pl-0">
                    <input type="text" class="form-control userhiddenForm" value="{{ old('address_line_1') }}" id="address_line_1" name="address_line_1" placeholder="Enter Address" autocomplete="off">
                    <span class="errorMessage"></span>
                  </div>
                </div>
                <div class="form-group row align-items-start justify-content-between">
                  <label for="email" class="col-12 col-md-2 text-right m-0 mt-2">Email <span class="text-orange">*</span></label>
                  <div class="col col-md-4 mr-auto pl-0">
                    <input type="email" class="form-control" id="email" value="{{ old('email') }}" name="email" placeholder="Enter Email" autocomplete="off">
                    @error('email')
                    <span class="errorMessage">{{ $message }}</span>
                    @enderror
                  </div>
                  <label for="state" class="col-12 col-md-2 text-right m-0 mt-2">State</label>
                  <div class="col col-md-4 mr-auto pl-0">
                    <select id="state"  name="state" class="form-control checkvalidity state_list userhiddenForm" value="{{ old('state') }}>
                    <option value="" selected>Select</option>
                    @foreach($all_state as $key => $value)
                        <option value="{{$value->id}}">{{$value->state_name}}</option>
                    @endforeach
                  </select>
                  <span class="errorMessage"></span>
                  </div>
                </div>
                <div class="form-group row align-items-start justify-content-between">
                  <label for="phone number" class="col-12 col-md-2 text-right m-0 mt-2">Phone Number</label>
                  <div class="col col-md-4 mr-auto pl-0">
                    <input type="text" value="{{ old('phone_number') }}" class="form-control @error('phone_number') is-invalid @enderror userhiddenForm" id="phone_number" name="phone_number" placeholder="Enter Phone Number" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                    @error('phone_number')
                    <span class="errorMessage">{{ $message }}</span>
                    @enderror
                  </div>
                  <label for="suburb" class="col-12 col-md-2 text-right m-0 mt-2">Suburb</label>
                  <div class="col col-md-4 mr-auto pl-0 suburb_div">
                    <select id="suburb" name="suburb" class="form-control checkvalidity userhiddenForm" value="{{ old('suburb') }}>
                    <option value="">Select</option>
                  </select>
                  <span class="errorMessage"></span>
                  </div>
                </div>
                <div class="form-group row align-items-start justify-content-between">
                  <label for="gender" class="col-12 col-md-2 text-right m-0 mt-2">Gender</label>
                  <div class="col col-md-4 mr-auto pl-0">
                    <select name="gender" id="gender" class="form-control userhiddenForm" placeholder="Select" value="{{ old('gender') }}">
                    <option value="">Select</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                  </select>
                  <span class="errorMessage"></span>
                  </div>
                  <label for="postalcode" class="col-12 col-md-2 text-right m-0 mt-2">Enter Post Code</label>
                  <div class="col col-md-4 mr-auto pl-0">
                    <input type="text" value="{{ old('postal_code') }}" class="form-control userhiddenForm" placeholder="Enter Post Code" id="postal_code" name="postal_code" autocomplete="off">
                    <span class="errorMessage"></span>
                  </div>
                </div>
                <div class="form-group row align-items-start justify-content-between">
                  <div class="col-12 col-md-2"></div>
                  <div class="col col-md-4 mr-auto d-flex align-items-center">
                    <button type="submit" class="btn btn-primary" id="save_user">Add user</button>
                    <a href="{{ url('admin/users')}}" class="btn btn-dark text-white text-link ml-4">Cancel</a>
                  </div>
                </div>
              </form>
            </div>
          </div>
    </section>
    </div>
@endsection
@push('custom-scripts')
  <script type="text/javascript" src="{{ asset('/admin/custom_js_css/js/user.js') }}?v={{CSS_JS_VER}}"></script>
@endpush
<link rel="stylesheet" type="text/css" href="{{ asset('/admin/custom_js_css/css/custom.css') }}?v={{CSS_JS_VER}}">
