@extends('admin.layouts.master')
@section('pagetitle', 'Contact Enquiries')
@section('content')
      <div class="main-content">
        <section>
          <div class="d-flex align-items-center justify-content-between">
            <h2 class="page-title">Inbox</h2>
          </div>
          @if(Session::has('message'))
            <div class="alert alert-info">
              {{Session::get('message')}}
            </div>     
          @endif
          <table class="table listing-table inbox mt-4">
            <thead>
              <tr>
                <th width="15%">From</th>
                <th width="15%">Email</th>
                <th width="50%" style="word-break: break-all;">Message</th>
                <th width="15%">Received on</th>
                <th class="table-actions">Action</th>
              </tr>
            </thead>
            <tbody>
            @foreach($enquiryLst as $eObj)
              <tr>
                <td>
                  <div class="d-flex text-nowrap">                   
                    {{$eObj->name}}
                  </div>
                </td>
                <td class="text-nowrap">{{$eObj->email}}</td>
                <td style="word-break: break-all;">
                @php
                  $len = strlen($eObj->message);
                  $dispLen = 0;
                  $othChar = "";
                  if($len < 25) {
                    $dispLen = $len;
                  } else {
                    $dispLen = 25;
                    $othChar = "...";
                  }
                @endphp
                
                {{substr($eObj->message, 0, intval($dispLen)) . " " . $othChar}}
                </td>
                <td><span class="text-light">{{date('d M Y', strtotime($eObj->created_at)) }}</span></td>
                <td class="table-actions">
                  <div class="d-flex justify-content-between align-items-center">
                  @if($eObj->is_active)
                      <a href="{{ url('admin/contact-enquiry-detail').'/'.$eObj->id }}">
                        <span class="icon view"></span>
                      </a>
                  @endif
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </section>
      </div>
@endsection