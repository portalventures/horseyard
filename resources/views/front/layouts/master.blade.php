<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    @if(isset($current_page) && $current_page == 'view_listing')
      <meta name="twitter:card" content="summary_large_image"/> 
      <meta property="og:title" content="{{ $listing->title ?? ''}}">
      @php
        $listing_image = get_listing_first_image($listing->id);
      @endphp
      <meta property="og:image" content="{{ url($listing_image->image_url.'/'.$listing_image->image_name) }}">
      <meta property="og:description" content="{{$listing->description ?? ''}}">  
      <meta property="og:url" content="{{url()->current()}}">
      <meta property="og:type" content="website" />
    @endif

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/frontend/images/favicon.png') }}?v={{ CSS_JS_VER }}">
    <link rel="stylesheet" href="{{ asset('/admin/css/bootstrap.min.css') }}?v={{ CSS_JS_VER }}">
    <link rel="stylesheet" href="{{ asset('/frontend/css/fonts.min.css') }}?v={{ CSS_JS_VER }}">
    <link rel="stylesheet" href="{{ asset('/frontend/css/select2.min.css') }}?v={{ CSS_JS_VER }}">    
    <link rel="stylesheet" href="{{ asset('/frontend/css/jquery-ui.min.css') }}?v={{ CSS_JS_VER }}">
    @yield('canonical-content')    
    @yield('css-content')
</head>

<body class="@yield('bodycls')">
    @include('front.layouts.header')
    @yield('content')
    @if (!isset($view))
      @include('front/layouts/footer')
    @endif
    @include('front.layouts.js_list')
    @yield('js-content')
    @stack('plugin-scripts')
    @stack('custom-scripts')
</body>

</html>
