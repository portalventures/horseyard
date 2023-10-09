@extends('admin.layouts.master')
@section('pagetitle', 'Manage breeds')
@section('content')
  <div class="main-content">
    <section>
      @include('shared.errors')
      <div class="d-flex align-items-center justify-content-between">
        <h2 class="page-title">All breeds</h2>
        @if($ExploreByHorse_count < 7)
          <a href="{{ url('admin/create-explore-breed') }}" class="btn btn-primary">Add new breed</a>
        @endif
      </div>      
      <table class="table listing-table mt-4">
        <thead>
          <tr>
            <th>Sr. No.</th>
            <th>Image</th>  
            <th>Breed</th>
            <th class="text-center">Active/Inactive</th>
            <th class="text-center">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($explore_horse as $key => $breed)
            <tr>
              <td>{{ $key+1 }}</td>
              <td>{{ $breed->brand_name }}</td>
              <td><img src="{{ url('explore_by_horse')}}{{'/'}}{{$breed->image}}" alt="News" width="150"></td>
              <td class="text-center">               
                <div class="onoffswitch4">                 
                  <label class="switch">
                    <input type="checkbox" class="breed_status" data-id="{{$breed->explore_by_horse_id}}" {{ $breed->is_active == 1 ? 'checked' : ''}}>
                    <span class="slider round"></span>
                  </label>
                </div>
              </td>
              <td class="text-center confirm-decline-edit">
                <div class="d-flex align-items-center justify-content-center">
                  <a href="{{url('admin/edit-explore-breed-status')}}/{{Str::slug($breed->brand_name,'-')}}/{{$breed->explore_by_horse_id}}" data-toggle="tooltip" data-placement="top" title="Edit">
                  <span class="icon ads-pencil size-24 mx-2"></span></a>
                </div>
              </td>
            </tr>
          @endforeach()
        </tbody>
      </table>
    </section>
  </div>
@endsection


@push('custom-scripts')
  <script type="text/javascript" src="{{ asset('/admin/custom_js_css/js/explore_by_horse.js') }}?v={{CSS_JS_VER}}"></script>
@endpush
