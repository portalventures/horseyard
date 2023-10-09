@extends('admin.layouts.master')
@section('pagetitle', 'Manage Users')
@section('content')
<div class="main-content">
<section>
    <div class="d-flex align-items-center justify-content-between">
       <h2 class="page-title">All users</h2>
       <a href="{{ url('admin/add_users')}}" class="btn btn-primary">Add new user</a>
    </div><br/>
    @if(session()->has('message'))
      <div class="alert alert-success">
          {{ session()->get('message') }}
      </div>
    @endif
    <table class="table listing-table mt-4">
        <thead>
          <tr>
            <th >Name</th>
            <th>Email</th>
            <th class="created-date">Registered on</th>
            <th class="text-center">Action</th>            
          </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{$user->getFullName()}}</td>
                <td>{{$user->email}}</td>
                <td>{{date('d/M/Y', strtotime($user->created_at)) }}</td>
                <td class="table-actions confirm-decline-edit">
                  <div class="d-flex align-items-center justify-content-between flex-row">
                    <a href="{{url('admin/edit_user')}}{{'/'}}{{$user->id}}{{'/'}}{{$user->token}}" class="edit-listing" data-toggle="tooltip" data-placement="top" title="Edit"><span class="icon ads-pencil size-24"></span></a>

                    <a href="javascript:void(0);" class="delete_user_by_admin" data-id="{{$user->token}}"><span class="icon red-trash" data-toggle="tooltip" data-placement="top" title="Delete"></span></a>

                    <a href="javascript:void(0);" class="user_status_change" data-id="{{$user->id}}" data-msg="Block" data-toggle="tooltip" data-placement="top" title="Block"><span class="icon blocked"></span></a>
                  </div>
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
@endsection

@push('custom-scripts')
<script type="text/javascript" src="{{ asset('/admin/custom_js_css/js/user.js') }}?v={{CSS_JS_VER}}"></script>
@endpush
