@extends('admin.layouts.master')
@section('pagetitle', 'Manage Ads')
@section('content')
  <div class="main-content">
    <section>
      <div class="d-flex align-items-center justify-content-between">
        <h2 class="page-title">
          @if($current_page == 'pending_ads')
            Pending Ads
          @endif
          @if($current_page == 'approved_ads')
            Approved Ads
          @endif
        </h2>
        <form action="{{ url('admin/ads/')}}{{'/'}}{{$ad_status_type}}" method="get" class="search-form">
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
            <th class="text-center">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($pending_approved_ads as $key => $ad)
            @php
              $listing_image = get_listing_first_image($ad->id);
            @endphp
            <tr>
              <td class="table-image">
                @if(!empty($listing_image))
                  <img src="{{ url($listing_image->image_url.'/'.$listing_image->image_name) }}" alt="Featured Image" class="img-fluid" />
                @else
                  <img src="{{ asset('noimage.jpg') }}" alt="No Image" class="img-fluid" />
                @endif
              </td>
              <td>{{$ad->title}}</td>
              <td>{{get_to_category_name($ad->category_id)}}</td>
              @if($ad->item_show_type == 'free')
                <td>Free</td>
              @else
                <td>${{$ad->price}} {{substr($ad->item_show_type,0,3)}}</td>
              @endif
              <td class="table-actions confirm-decline-edit">
                <div class="d-flex align-items-center justify-content-between">
                  <a href="{{url('admin/edit-ad')}}{{'/'}}{{$ad->slug}}{{'/'}}{{$ad->identification_code}}" class="#" data-toggle="tooltip" data-placement="top" title="Edit"><span class="icon ads-pencil size-24"></span></a>
                  @if($ad->is_approved == '1')
                    <a href="javascript:void(0);" class="delete_ad_by_admin" data-id="{{$ad->identification_code}}" data-toggle="tooltip" data-placement="top" title="Delete" data-swalText="Are you sure you want to delete?" dataSwalTitle="Delete ad"><span class="icon red-trash"></span></a>
                    <a href="javascript:void(0);" class="listing_status" data-id="{{$ad->id}}" data-msg="Block" data-swalText="Are you sure you want to block?" dataSwalTitle="Block ad"><span class="icon blocked" data-toggle="tooltip" data-placement="top" title="Block"></span></a>
                    <!-- <label class="switch">
                      <input type="checkbox" class="listing_status" data-id="{{$ad->id}}" {{ $ad->is_active == 1 ? 'checked' : ''}}>
                      <span class="slider round"></span>
                    </label> -->
                  @endif
                  @if($current_page == 'pending_ads')
                    @if($ad->is_approved == '')
                      <a href="javascript:void(0)" class="approved_status" data-id='{{ $ad->identification_code }}' data-status='approved' data-toggle="tooltip" data-placement="top" title="Approve"><span class="icon confirm"></span></a>
                      <a href="javascript:void(0)" class="approved_status" data-id='{{ $ad->identification_code }}' data-status='reject' data-toggle="tooltip" data-placement="top" title="Decline"><span class="icon decline"></span></a>
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
              Showing {{ $pending_approved_ads->firstItem() }} to {{ $pending_approved_ads->lastItem() }} of total {{$pending_approved_ads->total()}} items
            </td>
            <td colspan="5">
              <div class="pagination justify-content-end">
                {!! $pending_approved_ads->links() !!}
              </div>
            </td>
          </tr>
        </tfoot>
      </table>
    </section>
  </div>
@endsection

@push('custom-scripts')
  <script type="text/javascript" src="{{ asset('/admin/custom_js_css/js/ad.js') }}?v={{CSS_JS_VER}}"></script>
@endpush
