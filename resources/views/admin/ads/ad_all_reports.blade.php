@extends('admin.layouts.master')
@section('pagetitle', 'Manage Ads')
@section('content')
  <div class="main-content">
    <section>
      <div class="d-flex align-items-center justify-content-between">
        <h2 class="page-title">Admin Ads</h2>
      </div>
      <table class="table listing-table mt-4">
        <thead>
          <tr>
            <th>Reason</th>
             <th>Reporter’s Name</th>
            <th>Reporter’s Email</th>
            <th>Message</th>
            <th>Reported On</th>
          </tr>
        </thead>
        <tbody>
          @foreach($all_reports as $key => $report)
            <tr>
              <td>{{$report->reason}}</td>
              <td>{{$report->name}}</td>
              <td>{{$report->email}}</td>
              <td>{{$report->message}}</td>
              <td>{{date('d M Y', strtotime($report->created_at)) }}</td>
              <td>
            </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <td colspan="2" class="align-middle">
              Showing {{ $all_reports->firstItem() }} to {{ $all_reports->lastItem() }} of total {{$all_reports->total()}} items
            </td>
            <td colspan="5">
              <div class="pagination justify-content-end">
                {!! $all_reports->links() !!}
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
