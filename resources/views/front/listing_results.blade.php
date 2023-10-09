@extends('front.layouts.master')

@php
  $sortBy = session()->get('sortMethod');
  $perpage = session()->get('perPageCnt');
  $TitleTxt = session()->get('TitleTxt');
  $searchParams = session()->get('searchParams');  
@endphp

@if(Request::segment(3) == 'negotiable')
  @section('title', 'Bargain Barges Listing, Horseyard')

@elseif(Request::segment(1) == 'horses-for-sale' && $TitleTxt == '')
  @section('title', 'Horses for Sale')

@elseif(Request::segment(1) == 'transport-for-horses' && $TitleTxt == '')
  @section('title', 'Horse Transport for Sale')

@elseif(Request::segment(1) == 'saddlery-and-tack' && $TitleTxt == '')
  @section('title', 'Saddlery and Tack for Sale')

@elseif(Request::segment(1) == 'property-for-sale' && $TitleTxt == '')
  @section('title', 'Property for Sale')

@elseif(Request::segment(1) == 'search-listing-classifieds' || $TitleTxt == '')
  @section('title', 'Search Listing, Horseyard')

@elseif($TitleTxt == 'featured')
  @section('title', ucwords($TitleTxt).' Lisintgs-Horseyard')

@elseif($TitleTxt == 'latest')
  @section('title', ucwords($TitleTxt).' Lisintgs-Horseyard')

@elseif($TitleTxt == 'stallion')
  @section('title', ucwords($TitleTxt).' Lisintgs-Horseyard')

@elseif( Request::segment(1) == 'horse-colour')
  @section('title', ucwords($TitleTxt).' Horses for Sale | Horseyard')

@elseif( Request::segment(1) == 'field-sex')
  @section('title', ucwords($TitleTxt).' Horses for Sale | Horseyard')

@elseif( Request::segment(1) == 'rider-level')
  @section('title', ucwords($TitleTxt).' Horses for Sale | Horseyard')

@elseif( Request::segment(1) == 'field-height' || Request::segment(1) == 'max-field-height')
  @section('title', 'Horses with height '.ucwords($TitleTxt).' for Sale | Horseyard')

@elseif( Request::segment(2) == 'location' || Request::segment(1) == 'suburb')  
  @if($searchParams->top_category == 'horses')
    @section('title', ucwords($TitleTxt).' Horses for Sale | Horseyard')

  @elseif($searchParams->top_category == 'transport')
    @section('title', ucwords($TitleTxt).' Horse Transport for Sale | Horseyard')

  @elseif($searchParams->top_category == 'saddlery')
    @section('title', ucwords($TitleTxt).' Saddlery and Tack for Sale | Horseyard')

  @elseif($searchParams->top_category == 'property')
    @section('title', ucwords($TitleTxt).' Property for Sale | Horseyard')
    
  @endif
@elseif( Request::segment(1) == 'ramp-location')
  @section('title', ucwords($TitleTxt).' Horse Transport for Sale | Horseyard')

@elseif( Request::segment(1) == 'transport-for-horses')
  @section('title', ucwords($TitleTxt).' Horse Transport for Sale | Horseyard')

@elseif( Request::segment(1) == 'axles')
  @section('title', ucwords($TitleTxt).' Horse Transport for Sale | Horseyard')

@elseif( Request::segment(1) == 'field-location-of-vehicle-state')
  @section('title', ucwords($TitleTxt).' Horse Transport for Sale | Horseyard')

@elseif( Request::segment(1) == 'saddlery-type')
  @section('title', ucwords($TitleTxt).' Saddlery and Tack for Sale | Horseyard')

@else
  @section('title', ucwords(str_replace('-',' ',$TitleTxt)). ' Horses for Sale | Horseyard')
@endif

@section('canonical-content')
  @php $filter_canonical_url = '';
    if(Request::exists('page'))
    {
      $filter_canonical_url = request()->url().'?page='.request()->query('page');
    }
    else{
      $filter_canonical_url = request()->url();
    }    
  @endphp
  <link rel="canonical" href="{{$filter_canonical_url}}"/>
@endsection
@section('css-content')  
  <link rel="stylesheet" type="text/css" href="{{ asset('/frontend/css/sweetalert.min.css') }}?v={{ CSS_JS_VER }}">  
  <link rel="stylesheet" href="{{ asset('/frontend/css/custom.min.css') }}?v={{ CSS_JS_VER }}">  
  <link rel="stylesheet" href="{{ asset('/frontend/custom_js_css/css/custom.css') }}?v={{ CSS_JS_VER }}"> 
