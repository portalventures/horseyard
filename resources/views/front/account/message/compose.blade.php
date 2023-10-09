@extends('front.layouts.master')
@section('title', 'Write new message, HorseYard')
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
                    <label id="errorSubmit errorMessage"></label>
                </div>
                @include('front.account.account_layout.left_menu')
                <div class="inbox-right">
                    <h3 class="create-listing-title d-flex align-items-center d-none d-lg-flex">
                        <span class="icon compose"></span> Compose
                    </h3>
                    <form action="send_message" class="inbox-form">
                        <div class="form-group">
                            <label for="composeTo">To</label>
                            <div class="flex-grow-1 ml-2">
                                <select id="composeTo" name="composeTo[]" class="form-control"
                                    data-error="#errNm1"></select>
                                <div id="errNm1" class="position-absolute"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Subject</label>
                            <div class="flex-grow-1 ml-2">
                                <input type="text" id="subject" name="subject" class="form-control"
                                    placeholder="Enter your subject" data-error="#errNm2">
                                <div id="errNm2" class="position-absolute"></div>
                            </div>
                        </div>
                        <div class="form-group flex-wrap">
                            <label for="">Message</label>
                            <textarea name="message" id="message" cols="30" rows="10" class="form-control"
                                placeholder="Message goes here" data-error="#errNm3"></textarea>
                            <div id="errNm3"></div>
                            <div class="file-types new">
                            </div>
                            <div class="addAttachments">
                              <a href="javascript:void(0)"class="btn btn-primary d-flex align-items-center">
                                Add Attachments
                                <span class="icon addAttachment-white ml-2"></span>
                              </a>
                              <input name="attachment[]" type="file" multiple="multiple" placeholder="Add Attachments" onchange="getFileNames(this)">
                            </div>
                        </div>
                        <input type="hidden" id="parentMailId" name="parentMailId" value="0" />
                        <input type="hidden" id="mailTo" name="mailTo" value="0" />
                        <button type="submit" id="btnSubmit" class="btn btn-primary">Send message</button>
                    </form>
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
    <script type="text/javascript" src="{{ asset('/frontend/custom_js_css/js/compose_mail.js') }}?v={{ CSS_JS_VER }}">
    </script>
@endpush
