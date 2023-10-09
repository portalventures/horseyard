@extends('front.layouts.master')
@section('title', 'Privacy Policy - Horseyard')
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
          <li><a href="{{ url('/') }}">Home</a></li>
          <li><a href="#">Data Privacy</a></li>
        </ul>
      </div>
    </div>
    <section class="singlepage">
      <div class="container">
        <div class="blog-main">
          <div class="product-detail">
            <h1 class="product-name">Data Privacy</h1>
            <div class="product-description">
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec blandit lacus lacus, et laoreet quam auctor a. Sed sapien quam, tristique quis diam vel, iaculis tincidunt enim. Aliquam venenatis urna dui, sit amet sodales diam laoreet et.
                Aenean nec enim et leo molestie rhoncus. Morbi pharetra ligula ac mauris consequat imperdiet. Donec non magna ut tortor tristique fringilla sed vel elit. Sed a pharetra risus. Maecenas interdum at diam eu congue. Donec sem risus, ullamcorper
                vitae tristique nec, rutrum eu magna. Mauris massa ante, tempor at tempus sed, lobortis eget risus. Vestibulum luctus condimentum enim, a vulputate nisi molestie nec. Morbi nulla arcu, dignissim ac vestibulum vitae, sollicitudin ut massa.
                Quisque vel vulputate nisl. Nulla convallis ipsum sed massa condimentum ullamcorper posuere sit amet nisi.
              </p>
              <p>Pellentesque gravida arcu eget felis egestas, sit amet viverra sapien vestibulum. Donec sed neque justo. Quisque eget ullamcorper ante. Nullam semper neque at erat venenatis rhoncus nec et tortor. Class aptent taciti sociosqu ad litora torquent
                per conubia nostra, per inceptos himenaeos. Pellentesque auctor lacinia nisi, in varius justo vestibulum id. Pellentesque eu ante sem.</p>
              <p>Donec egestas, enim eu rutrum dictum, libero tortor finibus ligula, eu commodo sapien sem ac velit. Fusce placerat, ex in egestas scelerisque, augue diam condimentum tellus, a pharetra risus orci vel leo. In imperdiet euismod lacus eget
                faucibus. Aenean venenatis fringilla tellus, vel malesuada dolor finibus nec. Donec commodo in eros eu ullamcorper. Sed posuere elit eget est aliquam auctor. Ut luctus commodo felis in dictum. In lacinia magna in ligula porttitor, in imperdiet
                leo pretium.</p>
            </div>
            </div>
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
  <script type="text/javascript" src="{{ asset('frontend/js/custom.min.js') }}?v={{ CSS_JS_VER }}"></script>
@endsection
