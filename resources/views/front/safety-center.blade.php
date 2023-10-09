@extends('front.layouts.master')
@section('title', 'Safety & Security - Horseyard')
@section('canonical-content')
  <link rel="canonical" href="{{URL::current()}}"/>
@endsection
@section('css-content')  
  <link rel="stylesheet" href="{{ asset('/frontend/css/custom.min.css') }}?v={{ CSS_JS_VER }}">  
  <link rel="stylesheet" href="{{ asset('/frontend/custom_js_css/css/custom.css') }}?v={{ CSS_JS_VER }}"> 
@endsection
@section('content')
  <div id="main">
    <div class="breadcrumbs">
      <div class="container">
        <ul>
          <li><a href="{{url('/')}}">Home</a></li>
          <li>Safety centre</li>
        </ul>
      </div>
    </div>
    <section class="brand-overview safety-center">
      <div class="container">
        <div class="d-flex">
          <div class="col d-flex justify-content-center flex-col">
            <h1 class="page-title-large">Horse yard safety centre</h1>
            <p>Selling on Horseyard should be a pleasant, hassle-free experience. We do everything we can to make sure that's the case. Our handy We do everything we can to make sure that's the case. Our handy buying or selling a horse.</p>
          </div>
          <div class="col brand-image">
            <span class="icon shield-check"></span>
            <h4>Spotted an issue we should know about? Let us know</h4>
            <p><a href="#">Email</a>&nbsp;or call us on 0330 303 9001</p>
          </div>
        </div>
      </div>
    </section>
    <section class="safety-center-info">
      <div class="container">
        <div class="col-left">
          <h2>Buying on HorseYard</h2>
          <p>At Horseyard, it is important to us that all of our users have a safe, successful and enjoyable experience. Whether you are hoping to buy or to sell a horse, following these tips and guidelines will help you safely navigate our site. List your
            horse and find the perfect buyer, or discover the horse that fits your goals and dreams.</p>
          <a href="#">Learn More&nbsp;<span class="icon right-arrow-orange"></span></a>
          <h2>Selling on HorseYard</h2>
          <p>At Horseyard, it is important to us that all of our users have a safe, successful and enjoyable experience. Whether you are hoping to buy or to sell a horse, following these tips and guidelines will help you safely navigate our site. List your
            horse and find the perfect buyer, or discover the horse that fits your goals and dreams.</p>
          <a href="#">Learn More&nbsp;<span class="icon right-arrow-orange"></span></a>
          <h2>Safety Center</h2>
          <p>At Horseyard, it is important to us that all of our users have a safe, successful and enjoyable experience. Whether you are hoping to buy or to sell a horse, following these tips and guidelines will help you safely navigate our site. List your
            horse and find the perfect buyer, or discover the horse that fits your goals and dreams.</p>
          <a href="#">Learn More&nbsp;<span class="icon right-arrow-orange"></span></a>
        </div>
        <div class="col-right">
          <h3>Other places to go for advice</h3>
          <p><a href="#" target="_blank">The little black book of scams&nbsp;<span class="icon outsidelink"></span></a> a great publication with information and tips on a wide range of online and offline scams, produced by the Australian Competition and
            Consumer Commission.</p>
          <p><a href="#" target="_blank">Scamwatch.gov.au&nbsp;<span class="icon outsidelink"></span></a> Contains lots of information on how to recognise scams and how to report them to the Australian Competition and Consumer Commission.</p>
          <p><a href="#" target="_blank">Get Safe Online&nbsp;<span class="icon outsidelink"></span></a> an online safety guide with top 10 safety tips is well worth checking out.</p>
        </div>
      </div>
    </section>
  </div>

  @endsection
@section('js-content')  
  <script type="text/javascript" src="{{ asset('frontend/js/jquery-ui.min.js') }}?v={{ CSS_JS_VER }}"></script>
  <script type="text/javascript" src="{{ asset('frontend/js/jquery.validate.min.js') }}?v={{ CSS_JS_VER }}"></script>
  <script type="text/javascript" src="{{ asset('frontend/js/additional-methods.min.js') }}?v={{ CSS_JS_VER }}"></script>  
  <script type="text/javascript" src="{{ asset('frontend/js/custom.min.js') }}?v={{ CSS_JS_VER }}"></script>
@endsection