@extends('front.layouts.master')
@section('title', 'Messages, HorseYard')
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
                        <span class="icon inbox-menu mr-2"></span> Inbox (999+)
                    </div>
                    <label class="errorMessage" style="color:red;"></label>
                </div>
                @include('front.account.account_layout.left_menu')
                <div class="inbox-right">
                    <h3 class="create-listing-title d-flex align-items-center d-none d-lg-flex">
                        <span class="icon inbox"></span> Inbox
                    </h3>
                    <div id="dvInboxList" data-start='0' data-limit='3'>                        
                        {!! $list !!}
                    </div>
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
    <script type="text/javascript" src="{{ asset('/frontend/custom_js_css/js/inbox_list.js') }}?v={{ CSS_JS_VER }}">
    </script>
@endpush
