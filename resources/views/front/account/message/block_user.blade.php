@extends('front.layouts.master')
@section('title', 'Block User, Horseyard')
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
                        <span class="icon block-user"></span> Block a user
                    </h3>
                    <div class="card mb-3">
                        <div class="card-content">
                            <div class="info-details m-0">
                                <form action="" class='block-form'>
                                    <div class="form-group">
                                        <div class="row flex-column flex-md-row">
                                            <div class="col col-md-2">
                                                <label for="" class="text-nowrap">User name</label>
                                            </div>
                                            <div class="col pl-md-0 col-md-5">
                                                <select id="blockUserId" name="blockUserId" class="form-control"
                                                    data-error="#errNm1"></select>
                                                <div id="errNm1"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" form-group m-0 ">
                                        <div class="row flex-column flex-md-row ">
                                            <div class="col col-md-2 "></div>
                                            <div class="col pl-md-0 col-md-5 ">
                                                <button type="submit " class="btn btn-primary ">Block user</button>
                                                <label id="errorSubmit" style="color:red;"></label>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="table-outer frontend w-100">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th class="unblock ">Unblock</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detail as $user)
                                    <?php
                                    $name = '';
                                    if ($user->first_name == '' || $user->first_name == null) {
                                        $name = explode('@', $user->email)[0];
                                    } else {
                                        $name = $user->first_name . ' ' . $user->last_name;
                                    }
                                    ?>
                                    <tr>
                                        <td>{{ $name }}</td>
                                        <td class="unblock">
                                          <a href="javascript:void(0)" onclick="unblock_user('{{ $user->to_user }}',this)"><span class="icon unblock "></span></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
    <script type="text/javascript" src="{{ asset('/frontend/custom_js_css/js/block_user.js') }}?v={{ CSS_JS_VER }}">
    </script>
@endpush
