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
          <form action="{{ url('admin/create-explore-breed')}}" method="POST" enctype="multipart/form-data" class="blog_add_form">
            @csrf
            <div class="form-group row align-items-start justify-content-between">
              <label for="" class="col-12 col-md-2 text-right m-0 mt-2">Breed <span class="text-orange">*</span></label>
              <div class="col col-md-4 mr-auto">
                <select name="breed" id="breed" class="form-control">
                  <option value="">Select breed</option>
                  @foreach($all_primary_breed as $key => $breed)
                    <option value="{{$breed->id}}">{{$breed->field_value}}</option>
                  @endforeach
                </select>
                <span class="errorMessage"></span>
              </div>
            </div>            
            <div class="form-group row align-items-start justify-content-between">
              <label for="" class="col-12 col-md-2 text-right m-0">Banner Image <span class="text-orange">*</span></label>
              <div class="col col-md-5 mr-auto">
                <div class="row align-items-center">
                  <div class="col">
                    <label for="explore_horse_image" class="img_label">
                      <img id="ad_image" src="{{ asset('noimage.jpg') }}" class="img-fluid">
                    </label>
                    <input type="file" id="explore_horse_image" name="explore_by_horse_image" onchange="expore_horse_image_upload(this);" style="display: none">

                    <!--  <input type="file" class="" placeholder="Upload image" name="explore_by_horse_image" style="padding:0px"> -->
                    <span class="errorMessage"></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row align-items-start justify-content-between">
              <div class="col-12 col-md-2"></div>
              <div class="col col-md-4 mr-auto d-flex align-items-center">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ url('admin/explore_by_horse')}}" class="btn btn-dark text-white text-link ml-4">Cancel</a>
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
    function expore_horse_image_upload(input) {
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
