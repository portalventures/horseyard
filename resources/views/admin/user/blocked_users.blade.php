@extends('admin.layouts.master')
@section('pagetitle', 'Manage Users')
@section('content')
<div class="main-content">
  <section>
    <div class="d-flex align-items-center justify-content-between">
      <h2 class="page-title">Blocked users</h2>
    </div>
    <table class="table listing-table mt-4">
        <thead>
          <tr>
            <th width="">Name</th>
            <th width="">Email</th>
            <th width="" class="created-date">Registered on</th>
            <th width="" class="text-center">Action</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{$user->getFullName()}}</td>
                <td>{{$user->email}}</td>
                <td>{{date('d/M/Y', strtotime($user->created_at)) }}</td>
               <!--  <td class="text-center">
                    <div class="d-flex align-items-center justify-content-between flex-row">
                        <label class="switch">
                            <input type="checkbox" class="user_status_change" data-id="{{$user->id}}" {{ $user->is_active == 1 ? 'checked' : ''}}>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </td> -->
                <td class="table-actions">
                    <div class="d-flex align-items-center justify-content-between flex-row">
                        <a href="{{url('admin/edit_user')}}{{'/'}}{{$user->id}}{{'/'}}{{$user->token}}" class="edit-listing"><span class="icon ads-pencil size-24"></span></a>                    
                        <a href="javascript:void(0);" class="delete_user_by_admin" data-id="{{$user->token}}"><span class="icon red-trash"></span></a>
                    </div>
                </td> 
                <td class="">
                  <a href="javascript:void(0)" class="btn btn-primary user_status_change" data-id="{{$user->id}}" data-msg="Unblock">Unblock</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <tfoot>
        <tr>
          <td colspan="1" class="align-middle showing-items">
            Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of total {{$users->total()}} items
          </td>
          <td colspan="4">
            <div class="pagination justify-content-end">
                {!! $users->links() !!}
            </div>
          </td>
        </tr>
    </tfoot>
  </section>
</div>
  <!-- Modal -->
@endsection
@push('custom-scripts')
<script type="text/javascript" src="{{ asset('/admin/custom_js_css/js/user.js') }}?v={{CSS_JS_VER}}"></script>
@endpush