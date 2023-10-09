@extends('admin.layouts.master')
@section('pagetitle', 'Manage Admin Users')
@section('content')
      <div class="main-content">
        <section>
          <div class="d-flex align-items-center justify-content-between">
            <h1 class="page-title">Administrators</h1>
            <a href="{{ url('admin/add-admin-user') }}" class="btn btn-primary">Add administrator</a>
          </div>
          <table class="table listing-table mt-4">
            <thead>
              <tr>
                <th width="25%">Name</th>
                <th width="50%">Email</th>
                <th class="created-date">Date Created</th>
                <th class="text-center">Active/Inactive</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
            @foreach($adminUser as $user)
              <tr>
                <td>{{$user->getFullName()}}</td>
                <td>{{$user->email}}</td>
                <td class="created-date">{{date('d M Y', strtotime($user->created_at)) }}</td>
                <td>
                <div class="onoffswitch4">
                  @if($user->id != Auth()->user()->id)
                    <label class="switch">
                        <input type="checkbox" class="user_status_change" data-id="{{$user->id}}" data-msg="" {{ $user->is_active == 1 ? 'checked' : ''}}>
                        <span class="slider round"></span>
                    </label>
                  @endif
                </div>
                </td>
                <td class="table-actions">
                  <div class="d-flex align-items-center justify-content-between">                  
                    <a href="{{ url('admin/edit-admin-user').'/'.$user->id.'/'.$user->token }}"><span class="icon ads-pencil size-24" data-toggle="tooltip" data-placement="top" title="Edit"></span></a>                  
                  </div>
                </td>
              </tr>
              @endforeach

            </tbody>
          </table>
        </section>
</div>

@endsection
@push('custom-scripts')
  <script type="text/javascript" src="{{ asset('/admin/custom_js_css/js/user.js') }}?v={{CSS_JS_VER}}"></script>
@endpush
