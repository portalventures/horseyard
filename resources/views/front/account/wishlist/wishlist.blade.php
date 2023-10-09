@extends('front.layouts.master')
@section('title', 'My Favorites, Horseyard')
@section('canonical-content')
  <link rel="canonical" href="{{URL::current()}}"/>
@endsection
@section('css-content')  
  <link rel="stylesheet" type="text/css" href="{{ asset('/frontend/css/sweetalert.min.css') }}?v={{ CSS_JS_VER }}">  
  <link rel="stylesheet" href="{{ asset('/frontend/css/custom.min.css') }}?v={{ CSS_JS_VER }}">  
  <link rel="stylesheet" href="{{ asset('/frontend/custom_js_css/css/custom.css') }}?v={{ CSS_JS_VER }}"> 
@endsection
@section('content')
  <div id="main">
    <section id="inbox">
      <div class="container">
        <div class="d-block d-lg-none inbox-menu mb-3">
          <div class="d-flex align-items-center">
            <span class="icon inbox-menu mr-2"></span> Wishlist
          </div>
        </div>
        @include('front.account.account_layout.left_menu')
        <div class="inbox-right wishlist">
          <h3 class="create-listing-title d-flex align-items-center d-none d-lg-flex">
            <span class="icon wishlist"></span> Wishlist
          </h3>
          @foreach($wishlist as $key => $ad)
            @php
              $listing_image = get_listing_first_image($ad->listing_id);
            @endphp
            <div class="card mb-3 users_all_wishlist">
              <div class="card-content">
                <div class="d-flex breed-block">
                  <div class="wishlist-image">
                    @if(!empty($listing_image))
                      <img src="{{ url($listing_image->image_url.'/'.$listing_image->image_name) }}"/>
                    @else
                      <img src="{{ asset('admin/images/featured-table.png') }}"/>
                    @endif
                  </div>
                  <div class="breed-details w-100">
                    <div class="d-flex align-items-start justify-content-between">
                      <h3><span class="text-red">{{$ad->listing_title}}</span></h3>
                      <p class="price">${{number_format($ad->listing_price)}}</p>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                      <p>{{$ad->listing_description}}</p>                      
                      @php
                        $wishlist_count = user_listing_present_in_wishlist(Auth()->user()->id, $ad->listing_id)
                      @endphp
                      <a href="javascript:void(0)" class="link save listing_add_into_wishlist account_wish_list" data-id="{{$ad->listing_identification_code}}"><span class="icon heart {{ $wishlist_count > 0 ? 'active' : ''}}"></span></a>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                      <div class="date ml-auto">
                        {{date('d/m/Y', strtotime($ad->wishlist_created_at)) }}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
          <div class="pagination">              
            {{ $wishlist->links() }}
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
@section('js-content')
  <script type="text/javascript" src="{{ asset('frontend/js/jquery-ui.min.js') }}?v={{ CSS_JS_VER }}"></script>
  <script type="text/javascript" src="{{ asset('frontend/js/jquery.validate.min.js') }}?v={{ CSS_JS_VER }}"></script>
  <script type="text/javascript" src="{{ asset('frontend/js/additional-methods.min.js') }}?v={{ CSS_JS_VER }}"></script>  
  <script type="text/javascript" src="{{ asset('frontend/js/sweetalert.min.js') }}?v={{ CSS_JS_VER }}"></script>
  <script type="text/javascript" src="{{ asset('frontend/js/custom.min.js') }}?v={{ CSS_JS_VER }}"></script>
@endsection
@push('custom-scripts')
  <script type="text/javascript" src="{{ asset('/frontend/custom_js_css/js/login_signup.js') }}?v={{CSS_JS_VER}}"></script>
  <script type="text/javascript" src="{{ asset('/frontend/custom_js_css/js/wishlist.js') }}?v={{CSS_JS_VER}}"></script>
@endpush
