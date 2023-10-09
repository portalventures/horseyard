@extends('front.layouts.master')
@section('title', $blog->title.' | Horseyard')
@section('canonical-content')
  <link rel="canonical" href="{{URL::current()}}"/>
@endsection
@section('css-content')  
  <link rel="stylesheet" href="{{ asset('/frontend/css/custom.min.css') }}?v={{ CSS_JS_VER }}">  
  <link rel="stylesheet" href="{{ asset('/frontend/custom_js_css/css/custom.css') }}?v={{ CSS_JS_VER }}"> 
@endsection
@section('content')
  <div id="main">
    <!-- <div class="breadcrumbs">
      <div class="container">
        <ul>
          <li><a href="{{URL::to('/')}}">Home</a></li>
          <li><a href="#">Horses for sale</a></li>
          <li><a href="#">Thorough bred</a></li>
          <li>Handsome & Smart Dressage/Show prospect</li>
        </ul>
      </div>
    </div> -->
    <section class="singlepage">
      <div class="container">
        <div class="blog-main">
          <div class="product-detail">
            <div class="product-detail-image">
              <img src="{{ url('blog_images')}}{{'/'}}{{$blog->image}}" alt="Product detail" class="product-main-image">
            </div>
            <h1 class="product-name">{{ $blog->title }}</h1>
            <div class="d-flex align-items-center justify-content-between flex-sm-wrap">
              <div class="d-flex align-items-center flex-sm-wrap">
              <!--  <button type="button" class="btn btn-primary">Reviews</button> -->
                <span class="product-date">{{ isset($blog->created_at) ? date('M d, y', strtotime($blog->created_at)) : '' }}</span>
              </div>
              <!-- <div class="share-listing">
                <ul>
                  <li><a href="#"><span class="icon share-facebook"></span></a></li>
                  <li><a href="#"><span class="icon share-instagram"></span></a></li>
                  <li><a href="#"><span class="icon share-twitter"></span></a></li>
                  <li><a href="#"><span class="icon share-mail"></span></a></li>
                </ul>
              </div> -->
            </div>
            <div class="product-description">
              <p>{!! $blog->detailed_text !!}</p>              
            </div>
            <!--
            <div class="recently-viewed">
              <h4>You May Also Like These Articles</h4>
              <div class="isotope-main">
                <div class="tab-pane">
                  <div class="review-block blog-block">
                    <div class="image-block">
                      <img src="assets/images/blog-1.png" alt="Blogs">
                    </div>
                    <div class="review-details">
                      <div class="d-flex align-items-center justify-content-between">
                        <h4>Reviews</h4>
                        <span class="date">July 21</span>
                      </div>
                      <h3 class="review-title">Top 5 Horse Riding Lessons in Central Victoria</h3>
                      <p class="blog-shortdescription">(Snitzel x Gopana) has been professionally schooled to (Snitzel x Gopana) has been professionally schooled to</p>
                      <div class="comments">
                        <span class="icon blog-comments"></span>
                        <span class="comment-count">11</span>
                      </div>
                    </div>
                  </div>
                  <div class="review-block blog-block">
                    <div class="image-block">
                      <img src="assets/images/blog-2.png" alt="Blog">
                    </div>
                    <div class="review-details">
                      <div class="d-flex align-items-center justify-content-between">
                        <h4>Reviews</h4>
                        <span class="date">July 21</span>
                      </div>
                      <h3 class="review-title">Top 5 Horse Riding Lessons in Central Victoria</h3>
                      <div class="comments">
                        <span class="icon blog-comments"></span>
                        <span class="comment-count">11</span>
                      </div>
                    </div>
                  </div>
                  <div class="review-block blog-block">
                    <div class="image-block">
                      <img src="assets/images/blog-3.png" alt="Blog">
                    </div>
                    <div class="review-details">
                      <div class="d-flex align-items-center justify-content-between">
                        <h4>Reviews</h4>
                        <span class="date">July 21</span>
                      </div>
                      <h3 class="review-title">Top 5 Horse Riding Lessons in Central Victoria</h3>
                      <p class="blog-shortdescription">(Snitzel x Gopana) has been professionally schooled to</p>
                      <div class="comments">
                        <span class="icon blog-comments"></span>
                        <span class="comment-count">11 comments</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
-->
          </div>
          <div class="blog-adv">
            <img src="{{ asset('frontend/images/blog-adv1.png') }}" alt="Blog adv">
            <img src="{{ asset('frontend/images/blog-adv2.png') }}" alt="Blog adv">
          </div>
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
  <script type="text/javascript" src="{{ asset('/frontend/custom_js_css/js/blogs.js') }}?v={{CSS_JS_VER}}"></script>
@endpush