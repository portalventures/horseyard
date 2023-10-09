@extends('admin.layouts.master')
@section('pagetitle', 'Manage Home Page Content')
@section('content')
  <div class="main-content">
    <!-- Blog Listings -->
      <section>
        <div class="d-flex align-items-center justify-content-between">
          <h2 class="page-title">Latest blog posts</h2>
          <!-- <div class="d-flex align-items-center justify-content-between toolbar-option">
            Items in slider:
            <select name="options" id="blogpost-items-count" class="ml-1">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
          </select>
          </div> -->
        </div>
        <table class="table listing-table mt-4">
          <thead>
            <tr>
              <th class="table-drag">&nbsp;</th>
              <th class="table-image">Image</th>
              <th>Title</th>
              <th>Type</th>
              <!-- <th>Breed</th>
              <th>Location</th>
              <th>Price</th>  -->
              <th>Delete</th>
            </tr>
          </thead>
          <tbody id="latest-blog-list">
            @foreach($blog_listings as $key => $blog)
            <tr>
              <td class="table-drag">
                <span class="icon drag-handle"></span>
              </td>
              <td class="table-image">
              @if(!empty($blog->image))
                <img src="{{ url('blog_images')}}{{'/'}}{{$blog->image}}" alt="$blog->image" class="img-fluid" />
              @else
                <img src="{{ url('/noimage.jpg') }}" alt="No Image" class="img-fluid" />
              @endif
              </td>
              <td>{{$blog->title}}</td>
              <td>{{ $blog->category_id }}</td>
               <!-- <td>Appaloosa</td>
              <td>NSW</td>
              <td>$3,650</td> -->
              <td class="table-actions">
                <div class="d-flex align-items-center justify-content-center">
                  <a class="remove-listing delete_featured_listing_blog" data-id="{{$blog->blog_id}}" data-object="blog">
                    <span class="icon close"></span>
                  </a>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <td colspan="3" class="align-middle">             
                Showing {{ $blog_listings->firstItem() }} to {{ $blog_listings->lastItem() }} of total {{$blog_listings->total()}} items
              </td>
              <td colspan="2" class="single-item">
                @if($blog_listings->total() < 10)
                <a href="{{ url('admin/add-homepage-setting-listing')}}/{{'blog'}}" class="btn btn-primary">Add new item</a>
                @endif
              </td>
            </tr>
          </tfoot>
        </table>
      </section>
  </div>
@endsection

@push('custom-scripts')
  <script type="text/javascript" src="{{ asset('/admin/custom_js_css/js/home_page_setting.js') }}?v={{CSS_JS_VER}}"></script>
@endpush
