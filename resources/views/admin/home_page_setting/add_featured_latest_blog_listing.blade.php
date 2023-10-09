@extends('admin.layouts.master')
@section('pagetitle', 'Manage Home Page Content')
@section('content')
  <div class="main-content">
    <section>
      <div class="d-flex align-items-center justify-content-between">
        <h2 class="page-title">Add new item</h2>
        <form action="{{ url('admin/add-homepage-setting-listing')}}{{'/'}}{{$from}}" method="get" class="search-form">
            <div class="form-group d-flex flex-nowrap">
              <input class="form-control flex-grow-1 h-auto" name="search" placeholder="Search" type="text" value="{{ !empty($search_key_word) ? $search_key_word : ''}}">
              <button class="btn btn-secondary p-3 d-flex align-items-center justify-content-center" type="submit">
                <span class="icon search-white"></span></button>
            </div>
        </form>        
        <!-- <div class="d-flex align-items-center justify-content-between toolbar-option">
          Category:
          <select name="options" id="featured-items-count" class="ml-1">
          <option value="1">Horses</option>
          <option value="2">Lorem</option>
          <option value="3">Lorem ipsum</option>
          </select>
        </div> -->
      </div>
      @if($from != 'blog')
        <table class="table listing-table mt-4">
          <thead>
            <tr>
              <th class="with-checkbox">&nbsp;</th>
              <th class="table-image">Image</th>
              <th>Title</th>
              <th>Category</th>
              <th>Location</th>
              <th>Price</th>
            </tr>
          </thead>
          <tbody id="feature-list">
            @foreach($ads as $key => $ad)
              @php
                $listing_image = $ad->images()->first();
                $listing_ids = [];
                if(session()->has('listing_all_ids'))
                {
                  $listing_ids = Session::get('listing_all_ids');
                }
              @endphp
              <tr>
                <td class="with-checkbox">
                  <label for="ad{{$key}}" class="custom-checkbox">
                  <input type="checkbox" id="ad{{$key}}" class="ads_ids" value="{{ $ad->id }}" {{ in_array($ad->id, $listing_ids) && $listing_ids != '' ? 'checked' : '' }}>
                  <span></span>
                  </label>
                </td>
                <td class="table-image">
                  @if(!empty($listing_image))
                    <img src="{{ url($listing_image->image_url.'/'.$listing_image->image_name) }}" alt="Featured listing" class="img-fluid" />
                  @else
                    <img src="{{ url('/noimage.jpg') }}" alt="No Image" class="img-fluid" />
                  @endif
                </td>
                <td>{{$ad->title}}</td>              
                <td>{{get_to_category_name($ad->category_id)}}</td>
                <td>{{get_state_name($ad->state_id)}}</td>
                <td>${{$ad->price}}</td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <td colspan="2" class="align-middle">             
                Showing {{ $ads->firstItem() }} to {{ $ads->lastItem() }} of total {{$ads->total()}} items
              </td>
              <td colspan="5">
                <div class="pagination justify-content-end">
                  {!! $ads->links() !!}
                </div>
              </td>
            </tr>          
            <tr>
              <td colspan="8" class="single-item">
              @if($from == 'latest')
                <button class="btn btn-secondary text-transform-none add_ads_into_latest_listing" data-id="{{$from}}" total-rec="{{$curRecCount}}">Add Selected to Slider</button>
                @else
                <button class="btn btn-secondary text-transform-none add_ads_into_featured_listing" data-id="{{$from}}" total-rec="{{$curRecCount}}">Add Selected to Slider</button>
                @endif
              </td>
            </tr>
          </tfoot>
        </table>
      @else
        <table class="table listing-table mt-4">
          <thead>
            <tr>
              <th class="table-drag">&nbsp;</th>
              <th class="table-image">Image</th>
              <th>Title</th>
              <th width="25%">Type</th>
            </tr>
          </thead>
          <tbody id="latest-blog-list">
            @foreach($blogs as $key => $blog)
              @php              
                $blog_ids = [];
                if(session()->has('listing_all_ids'))
                {
                  $blog_ids = Session::get('listing_all_ids');
                }
              @endphp
            <tr>
              <td class="with-checkbox">
                <label for="ad{{$key}}" class="custom-checkbox">
                <input type="checkbox" id="ad{{$key}}" class="ads_ids" value="{{ $blog->id }},{{ $blog->category_id }}" {{ in_array($blog->id, $blog_ids) && $blog_ids != '' ? 'checked' : '' }}>
                <span></span>
                </label>
              </td>
              <td class="table-image">
                <img src="{{ url('blog_images')}}{{'/'}}{{$blog->image}}" alt="Blog Image" class="img-fluid" />
              </td>
              <td>{{$blog->title}}</td>
              <td>{{ $blog->category_id }}</td>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <td colspan="4">
                <div class="pagination justify-content-end">
                  {!! $blogs->links() !!}
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="3" class="align-middle">             
                Showing {{ $blogs->firstItem() }} to {{ $blogs->lastItem() }} of total {{$blogs->total()}} items
              </td>
              <td colspan="1" class="single-item">
                <button class="btn btn-secondary text-transform-none add_blog_into_blog_listing" data-id="{{$from}}" total-rec="{{$curRecCount}}">Add Selected to Slider</button>
              </td>
            </tr>
          </tfoot>
        </table>
      @endif
    </section>
  </div>
@endsection

@push('custom-scripts')
  <script type="text/javascript" src="{{ asset('/admin/custom_js_css/js/home_page_setting.js') }}?v={{CSS_JS_VER}}"></script>
@endpush
