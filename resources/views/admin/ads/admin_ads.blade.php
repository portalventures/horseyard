@extends('admin.layouts.master')
@section('pagetitle', 'Manage Ads')
@section('content')
  <div class="main-content">    
    <section>
      <div class="d-flex align-items-center justify-content-between">
        <h2 class="page-title">Admin Ads</h2>
        <form action="{{ url('admin/ads')}}" method="get" class="search-form">
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
          @foreach($admin_ads as $key => $ad)
            @php
              $listing_image = $ad->images()->first();
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
                <div class="d-flex align-items-center justify-content-center">
                  <a href="javascript:void(0);" class="delete_ad_by_admin" data-id="{{$ad->identification_code}}" data-swalText="Are you sure you want to delete?" dataSwalTitle="Delete ad" data-toggle="tooltip" data-placement="top" title="Delete"><span class="icon red-trash mx-2"></span></a>
                  
                  <a href="{{url('admin/edit-ad')}}{{'/'}}{{$ad->slug}}{{'/'}}{{$ad->identification_code}}" class="#" data-toggle="tooltip" data-placement="top" title="Edit"><span class="icon ads-pencil size-24 mx-2"></span></a>

                  <a href="javascript:void(0);" class="listing_status" data-id="{{$ad->id}}" data-msg="Block" data-swalText="Are you sure you want to block?" dataSwalTitle="Block ad" data-toggle="tooltip" data-placement="top" title="Block"><span class="icon blocked mx-2"></span></a>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
        <tfoot>          
          <tr>
            <td colspan="2" class="align-middle">             
              Showing {{ $admin_ads->firstItem() }} to {{ $admin_ads->lastItem() }} of total {{$admin_ads->total()}} items
            </td>
            <td colspan="5">
              <div class="pagination justify-content-end">
                {!! $admin_ads->links() !!}
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
