@extends('front.layouts.master')
@section('title', 'Manage Ads, Horseyard')
@section('canonical-content')
  <link rel="canonical" href="{{URL::current()}}"/>
@endsection
@section('css-content')
  <link rel="stylesheet" href="{{ asset('/frontend/css/slick.min.css') }}?v={{ CSS_JS_VER }}">
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
            <span class="icon inbox-menu mr-2"></span> Manage Ads
          </div>
        </div>
        @include('front.account.account_layout.left_menu')
        <div class="inbox-right wishlist">
          <h3 class="create-listing-title d-flex align-items-center d-none d-lg-flex">
            <span class="icon manage-ads"></span> Manage Ads
          </h3>
          <div class="scrollable-table">
            <table class="table orange-table">
              <thead>
                <tr>
                  <th>Ads ID</th>
                  <th>Title</th>
                  <th>Ad created date</th>
                  <!-- <th>Ad edited ad</th> -->
                  <th>Ad status</th>
                  <th class="table-actions confirm-decline-edit">&nbsp;</th>
                </tr>
              </thead>
              <tbody>
                <tr class="gap">
                  <td colspan="5"></td>
                </tr>
                @foreach($user_ads as $key => $ad)
                  @php
                    $listing_image = $ad->images()->first();
                  @endphp
                  <tr>
                    <td>
                      <span class="text-red">#{{$ad->id}}</span>
                    </td>
                    <td>{{$ad->title}}</td>
                    <td>{{date('d M Y', strtotime($ad->created_at)) }}</td>
                    <!-- <td>{{date('d M Y', strtotime($ad->updated_at)) }}</td> -->
                    <td>
                      @if($ad->is_approved == '')
                        Pending
                      @elseif($ad->is_approved == '1')
                        Approved
                      @elseif($ad->is_approved == '0')
                        Declined
                      @endif
                    </td>
                    <td class="table-actions confirm-decline-edit">
                      <div class="d-flex align-items-center justify-content-between flex-row">
                        <a href="{{url('view-listing')}}{{'/'}}{{$ad->slug}}{{'/'}}{{$ad->identification_code}}"><span class="icon ads-view"></span></a>
                        @if($ad->is_blocked == 0)
                          @if($ad->is_approved == null)
                            <a href="{{url('edit-listing')}}{{'/'}}{{$ad->slug}}{{'/'}}{{$ad->identification_code}}"><span class="icon ads-pencil"></span></a> 
                          @endif
                          @if($ad->is_approved == '1')
                          <label class="switch">
                            <input type="checkbox" class="user_listing_status" data-id="{{$ad->id}}" {{ $ad->is_active == 1 ? 'checked' : ''}}>
                            <span class="slider round"></span>
                          </label>
                          @endif
                        @endif
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="2" class="align-middle">             
                    Showing {{ $user_ads->firstItem() }} to {{ $user_ads->lastItem() }} of total {{$user_ads->total()}} items
                  </td>
                  <td colspan="5">
                    <div class="pagination justify-content-end">
                      {!! $user_ads->links() !!}
                    </div>
                  </td>
                </tr>
              </tfoot>              
            </table>
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
  <script type="text/javascript" src="{{ asset('frontend/js/sweetalert.min.js') }}?v={{ CSS_JS_VER }}"></script>
  <script type="text/javascript" src="{{ asset('frontend/js/custom.min.js') }}?v={{ CSS_JS_VER }}"></script>
@endsection
@push('custom-scripts')
  <script type="text/javascript" src="{{ asset('/frontend/custom_js_css/js/ads_listing.js') }}?v={{CSS_JS_VER}}"></script>
@endpush
