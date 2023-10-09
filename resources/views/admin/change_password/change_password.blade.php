@extends('admin.layouts.master')
@section('pagetitle', 'Change Password')
@section('content')
  <div class="main-content">
    <section>
      <div class="d-flex align-items-center justify-content-between">
        <h1 class="page-title">Account Password</h1>
      </div>
      <div class="card">
        <div class="card-content">
          @include('shared.errors')
          <form action="{{ url('admin/change-password')}}" method="POST" class="admin_change_password_form">
            @csrf
            <div class="form-group row align-items-start justify-content-between">
              <label for="" class="col-12 col-md-2 text-right m-0 mt-2">Old Password <span class="text-orange">*</span></label>
              <div class="col col-md-4 mr-auto pl-0">
                <div class="field-with-icon withIcon">
                  <input type="password" class="form-control checkvalidity" placeholder="Enter Old Password" required name="oldpassword" id="oldpassword">
                  <span class="icon viewPsw eye-slash"></span>
                  <span class="icon viewPsw eye d-none"></span>
                  <span class="errorMessage"></span>
                </div>
              </div>
            </div>
            <div class="form-group row align-items-start justify-content-between">
              <label for="" class="col-12 col-md-2 text-right m-0 mt-2">New Password <span class="text-orange">*</span></label>
              <div class="col col-md-4 mr-auto pl-0">
                <div class="field-with-icon withIcon">
                  <input type="password" class="form-control checkvalidity" placeholder="Enter New Password" required name="new_password" id="new_password">
                  <span class="icon viewPsw eye-slash"></span>
                  <span class="icon viewPsw eye d-none"></span>
                  <span class="errorMessage"></span>
                </div>
              </div>
            </div>
            <div class="form-group row align-items-start justify-content-between">
              <label for="" class="col-12 col-md-2 text-right m-0 mt-2">Confirm Password <span class="text-orange">*</span></label>
              <div class="col col-md-4 mr-auto pl-0">
                <div class="field-with-icon withIcon">
                  <input type="password" class="form-control checkvalidity" placeholder="Enter Confirm Password" required name="confpassword" id="confpassword">
                  <span class="icon viewPsw eye-slash"></span>
                  <span class="icon viewPsw eye d-none"></span>
                  <span class="errorMessage"></span>
                </div>
              </div>
            </div>
            <div class="form-group row align-items-start justify-content-between">
              <div class="col-12 col-md-2"></div>
              <div class="col col-md-4 mr-auto d-flex align-items-center">
                <button type="submit" class="btn btn-primary">Save</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </section>
  </div>
@endsection

@push('custom-scripts')
  <script type="text/javascript" src="{{ asset('/admin/custom_js_css/js/change_password.js') }}?v={{CSS_JS_VER}}"></script>
@endpush