@endsection
@section('content')
  <div id="main">
    <section id="advertisement">
      <div class="container">
        <div class="d-flex align-items-center justify-content-center">
          <a href="#">
            <img src="{{ asset('frontend/images/adv-golf.png')}}" alt="Advertisement">
          </a>
        </div>
      </div>
    </section>
    <section class="search-results-main">
      <div class="container">
        <div class="d-flex">
          <div class="left-filters">
            <form action="{{ url('search_page_filter')}}" class="search_page_form" method="post">            
            @csrf
            <div class="filter-col">
              <input type="hidden" name="search_page" id="search_page" value="search_page">
              <div class="d-flex align-items-center justify-content-between filter-header">
                <h5 class="d-flex align-items-center"><span class="icon filter"></span>Refine Search</h5>
                <a href="javascript:void(0)" class="link clear_all_filters" data-href="{{ url('horses-for-sale')}}">clear all</a>
              </div>
            
              <div class="filter-block">
                <!-- <h4>{{session()->get('searchParams')->top_category}}</h4> -->
                <div class="filter-type noSpace">
                  <div class="selectParent">
                    <select name="category" id="category" class="category">
                      <!-- <option value="">Select Category</option> -->
                      @foreach(session()->get('topCategories') as $key => $category)
                        <option value="{{strtolower($category->category_name)}}"
                          @if(session()->get('searchParams')->top_category == $category->category_name) {{'selected'}} @endif
                          >{{ucfirst($category->category_name)}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              @if(session()->get('searchParams')->top_category == "property")
                @include('front.listing_left_param_property_view')
              @elseif(session()->get('searchParams')->top_category == "saddlery")
                @include('front.listing_left_param_saddle_view')
              @elseif(session()->get('searchParams')->top_category == "transport")
                @include('front.listing_left_param_trans_view')
              @else
                @include('front.listing_left_param_horses_view')
              @endif
              <div class="filter-block">
                <h4>Location</h4>
                <div class="filter-type">
                  @foreach(session()->get('allStates') as $key => $value)
                    <label for="adultridingclub1_state{{$key}}" class="customCheckbox">
                      <input type="checkbox" id="adultridingclub1_state{{$key}}" value="{{$value->state_id}}" name="search_state[]" class="search_state" {{ !empty($searchParams->selectedLocation) && in_array($value->state_id,$searchParams->selectedLocation) ? 'checked' : '' }}>
                      <span></span>
                      {{$value->state_name}}
                    </label>                    
                  @endforeach
                </div>
              </div>
            </div>
            <div class="advertisement-block">
              <img src="{{asset('frontend/images/filter-adv1.png')}}" alt="Advertisement">
            </div>
            <div class="advertisement-block">
              <img src="{{asset('frontend/images/filter-adv2.png')}}" alt="Advertisement">
            </div>
          </div>
          <div class="right-results">
            <div class="d-flex">
              <div class="stats">    
                @if(empty($search_result))
                  <h2>No result found</h2>
                  <span>Please widen your search</span>
                @else
                  @if($search_result->total() == 0)
                    <h2>No result found</h2>
                    <span>Please widen your search</span>
                  @else
                    <h2>Showing {{ $search_result->firstItem() }} to {{ $search_result->lastItem() }} of  {{$search_result->total()}} results</h2>
                  @endif
                @endif
              </div>
              <div class="toolbar">
                <div class="selectParent">
                  <select name="sortby" id="sortBy" class="sortBy">
                    <option value="featured" {{ $sortBy == 'featured' ? 'selected' : ''}}>Featured Listings</option>
                    <option value="latest" {{ $sortBy == 'latest' ? 'selected' : ''}}>Latest Listings</option>
                    <option value="a_z" {{ $sortBy == 'a_z' ? 'selected' : ''}}>A - Z</option>
                    <option value="z_a" {{ $sortBy == 'z_a' ? 'selected' : ''}}>Z - A</option>
                    <option value="price_high_to_low" {{ $sortBy == 'price_high_to_low' ? 'selected' : ''}}>Price High to Low</option>
                    <option value="price_low_to_high" {{ $sortBy == 'price_low_to_high' ? 'selected' : ''}}>Price Low to High</option>
                  </select>
                </div>
                <div class="selectParent">
                  <select name="perpage" id="perpage" class="perpage">
                  <option value="20" {{ $perpage == '20' ? 'selected' : ''}}>20 Listings</option>
                  <option value="30" {{ $perpage == '30' ? 'selected' : ''}}>30 Listings</option>
                  <option value="40" {{ $perpage == '40' ? 'selected' : ''}}>40 Listings</option>
                </select>
                </div>
              </div>
            </div>
            </form>
              <div class="stats">                
                @if(isset($userSearchText) && !empty($userSearchText))
                  <span>You searched for {{ $userSearchText }} </span>
                @else
                  <span><!-- You have not selected a filter criteria --> </span>
                @endif
              </div>            
            <div class="search_result">
              @include('front.search_listing')
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="riders">
      <div class="container">
        <div class="riders-inner">
          <div class="text">
            <h3>Suits All Level Riders</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin leo lectus, cursus eget tincidunt ullamcorper, pellentesque ac nisi. Etiam id ante ac risus lacinia commodo. Nulla sit amet ullamcorper ipsum, quis imperdiet ex. Pellentesque rhoncus
              maximus efficitur. Nam egestas volutpat varius. Praesent malesuada ligula at metus convallis suscipit. Maecenas vel enim et magna consequat pulvinar ac in eros.</p>
          </div>
          <img src="{{ asset('frontend/images/riders.png')}}" alt="Riders">
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
  <script type="text/javascript" src="{{ asset('/frontend/custom_js_css/js/wishlist.js') }}?v={{CSS_JS_VER}}"></script>
  <script type="text/javascript" src="{{ asset('/frontend/custom_js_css/js/search.js') }}?v={{CSS_JS_VER}}"></script>
@endpush