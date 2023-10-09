@extends('front.layouts.master')

@if($current_page == 'blogs')
  @section('title', 'Latest Horse Articles & News, Horseyard')
@elseif($current_page == 'news')
  @section('title', 'Latest Horse News, Horseyard')
@elseif($current_page == 'article')
  @section('title', 'Latest Horse Articles, Horseyard')
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
  <link rel="stylesheet" href="{{ asset('/frontend/css/custom.min.css') }}?v={{ CSS_JS_VER }}">  
  <link rel="stylesheet" href="{{ asset('/frontend/custom_js_css/css/custom.css') }}?v={{ CSS_JS_VER }}"> 
@endsection
@section('content')
  <div id="main">
    <section class="blog" id="blog-list" data-lastPage="{{$blogs->lastPage()}}">
      <div class="container">
        <h1 class="page-title">Horseyard Blog</h1>
        <div class="d-flex align-items-center justify-content-between">
          <div class="blog-tabs">
          <a href="{{ url('all-news') }}">
            <span class="{{ isset($current_page) && $current_page == 'blogs' ? 'active' : ''}}">
              All
            </span></a>
            <a href="{{ url('horse-articles-news') }}{{'/'}}{{'news'}}">
              <span class="{{ isset($current_page) && $current_page == 'news' ? 'active' : ''}}">
              News
            </span></a>
            <a href="{{ url('horse-articles-news') }}{{'/'}}{{'article'}}">
              <span class="{{ isset($current_page) && $current_page == 'article' ? 'active' : ''}}">
              Article
            </span></a>
          </div>
          <div class="search-blog">
            <form action="{{ url('blog_search')}}" method="GET" class="blog_search_form">              
              <input type="text" placeholder="Search..." name="blog_search_key" id="blog_search" value="{{ isset($search_key_word) ? $search_key_word : ''}}">
              <span class="icon search"></span>
            </form>
          </div>
        </div>
        <div class="blog-main">
          <div class="reviews-grid">

            @foreach($blogs as $key => $blog)
              <a href="{{ url('horse-articles-news')}}{{'/'}}{{$blog->slug}}">
                <div class="review-block all blog-block {{ $blog->category_id }}">
                  <div class="image-block">
                    @if(empty($blog->image))
                    <img src="{{ url('/noimage-big.jpg')}}" alt="No Image">
                    @else
                    <img src="{{ url('blog_images_250')}}{{'/'}}{{$blog->image}}" alt="Blog Image">
                    @endif
                  </div>
                  <div class="review-details">
                    <div class="d-flex align-items-center justify-content-between">
                      <h4>{{ $blog->category_id }}</h4>
                      <span class="date">
                        {{ isset($blog->created_at) ? date('M d', strtotime($blog->created_at)) : '' }}
                      </span>
                    </div>
                    <h3 class="review-title">{{ mb_strimwidth($blog->title, 0, 44,'...')}}</h3>
                    <p class="blog-shortdescription">{!! mb_strimwidth($blog->detailed_text, 0, 78,'...') !!}</p>
                    <!-- <div class="comments">
                      <span class="icon blog-comments"></span>
                      <span class="comment-count">11</span>
                    </div> -->
                  </div>
                </div>
              </a>
            @endforeach

           <!--  <div class="blog-adv-middle">
              <img src="{{asset('frontend/images/blog-adv.png')}}" alt="Blog adv">
            </div> -->

          </div>
          <div class="blog-adv">
            <img src="{{ asset('frontend/images/blog-adv1.png') }}" alt="Blog adv">
            <img src="{{ asset('frontend/images/blog-adv2.png') }}" alt="Blog adv">
          </div>
        </div>        
        <div class="m-5 pagination justify-content-center">    
          {{ $blogs->onEachSide(0)->links() }}
        </div>
      </div>
    </section>
  </div>
@endsection
@section('js-content')  
  <script type="text/javascript" src="{{ asset('frontend/js/jquery-ui.min.js') }}?v={{ CSS_JS_VER }}"></script>  
  <script type="text/javascript" src="{{ asset('frontend/js/custom.min.js') }}?v={{ CSS_JS_VER }}"></script>
@endsection
@push('custom-scripts')
  <script type="text/javascript" src="{{ asset('/frontend/custom_js_css/js/blog.js') }}?v={{CSS_JS_VER}}"></script>
@endpush