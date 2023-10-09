@extends('front.layouts.master')

@if($listing == 'featured')
  @section('title', 'Featured Lisintgs-Horseyard')
@elsif($listing == 'latest')
  @section('title', 'Latest Lisintgs-Horseyard')
@else
  @section('title', 'Search Lisintg, Horseyard')
@endif

@section('css-content')  
  <link rel="stylesheet" href="{{ asset('/frontend/css/custom.min.css') }}?v={{ CSS_JS_VER }}">  
  <link rel="stylesheet" href="{{ asset('/frontend/custom_js_css/css/custom.css') }}?v={{ CSS_JS_VER }}"> 
@endsection
@section('content')
    <div id="main">
        <section id="advertisement">
            <div class="container">
                <div class="d-flex align-items-center justify-content-center">
                    <a href="#">
                        <img src="{{ asset('frontend/images/adv-golf.png') }}" alt="Advertisement">
                    </a>
                </div>
            </div>
        </section>
        <section class="search-results-main">
            <div class="container">
                <div class="d-flex">
                    <div class="left-filters">
                        <form action="{{ url('search-results') }}" class="search_page_form" method="get">
                            @csrf
                            @if(session()->get('searchParams')->top_category == "horses")
                            @include('front.listing_left_param_view')
                            @else
                            @include('front.listing_left_param_trans_view')
                            @endif
                            <div class="advertisement-block">
                                <img src="{{ asset('frontend/images/filter-adv1.png') }}" alt="Advertisement">
                            </div>
                            <div class="advertisement-block">
                                <img src="{{ asset('frontend/images/filter-adv2.png') }}" alt="Advertisement">
                            </div>
                    </div>
                    <div class="right-results">
                        <div class="d-flex">
                            <div class="stats">
                                <h2>Showing {{ $search_result->firstItem() }} to {{ $search_result->lastItem() }} of
                                    total {{ $search_result->total() }} items</h2>
                                {{-- <span>You searched for Allrounder horses</span> --}}
                            </div>
                            <div class="toolbar">
                                <div class="selectParent">
                                    <select name="sortby" id="sortBy" class="sortBy">
                                        <option value="featured" {{ $listing == 'featured' ? 'selected' : '' }}>Featured
                                            Listings</option>
                                        <option value="latest" {{ $listing == 'latest' ? 'selected' : '' }}>Latest
                                            Listings</option>
                                        <option value="a_z" {{ $sortby == 'a_z' || $listing == '' ? 'selected' : '' }}>A - Z</option>
                                        <option value="z_a" {{ $sortby == 'z_a' ? 'selected' : '' }}>Z - A</option>
                                        <option value="price_high_to_low"
                                            {{ $sortby == 'price_high_to_low' ? 'selected' : '' }}>Price High to Low
                                        </option>
                                        <option value="price_low_to_high"
                                            {{ $sortby == 'price_low_to_high' ? 'selected' : '' }}>Price Low to High
                                        </option>
                                    </select>
                                </div>
                                <div class="selectParent">
                                    <select name="perpage" id="perpage" class="perpage">
                                        <option value="20" {{ $perpage == '20' ? 'selected' : '' }}>20 Listings</option>
                                        <option value="30" {{ $perpage == '30' ? 'selected' : '' }}>30 Listings</option>
                                        <option value="40" {{ $perpage == '40' ? 'selected' : '' }}>40 Listings</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        </form>
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
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin leo lectus, cursus eget tincidunt
                            ullamcorper, pellentesque ac nisi. Etiam id ante ac risus lacinia commodo. Nulla sit amet
                            ullamcorper ipsum, quis imperdiet ex. Pellentesque rhoncus
                            maximus efficitur. Nam egestas volutpat varius. Praesent malesuada ligula at metus convallis
                            suscipit. Maecenas vel enim et magna consequat pulvinar ac in eros.</p>
                    </div>
                    <img src="{{ asset('frontend/images/riders.png') }}" alt="Riders">
                </div>
            </div>
        </section>
    </div>
@endsection
@section('js-content')
  <script type="text/javascript" src="{{ asset('frontend/js/select2.min.js') }}?v={{ CSS_JS_VER }}"></script>  
  <script type="text/javascript" src="{{ asset('frontend/js/jquery-ui.min.js') }}?v={{ CSS_JS_VER }}"></script>
  <script type="text/javascript" src="{{ asset('frontend/js/jquery.validate.min.js') }}?v={{ CSS_JS_VER }}"></script>
  <script type="text/javascript" src="{{ asset('frontend/js/additional-methods.min.js') }}?v={{ CSS_JS_VER }}"></script>  
  <script type="text/javascript" src="{{ asset('frontend/js/sweetalert.min.js') }}?v={{ CSS_JS_VER }}"></script>
  <script type="text/javascript" src="{{ asset('frontend/js/custom.min.js') }}?v={{ CSS_JS_VER }}"></script>
@endsection
@push('custom-scripts')
    <script type="text/javascript" src="{{ asset('/frontend/custom_js_css/js/wishlist.js') }}?v={{ CSS_JS_VER }}">
    </script>
    <script type="text/javascript" src="{{ asset('/frontend/custom_js_css/js/search.js') }}?v={{ CSS_JS_VER }}">
    </script>
@endpush
