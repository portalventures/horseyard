@extends('admin.layouts.master')
@section('pagetitle', 'Manage Admin Users')
@section('content')
<form action="{{ url('admin/save-admin-user') }}" class="admin_user_create_form" method="post">
@csrf
      <div class="main-content">
        <section>
          <div class="d-flex align-items-center justify-content-between">
            <h1 class="page-title">Add New Administrator</h1>
          </div>
          <div class="card">
            <div class="card-content">
              <div class="row">
                <div class="col-8">
                  <form action="" class="hiddenForm">
                    <div class="form-group row align-items-start justify-content-between">
                      <label for="role" class="col-12 col-md-2 text-right m-0 mt-2">Role<span class="text-orange">*</span></label>
                      <div class="col col-md-10 mr-auto pl-0">
                        <select name="role" id="role">
                        <option value="Admin">Admin</option>
                        <option value="Editor">Editors</option>
                      </select>
                      </div>
                    </div>
                    <div class="form-group row align-items-start justify-content-between">
                      <label for="first_name" class="col-12 col-md-2 text-right m-0 mt-2">First Name <span class="text-orange">*</span></label>
                      <div class="col col-md-4 mr-auto pl-0">
                        <input type="text" id="first_name" name="first_name" class="form-control hiddenForm" placeholder="Enter First Name" autocomplete="off" required>
                        <span class="errorMessage"></span>
                      </div>
                      <label for="last_name" class="col-12 col-md-2 text-right m-0 mt-2">Last Name <span class="text-orange">*</span></label>
                      <div class="col col-md-4 mr-auto pl-0">
                        <input type="text" id="last_name" name="last_name" class="form-control hiddenForm" placeholder="Enter Last Name" autocomplete="off" required>
                        <span class="errorMessage"></span>
                      </div>
                    </div>
                    <div class="form-group row align-items-start justify-content-between">
                      <label for="email" class="col-12 col-md-2 text-right m-0 mt-2">Email <span class="text-danger">*</span></label>
                      <div class="col col-md-4 mr-auto pl-0">
                        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror hiddenForm" placeholder="Enter Email" autocomplete="off" required>
                        <span id="error_email"></span>
                        <span class="errorMessage"></span>
                      </div>
                      <label for="mobile" class="col-12 col-md-2 text-right m-0 mt-2">Phone Number<span class="text-orange">*</span></label>
                      <div class="col col-md-4 mr-auto pl-0">
                        <input type="number" id="mobile" name="mobile" class="form-control @error('mobile') is-invalid @enderror hiddenForm" placeholder="Enter Phone Number" autocomplete="off" required>
                        <span id="error_mobile"></span>
                        <span class="errorMessage"></span>
                      </div>
                    </div>
                    <div class="form-group row align-items-start justify-content-between">
                      <label for="gender" class="col-12 col-md-2 text-right m-0 mt-2">Gender</label>
                      <div class="col col-md-4 mr-auto pl-0">
                        <select name="gender" id="gender" class="form-control hiddenForm" placeholder="Select" >
                        <option value="">Select</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                      </select>
                      </div>
                      {{-- <label for="country" class="col-12 col-md-2 text-right m-0 mt-2">Country</label>
                      <div class="col col-md-4 mr-auto pl-0">
                        <select name="country" id="country" class="form-control">
                        <option value="Australia">Australia</option>
                      </select>
                      <span class="errorMessage"></span>
                      </div> --}}
                    </div>
                    <div class="form-group row align-items-start justify-content-between">
                      <label for="passwd" class="col-12 col-md-2 text-right m-0 mt-2">Password <span class="text-orange">*</span></label>
                      <div class="col col-md-4 mr-auto pl-0">
                        <input type="password" id="passwd" name="passwd" class="form-control hiddenForm" placeholder="Enter Password" autocomplete="off" required>
                        <span class="errorMessage"></span>
                        <span class="passwd"></span>
                      </div>
                      <label for="confpass" class="col-12 col-md-2 text-right m-0 mt-2">Confirm Password <span class="text-orange">*</span></label>
                      <div class="col col-md-4 mr-auto pl-0">
                        <input type="password" id="confpass" name="confpass" class="form-control hiddenForm" placeholder="Confirm Password" autocomplete="off" required>
                        <span class="errorMessage"></span>
                        <span class="confpass"></span>
                      </div>
                    </div>
                    <div class="form-group row align-items-start justify-content-between">
                      <div class="col-12 col-md-2"></div>
                      <div class="col col-md-4 mr-auto d-flex align-items-center">
                        <button type="submit" id="save_admin" class="btn btn-primary" >Save</button>
                        <a href="{{ url('admin/manage-admin-users') }}" class="text-link ml-4" >Cancel</a>
                      </div>
                    </div>
                  </form>
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
<link rel="stylesheet" type="text/css" href="{{ asset('/admin/custom_js_css/css/custom.css') }}?v={{CSS_JS_VER}}">
