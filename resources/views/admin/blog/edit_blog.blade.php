@extends('admin.layouts.master')
@section('pagetitle', 'Manage Blogs')
@section('content')
  <div class="main-content">
    <section>
      <div class="d-flex align-items-center justify-content-between">
        <h2 class="page-title">Edit blog</h2>
      </div>
      <div class="card">
        <div class="card-content">
          @include('shared.errors')
          <form action="{{ url('admin/update-blog')}}" method="POST" enctype="multipart/form-data" class="blog_update_form">
            @csrf
            <div class="form-group row align-items-start justify-content-between">
              <label for="" class="col-12 col-md-2 text-right m-0 mt-2">Title<span class="text-orange">*</span></label>
              <div class="col mr-auto">
                <input type="hidden" name="blog_id" value="{{ $blog->id}}">
                <input type="text" class="form-control" placeholder="Title of Blog" name="title" id="title" required value="{{ $blog->title }}">
                <span class="errorMessage"></span>
              </div>
            </div>            
            <div class="form-group row align-items-start justify-content-between">
              <label for="" class="col-12 col-md-2 text-right m-0 mt-2">Description <span class="text-orange">*</span></label>
              <div class="col mr-auto">
                <!-- <textarea name="detailed_text" id="detailed_text" cols="50" rows="10">{{ $blog->detailed_text }}</textarea> -->
                <input type="hidden" name="detailed_text" id="detailed_text" value="{!! $blog->detailed_text !!}">
                <!-- Create the editor container -->
                <div id="editor">
                </div>
                <span class="errorMessage"></span>
              </div>
            </div>
            <div class="form-group row align-items-start justify-content-between">
              <label for="" class="col-12 col-md-2 text-right m-0 mt-2">Banner Image <span class="text-orange">*</span></label>
              <div class="col col-md-5 mr-auto">
                <!-- <img src="{{ url('blog_images')}}{{'/'}}{{$blog->image}}" width="100"> -->

                <label for="blog_image" class="img_label">
                  <span class="icon ads-pencil size-24"></span>
                  <img id="ad_image" src="{{ url('blog_images')}}{{'/'}}{{$blog->image}}" class="img-fluid">
                </label>
                <input type="file" id="blog_image" name="blog_image" onchange="blog_image_upload(this);" style="display: none">

                <!-- <div class="row align-items-center">
                  <div class="col">
                    <input type="file" class="form-control" placeholder="Upload image" name="blog_image" style="padding:0px">
                    <span class="errorMessage"></span>
                  </div>
                </div> -->
              </div>
            </div>
            <div class="form-group row align-items-start justify-content-between">
              <label for="" class="col-12 col-md-2 text-right m-0 mt-2">Category <span class="text-orange">*</span></label>
              <div class="col col-md-4 mr-auto">
                <select name="category" id="category" class="form-control">
                  <option value="">Select</option>
                  <option value="article" {{ $blog->category_id == 'article' ? 'selected' : ''}}>Article</option>
                  <option value="news" {{ $blog->category_id == 'news' ? 'selected' : ''}}>News</option>
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
