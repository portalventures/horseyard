@extends('admin.layouts.master')
@section('pagetitle', 'Manage Blogs')
@section('content')
  <div class="main-content">
    <section>
      <div class="d-flex align-items-center justify-content-between">
        <h2 class="page-title">All blogs</h2>
        <!-- <a href="{{ url('admin/create-blog') }}" class="btn btn-primary">Create new blog</a> -->
        <form action="{{ url('admin/all-blogs')}}" method="get" class="search-form">
            <div class="form-group d-flex flex-nowrap">
              <input class="form-control flex-grow-1 h-auto" name="search" placeholder="Search" type="text" value="{{ !empty($search_key_word) ? $search_key_word : ''}}">
              <button class="btn btn-secondary p-3 d-flex align-items-center justify-content-center" type="submit">
                <span class="icon search-white"></span></button>
            </div>
          </form>
      </div>
      <br/>
    @if(session()->has('blogsuccessmsg'))
      <div class="alert alert-success">
          {{ session()->get('blogsuccessmsg') }}
      </div>
    @endif
      <table class="table listing-table mt-4">
        <thead>
          <tr>
            <th>Title</th>
            <th>Type</th>
            <th class="created-date">Created Date</th>
            <th class="text-center">Active</th>
            <th class="text-center">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($blogs as $key => $blog)
          <tr>
            <td>{{ $blog->title }}</td>
            <td>{{ $blog->category_id }}</td>
            <td class="created-date">
              {{date('d M Y', strtotime($blog->created_at)) }}
            </td>
            <td class="text-center">              
            <div class="onoffswitch4">
              <label class="switch">
                <input type="checkbox" class="blog_status" data-id="{{$blog->id}}" {{ $blog->is_active == 1 ? 'checked' : ''}}>
                <span class="slider round"></span>
              </label>
            </div>
            </td>
            <td class="table-actions">
              <div class="d-flex align-items-center justify-content-between">
                @if($blog->is_active == 1)
                <a href="{{url('admin/edit-blog')}}{{'/'}}{{$blog->id}}{{'/'}}{{$blog->slug}}" class="edit-listing"><span class="icon ads-pencil size-24"></span></a>
                <a href="{{url('admin/delete-blog')}}{{'/'}}{{$blog->id}}" class="remove-listing"><span class="icon red-trash"></span></a>              
                @endif
              </div>
            </td>
          </tr>
          @endforeach()
        </tbody>
        <tfoot>          
          <tr>
            <td colspan="2" class="align-middle">             
              Showing {{ $blogs->firstItem() }} to {{ $blogs->lastItem() }} of total {{$blogs->total()}} items
            </td>
            <td colspan="5">
              <div class="pagination justify-content-end">
                {!! $blogs->links() !!}
              </div>
            </td>
          </tr>
        </tfoot>
      </table>
    </section>
  </div>
@endsection


@push('custom-scripts')
  <script type="text/javascript" src="{{ asset('/admin/custom_js_css/js/blog.js') }}?v={{CSS_JS_VER}}"></script>
@endpush
