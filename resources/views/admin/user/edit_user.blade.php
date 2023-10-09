@extends('admin.layouts.master')
@section('pagetitle', 'Manage Users')
@section('content')
  <div class="main-content">
    <section>
      <div class="d-flex align-items-center justify-content-between">
        <h2 class="page-title">Edit user</h2>
      </div>
      <div class="card">
        <div class="card-content">
          @include('shared.errors')
          <form action="{{ url('admin/update_user')}}" method="POST" enctype="multipart/form-data" class="user_update_form">
            @csrf
            <div class="form-group row align-items-start justify-content-between">
              <label for="first name" class="col-12 col-md-2 text-right m-0 mt-2">First Name <span class="text-orange">*</span></label>
              <div class="col col-md-4 mr-auto pl-0">
                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter First Name" value="{{ $user->first_name }}" autocomplete="off" required>
                <span class="errorMessage"></span>
              </div>
              <label for="company name" class="col-12 col-md-2 text-right m-0 mt-2">Company Name</label>
              <div class="col col-md-4 mr-auto pl-0">
                <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Enter Company Name" value="{{ $user->company_name }}" autocomplete="off" required>
                <span class="errorMessage"></span>
              </div>
            </div>
            <div class="form-group row align-items-start justify-content-between">
              <label for="last name" class="col-12 col-md-2 text-right m-0 mt-2">Last Name <span class="text-orange">*</span></label>
              <div class="col col-md-4 mr-auto pl-0">
                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Last Name" value="{{ $user->last_name }}" autocomplete="off" required>
                <span class="errorMessage"></span>
              </div>
              <label for="address" class="col-12 col-md-2 text-right m-0 mt-2">Address</label>
              <div class="col col-md-4 mr-auto pl-0">
                <input type="text" class="form-control" id="address_line_1" name="address_line_1" placeholder="Enter Address" value="{{ $user->address_line_1 }}" autocomplete="off" required>
                <span class="errorMessage"></span>
              </div>
            </div>
            <div class="form-group row align-items-start justify-content-between">
              <label for="email" class="col-12 col-md-2 text-right m-0 mt-2">Email <span class="text-orange">*</span></label>
              <div class="col col-md-4 mr-auto pl-0">
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="{{ $user->email }}" autocomplete="off" required>
                <span class="errorMessage"></span>
              </div>
              <label for="state" class="col-12 col-md-2 text-right m-0 mt-2">State</label>
              <div class="col col-md-4 mr-auto pl-0">
                <select id="state"  name="state" class="form-control checkvalidity state_list" required>
                <option value="" selected>Select</option>
                @foreach($all_state as $key => $value)
                   <option value="{{$value->id}}" {{ $user->state == $value->id ? 'selected' : '' }} >{{$value->state_name}}</option>
                @endforeach
              </select>
              <span class="errorMessage"></span>
              </div>
            </div>
            <div class="form-group row align-items-start justify-content-between">
              <label for="phone number" class="col-12 col-md-2 text-right m-0 mt-2">Phone Number</label>
              <div class="col col-md-4 mr-auto pl-0">
                <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Enter Phone Number" value="{{ $user->phone_number }}" autocomplete="off" required onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                <span class="errorMessage"></span>
              </div>
              <label for="suburb" class="col-12 col-md-2 text-right m-0 mt-2">Suburb</label>
              <div class="col col-md-4 mr-auto pl-0 suburb_div">
                <select name="suburb" id="suburb" class="form-control checkvalidity" required>
                    @foreach($suburb_list as $key => $suburb)
                      <option value="{{$suburb->id}}" {{ $user->suburb == $suburb->id ? 'selected' : '' }}>{{$suburb->suburb_name}}</option>
                    @endforeach
                </select>
                <span class="errorMessage"></span>
              </div>
            </div>
            <div class="form-group row align-items-start justify-content-between">
              <label for="gender" class="col-12 col-md-2 text-right m-0 mt-2">Gender</label>
              <div class="col col-md-4 mr-auto pl-0">
                <select name="gender" id="gender" class="form-control" placeholder="Select" required>
                <option value="">Select</option>
                <option value="male" {{ $user->gender == 'male' ? 'selected' : ''}}>Male</option>
                <option value="female" {{ $user->gender == 'female' ? 'selected' : ''}}>Female</option>
              </select>
              <span class="errorMessage"></span>
              </div>
              <label for="postal code" class="col-12 col-md-2 text-right m-0 mt-2">Enter Post Code</label>
              <div class="col col-md-4 mr-auto pl-0">
                <input type="text" class="form-control" placeholder="Enter Post Code" id="postal_code" name="postal_code" value="{{ $user->postal_code }} " autocomplete="off" required>
                <span class="errorMessage"></span>
              </div>
            </div>
            <div class="form-group row align-items-start justify-content-between">
              <div class="col-12 col-md-2"></div>
              <div class="col col-md-4 mr-auto d-flex align-items-center">
                <input type="hidden" id="user_id" name="user_id" value="{{ $user->id }}">
                <button type="submit" class="btn btn-primary">Save user detail</button>
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
