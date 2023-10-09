@extends('admin.layouts.master')
@section('pagetitle', 'Manage Blogs')
@section('content')
  <div class="main-content">
    <section>
      <div class="d-flex align-items-center justify-content-between">
        <h2 class="page-title">Create new blog</h2>
      </div>
      <div class="card">
        <div class="card-content">
          @include('shared.errors')
          <form action="{{ url('admin/create-blog')}}" method="POST" enctype="multipart/form-data" class="blog_add_form">
            @csrf
            <div class="form-group row align-items-start justify-content-between">
              <label for="" class="col-12 col-md-2 text-right m-0 mt-2">Title<span class="text-orange">*</span></label>
              <div class="col mr-auto">
                <input type="text" class="form-control" placeholder="Title of Blog" name="title" id="title" required>
                <span class="errorMessage"></span>
              </div>
            </div>
            <div class="form-group row align-items-start justify-content-between">
              <label for="" class="col-12 col-md-2 text-right m-0 mt-2">Description <span class="text-orange">*</span></label>
              <div class="col mr-auto w-100">
                <!-- <textarea name="detailed_text" id="detailed_text" cols="50" rows="10" class="form-control w-100"></textarea> -->
                <!-- Create the editor container -->
                <input type="text" name="detailed_text" id="detailed_text" class="detailed_text">
                <div id="editor"></div>
                <span class="errorMessage"></span>
              </div>
            </div>
            <div class="form-group row align-items-start justify-content-between">
              <label for="" class="col-12 col-md-2 text-right m-0">Banner Image <span class="text-orange">*</span></label>
              <div class="col col-md-5 mr-auto">
                <div class="row align-items-center">
                  <div class="col">

                  <label for="blog_image" class="img_label">
                    <img id="ad_image" src="{{ asset('noimage.jpg') }}" class="img-fluid">
                  </label>
                  <input type="file" id="blog_image" name="blog_image" onchange="blog_image_upload(this);" style="display: none">

                    <!-- <input type="file" class="" placeholder="Upload image" name="blog_image" style="padding:0px"> -->
                    <span class="errorMessage"></span>
                  </div>
                  <!--
                  <div class="col flex-grow-0">
                    <div class="file-upload-button withField">
                      <input type="file" class="btn btn-secondary">
                      <button class="btn btn-secondary" type="button">Upload</button>
                    </div>
                  </div>
-->
                </div>
              </div>
            </div>
            <!--
            <div class="form-group row align-items-start justify-content-between">
              <label for="" class="col-12 col-md-2 text-right m-0">Show/Hide</label>
              <div class="col col-md-4 mr-auto">
                <div class="d-flex flex-column">
                  <label for="header-menu" class="custom-checkbox-text">
                  <input type="checkbox" id="header-menu" name="show_in_header" checked value="1">
                  <span></span>
                  Show in Header Menu
                </label>
                  <label for="footer-menu" class="custom-checkbox-text mb-0">
                  <input type="checkbox" id="footer-menu" name="show_in_footer"  value="1">
                  <span></span>
                  Show in Footer Menu
                </label>
                </div>
              </div>
            </div>
            -->
            <!-- <div class="form-group row align-items-start justify-content-between">
              <label for="" class="col-12 col-md-2 text-right m-0 mt-2">Created date</label>
              <div class="col col-md-4 mr-auto">
                <input type="date" class="form-control" placeholder="Select Date">
              </div>
            </div> -->
            <div class="form-group row align-items-start justify-content-between">
              <label for="" class="col-12 col-md-2 text-right m-0 mt-2">Category <span class="text-orange">*</span></label>
              <div class="col col-md-4 mr-auto">
                <select name="category" id="category" class="form-control">
                  <option value="">Select</option>
                  <option value="article">Article</option>
                  <option value="news">News</option>
                </select>
                <span class="errorMessage"></span>
              </div>
            </div>
            <div class="form-group row align-items-start justify-content-between">
              <div class="col-12 col-md-2"></div>
              <div class="col col-md-4 mr-auto d-flex align-items-center">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ url('admin/all-blogs')}}" class="btn btn-dark text-white text-link ml-4">Cancel</a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </section>
  </div>
@endsection

@push('custom-scripts')
  <script type="text/javascript" src="{{ asset('/admin/custom_js_css/js/blog.js') }}?v={{CSS_JS_VER}}"></script>
  <script type="text/javascript">
    function blog_image_upload(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
          $('#ad_image').attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
      }
    }
  </script>
@endpush
