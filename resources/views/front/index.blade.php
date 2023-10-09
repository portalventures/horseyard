@section('canonical-content')
  <link rel="canonical" href="{{URL::to('/')}}"/>
@endsection
@extends('front.layouts.master')

@section('title', 'Horses for Sale and Horse Classifieds | Horseyard')

@section('css-content')
  <link rel="stylesheet" href="{{ asset('/frontend/css/slick.min.css') }}?v={{ CSS_JS_VER }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('/frontend/css/sweetalert.min.css') }}?v={{ CSS_JS_VER }}">  
  <link rel="stylesheet" href="{{ asset('/frontend/css/custom.min.css') }}?v={{ CSS_JS_VER }}">  
  <link rel="stylesheet" href="{{ asset('/frontend/custom_js_css/css/custom.css') }}?v={{ CSS_JS_VER }}"> 
@endsection
@section('content')
  <div id="main">
    <section id="search">
      <div class="d-flex justify-content-center">
        <div class="search-box">
          <form id="index_page_form" action="{{ url('quick-search-category')}}" class="dynamic_category_search_form" method="post">
          @csrf
          <ul class="d-flex align-items-center search-filters">
            <li><a href="#" class="active dynamic_category_tabs" data-category="horses" data-id="horses">Horses</a></li>
            <li><a href="#" class="dynamic_category_tabs" data-category="horses" data-id="transport">Transport</a></li>
            <li><a href="#" class="dynamic_category_tabs" data-category="horses" data-id="saddlery">Saddlery</a></li>
            <li><a href="#" class="dynamic_category_tabs" data-category="horses" data-id="property">Property</a></li>
          </ul>
          <div class="form-tab-pane horses dynamic_category_fields">
          @include('front.dynamic_category_tabs')
          </div> 
          </form>
          <div class="advertise">
            <img src="{{asset('frontend/images/adv-search.png')}}" alt="Advertisement">
          </div>
        </div>
      </div>
    </section>
    @if(!empty($explore_by_horse))
      <section id="breeds">
        <div class="container">
          <div class="d-flex align-items-center justify-content-between flex-sm-col">
            <h2>Explore by Horse Breeds</h2>
            <a class="link view-all-link" href="{{ url('search_by_all_breed') }}">View all breeds →</a>
          </div>
          <div class="breeds-list">
            @foreach($explore_by_horse as $key => $breed)
              <div class="breed-block">
                <a class="link" href="{{ url('horses-for-sale') }}/{{Str::slug($breed->brand_name,'-')}}">                  
                  <div class="image-box">
                    <img alt="{{ $breed->brand_name }}" src="{{ url('explore_by_horse_250')}}{{'/'}}{{$breed->image}}">
                  </div>                                    
                  <h3>{{ $breed->brand_name }}</h3>
                </a>
              </div>
            @endforeach
          </div>
        </div>
      </section>
    @endif
    <section id="advertisement">
      <div class="container">
        <div class="d-flex align-items-center justify-content-center">
          <a href="#">
            <img src="{{ asset('frontend/images/adv-golf.png') }}" alt="Advertisement">
          </a>
        </div>
      </div>
    </section>
    @if(!empty($featured_listings))
    <section class="listings" id="featured">
      <div class="container">
        <div class="d-flex align-items-center justify-content-between flex-sm-col">
          <h2>Featured Listings</h2>
          <a href="{{ url('search-latest-featured')}}{{'/'}}{{'featured'}}" class="link view-all-link">See All →</a>
        </div>
        <div class="isotope-main">
          <div class="tab-pane horses">
            <div class="slick-slider-main">
              @foreach($featured_listings as $key => $featured)
                @php
                $listingObj = getListingObj($featured->listing_master_id);
                $queryStr = $listingObj->generateQueryURL();
                $listing_image = get_listing_first_image($featured->listing_master_id);
                /*
                  $category_details = get_category_dynamic_details_for_search($featured->identification_code, $featured->category_id);

                  $attributes = generate_ad_attribute_view_url($category_details, $featured->identification_code, $featured->category_id); 
                 
                  if($featured->category_id == 1)
                  {
                    $breed = dynamic_field_slug($category_details['horses_breed_primary']->dynamic_field_id);
                  }

                  $location = generate_location_view_url($featured->identification_code)
                  */
                @endphp

                <a href="{{ url('ad')}}/{{$featured->slug}}">
                  <div class="element-item">
                    <div class="image-box">
                    @if(!empty($listing_image))
                      <img src="{{ asset('listing_images_250/'.$listingObj->id.'/'.$listing_image->image_name) }}" />
                    @else
                      <img src="{{ asset('admin/images/featured-table.png') }}" />
                    @endif
                    </div>
                    <div class="details">
                      <div class="d-flex align-items-center justify-content-between">
                        <label class="type">AD ID - {{ $featured->ad_id }}</label>
                        <label class="state">
                          <span class="icon address"></span>
                          {{get_state_short_code($featured->state_id)}}
                        </label>
                      </div>
                      <h3 class="name">{{ mb_strimwidth($featured->title, 0, 22,'...')}}</h3>
                      @if($featured->category_id == 1)
                        <label class="breedtype">Horse</label>
                      @elseif($featured->category_id == 2)
                        <label class="breedtype">Transport</label>
                      @elseif($featured->category_id == 3)
                        <label class="breedtype">Saddlery</label>
                      @elseif($featured->category_id == 4)
                        <label class="breedtype">Property</label>
                      @else
                        <label class="breedtype">NA</label>
                      @endif
                      @if($featured->item_show_type != 'free')
                        <p class="price">${{number_format($featured->price)}}
                          <sub>{{substr($featured->item_show_type,0,3)}}</sub>
                        </p>
                      @else
                        <p class="price">Free
                        </p>
                      @endif
                    </div>
                  </div>
                </a>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </section>
    @endif
    @if(!empty($latest_listings))
    <section class="listings" id="latest">
      <div class="container">
        <div class="d-flex align-items-center justify-content-between flex-sm-col">
          <h2>Latest Listings</h2>
          <a href="{{ url('search-latest-featured')}}{{'/'}}{{'latest'}}" class="link view-all-link">See All →</a>
        </div>
        <div class="isotope-main">
          <div class="tab-pane horses">
            <div class="slick-slider-main">
              @foreach($latest_listings as $key => $latest)
                @php
                $listingObj = getListingObj($latest->id);
                $queryStr = $listingObj->generateQueryURL();
                $listing_image = get_listing_first_image($latest->id);
                /*
                  $category_details = get_category_dynamic_details_for_search($latest->identification_code, $latest->category_id);

                  $attributes = generate_ad_attribute_view_url($category_details, $latest->identification_code, $latest->category_id); 
                 
                  if($latest->category_id == 1)
                  {
                    $breed = dynamic_field_slug($category_details['horses_breed_primary']->dynamic_field_id);
                  }

                  $location = generate_location_view_url($latest->identification_code)  
                  */                
                @endphp

                <a href="{{ url('ad')}}/{{$latest->slug}}">
                  <div class="element-item">
                    <div class="image-box">                    
                    @if(!empty($listing_image))
                      <img src="{{ asset('listing_images_250/'.$listingObj->id.'/'.$listing_image->image_name) }}" />
                    @else
                      <img src="{{ asset('admin/images/featured-table.png') }}" />
                    @endif
                    </div>
                    <div class="details">
                      <div class="d-flex align-items-center justify-content-between">
                        <label class="type">AD ID - {{ $latest->ad_id }}</label>
                        <label class="state">
                          <span class="icon address"></span>
                          {{get_state_short_code($latest->state_id)}}
                        </label>
                      </div>
                      <h3 class="name">{{ mb_strimwidth($latest->title, 0, 22,'...')}}</h3>
                      @if($latest->category_id == 1)
                        <label class="breedtype">Horse</label>
                      @elseif($latest->category_id == 2)
                        <label class="breedtype">Transport</label>
                      @elseif($latest->category_id == 3)
                        <label class="breedtype">Saddlery</label>
                      @elseif($latest->category_id == 4)
                        <label class="breedtype">Property</label>
                      @else
                        <label class="breedtype">NA</label>
                      @endif
                      @if($latest->item_show_type != 'free')
                        <p class="price">${{number_format($latest->price)}}
                          <sub>{{substr($latest->item_show_type,0,3)}}</sub>
                        </p>
                      @else
                        <p class="price">Free
                        </p>
                      @endif
                    </div>
                  </div>
                </a>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </section>
    @endif
    <section id="horseyard-adv">
      <div class="container">
        <div class="advertisement-inner">
          <div class="text">
            <h2 class="d-flex align-items-center">Advertise Now on <img src="{{ asset('frontend/images/logo.png') }}" alt="HorseYard"></h2>
            <p>Duis consectetur, enim vel eleifend venenatis, mauris nulla posuere felis, at facilisis lectus ligula at velit. Quisque rhoncus turpis quis leo placerat, nec gravida ligula consequat. Nunc a consectetur metus, eget interdum justo. Phasellus
              sit amet convallis leo.
            </p>
            <button type="button" class="btn btn-primary" onclick="window.location.href='{{ url('advertise') }}'">Advertise With Us</button>
          </div>
           <img src="{{ asset('frontend/images/horseyard-mobile.png') }}" class="adv-mobile" alt="Advertisement">
        </div>
      </div>
    </section>

    <section class="listings" id="stallion">
      <div class="container">
        <div class="d-flex align-items-center justify-content-between flex-sm-col">
            <h2>Stallions At Stud</h2>
            <a href="{{ url('search-latest-featured') }}{{ '/' }}{{'stallion'}}"class="link view-all-link">See All →</a>
        </div>
        <div class="isotope-main">
            <div class="tab-pane horses">
                <div class="slick-slider-main">
                    @foreach ($stallion_listings as $key => $stallion)
                      @php
                      $listingObj = getListingObj($stallion->listing_master_id);
                      $queryStr = $listingObj->generateQueryURL();
                      $stallion_image = get_listing_first_image($stallion->listing_master_id);
                      /*
                        $category_details = get_category_dynamic_details_for_search($stallion->identification_code, $stallion->category_id);

                        $attributes = generate_ad_attribute_view_url($category_details, $stallion->identification_code, $stallion->category_id); 
                       
                        if($stallion->category_id == 1)
                        {
                          $breed = dynamic_field_slug($category_details['horses_breed_primary']->dynamic_field_id);
                        }

                        $location = generate_location_view_url($stallion->identification_code)   
                        */
                      @endphp
                        <a href="{{ url('ad')}}/{{$stallion->slug}}">
                          <div class="element-item">
                              <div class="image-box">                               
                                @if(!empty($stallion_image))
                                  <img src="{{ asset('listing_images_250/'.$listingObj->id.'/'.$stallion_image->image_name) }}" />
                                @else
                                  <img src="{{ asset('admin/images/featured-table.png') }}" />
                                @endif
                              </div>
                              <div class="details">
                                  <div class="d-flex align-items-center justify-content-between">
                                      <label
                                          class="type">AD ID - {{ get_listing_ad_id($stallion->id) }}</label>
                                      <label class="state">
                                          <span class="icon address"></span>
                                          {{ get_state_short_code($stallion->state_id) }}
                                      </label>
                                  </div>
                                  <h3 class="name">
                                      {{ mb_strimwidth($stallion->title, 0, 22, '...') }}
                                  </h3>
                                  @if ($stallion->category_id == 1)
                                      <label class="breedtype">Horse</label>
                                  @elseif($stallion->category_id == 2)
                                      <label class="breedtype">Transport</label>
                                  @elseif($stallion->category_id == 3)
                                      <label class="breedtype">Saddlery</label>
                                  @elseif($stallion->category_id == 4)
                                      <label class="breedtype">Property</label>
                                  @else
                                      <label class="breedtype">NA</label>
                                  @endif
                                  @if ($stallion->item_show_type != 'free')
                                      <p class="price">${{ number_format($stallion->price) }}
                                          <sub>{{ substr($stallion->item_show_type, 0, 3) }}</sub>
                                      </p>
                                  @else
                                      <p class="price">Free
                                      </p>
                                  @endif
                              </div>
                          </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
      </div>
    </section>
    @if(!empty($blog_listings))
      <section class="listings" id="news">
        <div class="container">
          <div class="d-flex align-items-center justify-content-between flex-sm-col">
            <h2>Horseyard News</h2>
          </div>
          <div class="tab-pane">
            <div class="news-grid">
              @foreach($blog_listings as $key => $blog)
              <a href="{{ url('horse-articles-news')}}/{{$blog->slug}}">
                <div class="review-block">
                  <div class="image-block">
                    @if(empty($blog->image))
                      <img src="{{ url('noimage-big.jpg')}}" alt="News">
                    @else
                      <img src="{{ url('blog_images_250')}}{{'/'}}{{$blog->image}}" alt="News">
                    @endif
                  </div>
                  <div class="review-details">
                    <div class="d-flex align-items-center justify-content-between">
                      <!-- <h4>Reviews</h4> -->
                      <span class="date">{{date('M d', strtotime($blog->created_at)) }}</span>
                    </div>
                    <h3 class="review-title">{{$blog->title}}</h3>
                    <!-- <div class="comments">
                      <span class="icon comments"></span>
                      <span class="comment-count">11 comments</span>
                    </div> -->
                  </div>
                </div>
              </a>
              @endforeach
            </div>
          </div>
        </div>
      </section>
    @endif
    <section id="browse">
      <div class="container">
        <div class="accordion">
          <div class="accordion-item active">
            <div class="accordion-header">
              Browse by State
              <span class="icon acc-down"></span>
            </div>
            <div class="accordion-body">
              <ul class="listing">
                @foreach($all_state as $key => $value)                    
                  <li>
                    <a href="{{ url('horses-for-sale/location')}}/{{strtolower($value->state_code)}}" class="link">{{$value->state_name}}</a>
                  </li>                    
                @endforeach
              </ul>
            </div>
          </div>
          <div class="accordion-item">
            <div class="accordion-header">
              Browse by Breed
              <span class="icon acc-down"></span>
            </div>
            <div class="accordion-body">
              <ul class="listing">
                @foreach($horses_breed as $key => $breed_primary)                              
                  <li>
                    <a href="{{ url('horses-for-sale') }}/{{Str::slug($breed_primary->field_value,'-')}}" class="link">{{$breed_primary->field_value}}</a>
                  </li>                  
                @endforeach
              </ul>
            </div>
          </div>
          <div class="accordion-item">
            <div class="accordion-header">
              Browse by Color
              <span class="icon acc-down"></span>
            </div>
            <div class="accordion-body">
              <ul class="listing">
                @foreach($horses_color as $key => $color)                             
                  <li>
                    <a href="{{ url('horse-colour') }}/{{Str::slug($color->field_value,'-')}}" class="link">{{$color->field_value}}</a>
                  </li>
                @endforeach
              </ul>
            </div>
          </div>
          <div class="accordion-item">
            <div class="accordion-header">
              Browse by Gender
              <span class="icon acc-down"></span>
            </div>
            <div class="accordion-body">
              <ul class="listing">
                @foreach($horses_gender as $key => $gender)                               
                  <li>                   
                    <a href="{{ url('field-sex') }}/{{Str::slug($gender->field_value,'-')}}" class="link">{{$gender->field_value}}</a>
                  </li>
                @endforeach
              </ul>
            </div>
          </div>
          <div class="accordion-item">
            <div class="accordion-header">
              Browse by Skills/Discipline
              <span class="icon acc-down"></span>
            </div>
            <div class="accordion-body">
              <ul class="listing">
                @foreach($horses_discipline as $key => $discipline)                              
                  <li>
                    <a href="{{ url('horses-for-sale') }}/{{Str::slug($discipline->field_value,'-')}}" class="link">{{$discipline->field_value}}</a>
                  </li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
@section('js-content')
<script type="text/javascript" src="{{ asset('frontend/js/select2.min.js') }}?v={{ CSS_JS_VER }}"></script>
<script type="text/javascript" src="{{ asset('frontend/js/slick.min.js') }}?v={{ CSS_JS_VER }}"></script>
<script type="text/javascript" src="{{ asset('frontend/js/jquery-ui.min.js') }}?v={{ CSS_JS_VER }}"></script>
<script type="text/javascript" src="{{ asset('frontend/js/jquery.validate.min.js') }}?v={{ CSS_JS_VER }}"></script>
<script type="text/javascript" src="{{ asset('frontend/js/additional-methods.min.js') }}?v={{ CSS_JS_VER }}"></script>
<script type="text/javascript" src="{{ asset('frontend/js/custom.min.js') }}?v={{ CSS_JS_VER }}"></script>
@endsection
@push('custom-scripts')
  <script type="text/javascript" src="{{ asset('/frontend/custom_js_css/js/index.js') }}?v={{CSS_JS_VER}}"></script>
  <script type="text/javascript" src="{{ asset('/frontend/custom_js_css/js/ads_listing.js') }}?v={{CSS_JS_VER}}"></script>
@endpush