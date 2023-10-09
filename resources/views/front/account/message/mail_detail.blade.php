@extends('front.layouts.master')

@section('content')
    <div id="main">
        <section id="inbox">
            <div class="container">

                <div class="d-block d-lg-none inbox-menu mb-3">
                    <div class="d-flex align-items-center">
                        <span class="icon inbox-menu mr-2"></span> Inbox (999+)
                    </div>
                </div>
                @include('front.account.account_layout.left_menu')
                <div class="inbox-right inbox-view">
                    {!! $detail !!}
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
    <script type="text/javascript" src="{{ asset('/frontend/js/highlight.min.js') }}?v={{ CSS_JS_VER }}"></script>
    <script type="text/javascript" src="{{ asset('/frontend/js/quill.js') }}?v={{ CSS_JS_VER }}"></script>
    <script type="text/javascript" src="{{ asset('/frontend/js/katex.min.js') }}?v={{ CSS_JS_VER }}"></script>
    <script type="text/javascript" src="{{ asset('/frontend/custom_js_css/js/mail_detail.js') }}?v={{ CSS_JS_VER }}">
    </script>
@endpush
