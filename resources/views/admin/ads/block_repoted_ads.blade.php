@extends('admin.layouts.master')
@section('pagetitle', 'Manage Ads')
@section('content')
  <div class="main-content">
    <section>
      <div class="d-flex align-items-center justify-content-between">
        <h2 class="page-title">
          @if($current_page == 'blocked_ads')
            Blocked Ads
          @endif
          @if($current_page == 'reported_ads')
            Reported Ads
          @endif
        </h2>
        <form action="{{ url('admin/ads')}}{{'/'}}{{$ad_status_type}}" method="get" class="search-form">
          <div class="form-group d-flex flex-nowrap">
            <input class="form-control flex-grow-1 h-auto" name="search" placeholder="Search" type="text" value="{{ !empty($search_key_word) ? $search_key_word : ''}}">
            <button class="btn btn-secondary p-3 d-flex align-items-center justify-content-center" type="submit">
              <span class="icon search-white"></span></button>
          </div>
        </form>        
      </div>
      <table class="table listing-table mt-4">
        <thead>
          <tr>
            <th class="table-image">Image</th>
            <th>Title</th>
            <th>Category</th>
            <th>Price</th>
            @if($current_page == 'reported_ads')
            <th class="text-center">Report Count </th>
            @endif
            <th class="text-center">Action</th>
            @if($current_page == 'blocked_ads')
            <th></th>
            @endif
          </tr>
        </thead>
        <tbody>
          @foreach($block_repoted_ads as $key => $ad)
            @php
              $listing_image = get_listing_first_image($ad->listing_id);
            @endphp
            <tr>
              <td class="table-image">
                @if(!empty($listing_image))
                  <img src="{{ url($listing_image->image_url.'/'.$listing_image->image_name) }}" alt="Featured listing" class="img-fluid" />
                @else
                  <img src="{{ asset('admin/images/featured-table.png') }}" alt="Featured listing" class="img-fluid" />
                @endif
              </td>
              <td>{{$ad->listing_title}}</td>              
              <td>{{get_to_category_name($ad->listing_category_id)}}</td>
              @if($ad->item_show_type == 'free')
                <td>Free</td>
              @else
                <td >${{$ad->listing_price}} {{substr($ad->item_show_type,0,3)}}</td>
              @endif              
              @if($current_page == 'reported_ads')
                <td class="text-center">{{get_listing_report_count($ad->listing_id)}}</td>
              @endif
              <td class="table-actions confirm-decline-edit">
                <div class="d-flex align-items-center justify-content-center">
                  <a href="javascript:void(0);" class="delete_ad_by_admin" data-id="{{$ad->listing_identification_code}}" data-toggle="tooltip" data-placement="top" title="Delete" data-swalText="Are you sure you want to delete?" dataSwalTitle="Delete ad"><span class="icon red-trash mx-2"></span></a>
                  @if($ad->is_active == 1 && $current_page == 'reported_ads')
                    <a href="javascript:void(0);" class="listing_status" data-id="{{$ad->listing_id}}" data-msg="Block" data-toggle="tooltip" data-placement="top" title="Block" data-swalText="Are you sure you want to block?" dataSwalTitle="Block ad"><span class="icon blocked mx-2"></span></a>
                  @endif
                  @if($current_page == 'reported_ads')
                  <a href="{{ url('admin/ad') }}/{{'report'}}/{{'details'}}/{{$ad->listing_identification_code}}"  data-toggle="tooltip" data-placement="top" title="View">
                    <span class="icon ads-eye mr-auto ml-auto mx-2"></span>
                  </a>
                  @endif
                </div>
              </td>
              @if($current_page == 'blocked_ads')
              <td class="text-right">
                <a href="javascript:void(0)" class="btn btn-primary listing_status" data-id="{{$ad->listing_id}}" data-msg="Unblock" data-swalText="Are you sure you want to unblock?" dataSwalTitle="Unblock ad">Unblock</a>
              </td>
              @endif
            </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <td colspan="2" class="align-middle">
              Showing {{ $block_repoted_ads->firstItem() }} to {{ $block_repoted_ads->lastItem() }} of total {{$block_repoted_ads->total()}} items
            </td>
            <td colspan="5">
              <div class="pagination justify-content-end">
                {!! $block_repoted_ads->links() !!}
              </div>
            </td>
          </tr>
        </tfoot>
      </table>
    </section>
  </div>
@endsection

@push('custom-scripts')
    <script type="text/javascript" src="{{ asset('/admin/custom_js_css/js/ad.js') }}?v={{ CSS_JS_VER }}"></script>
@endpush
