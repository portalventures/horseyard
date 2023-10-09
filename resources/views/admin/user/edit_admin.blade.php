@extends('admin.layouts.master')
@section('pagetitle', 'Manage Admin Users')
@section('content')
<form action="{{ url('admin/update-admin-user') }}" class="admin_user_update_form" method="post">
@csrf
      <div class="main-content">
        <section>
          <div class="d-flex align-items-center justify-content-between">
            <h1 class="page-title">Edit Administrator</h1>
          </div>
          <div class="card">
            <div class="card-content">
                <div class="form-group row align-items-start justify-content-between">
                  <label for="" class="col-12 col-md-2 text-right m-0 mt-2">Role<span class="text-orange">*</span></label>
                  <div class="col col-md-4 mr-auto pl-0">
                    <input type="text" class="form-control" value="{{ $adminUser->role }}" >
                  </div>
                </div>
                <div class="form-group row align-items-start justify-content-between">
                  <label for="first_name" class="col-12 col-md-2 text-right m-0 mt-2">First Name <span class="text-orange">*</span></label>
                  <div class="col col-md-4 mr-auto pl-0">
                    <input type="text" id="first_name" name="first_name" class="form-control" placeholder="Enter First Name" value="{{ $adminUser->first_name }}" autocomplete="off" required>
                    <span class="errorMessage"></span>
                  </div>
                  <label for="last_name" class="col-12 col-md-2 text-right m-0 mt-2">Last Name <span class="text-orange">*</span></label>
                  <div class="col col-md-4 mr-auto pl-0">
                    <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Enter Last Name" value="{{ $adminUser->last_name }}" autocomplete="off" required>
                    <span class="errorMessage"></span>
                  </div>
                </div>
                <div class="form-group row align-items-start justify-content-between">
                  <label for="" class="col-12 col-md-2 text-right m-0 mt-2">Email <span class="text-orange">*</span></label>
                  <div class="col col-md-4 mr-auto pl-0">
                    <input type="email" id="email" name="email" class="form-control" placeholder="Enter Email" value="{{ $adminUser->email }}" autocomplete="off" required disabled>
                    <span class="errorMessage"></span>
                  </div>
                  <label for="" class="col-12 col-md-2 text-right m-0 mt-2">Phone Number<span class="text-orange">*</span></label>
                  <div class="col col-md-4 mr-auto pl-0">
                    <input type="text" id="phone_number" name="phone_number" class="form-control" placeholder="Enter Phone Number" value="{{ $adminUser->phone_number }}" autocomplete="off" required onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                    <span class="errorMessage"></span>
                  </div>
                </div>
                <div class="form-group row align-items-start justify-content-between">
                  <label for="gender" class="col-12 col-md-2 text-right m-0 mt-2">Gender</label>
                  <div class="col col-md-4 mr-auto pl-0">
                    <select name="gender" id="gender" class="form-control" placeholder="Select">
                    <option value="">Select</option>
                    <option value="male" {{ $adminUser->gender == 'male'? 'selected':''}}>Male</option>
                    <option value="female" {{ $adminUser->gender == 'female'? 'selected':''}}>Female</option>
                  </select>
                  </div>
                  {{-- <label for="country" class="col-12 col-md-2 text-right m-0 mt-2">Country</label>
                  <div class="col col-md-4 mr-auto pl-0">
                    <select name="country" id="country" class="form-control" placeholder="Select" disabled>
                        <option value="">Select</option>
                        <option value="Australia" {{ $adminUser->country == 'Australia'? 'selected':''}}>Australia</option>
                      </select>
                  </div> --}}
                </div>
                <div class="form-group row align-items-start justify-content-between">
                  <label for="passwd" class="col-12 col-md-2 text-right m-0 mt-2">Password <span class="text-orange">*</span></label>
                  <div class="col col-md-4 mr-auto pl-0">
                    <input type="password" id="passwd" name="passwd" class="form-control" placeholder="Enter Password" value="" autocomplete="off" required>
                    <span class="errorMessage"></span>
                    <span class="passwd"></span>
                  </div>
                  <label for="confpass" class="col-12 col-md-2 text-right m-0 mt-2">Confirm Password <span class="text-orange">*</span></label>
                  <div class="col col-md-4 mr-auto pl-0">
                    <input type="password" id="confpass" name="confpass" class="form-control" placeholder="Confirm Password" value="" autocomplete="off" required>
                    <span class="errorMessage"></span>
                    <span class="confpass"></span>
                  </div>
                </div>
                <div class="form-group row align-items-start justify-content-between">
                  <div class="col-12 col-md-2"></div>
                  <div class="col col-md-4 mr-auto d-flex align-items-center">
                    <input type="hidden" id="idfield" name="idfield" value="{{ $adminUser->id }}">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ url('admin/manage-admin-users') }}" class="text-link ml-4">Cancel</a>
                  </div>
                </div>
            </div>
          </div>
        </section>
</div>
</form>
@endsection
@push('custom-scripts')
  <script type="text/javascript" src="{{ asset('/admin/custom_js_css/js/user.js') }}?v={{CSS_JS_VER}}"></script>
@endpush
