@extends('admin.layouts.master')


@section('content')
  <div class="main-content">
    <section>
      <div class="grid grid-gap-30 grid-col-auto-3">
        <div class="dashboard-map w-100">
          <div class="grid grid-gap-30 grid-col-2">
            <div class="card mt-0 mb-3 d-flex">
              <div class="card-content" mb-auto>
                <div class="d-flex align-items-center justify-content-between">
                  <h3 class="report-count">
                    {{ $listingMetaData->cntActiveAds }}
                    <span>Active Ads</span>
                  </h3>
                  <span class="icon complete size-38 rounded-circle"></span>
                </div>
              </div>
            </div>
            <div class="card mt-0 mb-3 d-flex">
              <div class="card-content mb-auto">
                <div class="d-flex align-items-center justify-content-between">
                  <h3 class="report-count">
                  {{ $listingMetaData->cntPendingAds }}
                    <span>Pending Ads</span>
                  </h3>
                  <span class="icon pending yellow size-38 rounded-circle"></span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="dashboard-charts w-100">
          <div class="grid grid-gap-30 grid-col-2">
            <div class="card mt-0 mb-3 d-flex">
              <div class="card-content mb-auto">
                <div class="d-flex align-items-center justify-content-between">
                  <h3 class="report-count">
                  {{ $listingMetaData->cntBlockedAds }}
                    <span>Blocked Ads</span>
                  </h3>
                  <span class="icon blocked size-38 rounded-circle"></span>
                </div>
              </div>
            </div>
            <div class="card mt-0 mb-3 d-flex">
              <div class="card-content mb-auto">
                <div class="d-flex align-items-center justify-content-between">
                  <h3 class="report-count">
                  {{admin_get_reported_ads_count()}}
                    <span>Reported Ads</span>
                  </h3>
                  <span class="icon reported size-38 rounded-circle"></span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="w-100">
          <div class="grid grid-gap-30 h-100">
          <div class="card mt-0 mb-3 d-flex">
              <div class="card-content mb-auto">
                <div class="d-flex align-items-center justify-content-between">
                  <h3 class="report-count">
                  {{ $listingMetaData->cntTotalUsers }}
                  <span>Total Users</span>
                </h3>
                <span class="icon total-users size-38 rounded-circle"></span>
              </div>
            </div>
          </div>
          </div>
        </div>
      </div>
      
      <div class="row mt-5 flex-nowrap">
        <div class="col-12">
          <div class="d-flex align-items-center justify-content-between">
            <h2 class="page-title">Most Visited Ads</h2>
          </div>
          <table class="table listing-table mt-4 td-align-middle">
            <thead>
              <tr>
                <th>Title</th>
                <th>Date Created</th>
                <th>Views</th>
              </tr>
            </thead>
            <tbody>
              @if(!empty($listingData))
                @foreach($listingData as $lObj)
                  <tr>
                    <td>
                      <div class="d-flex text-nowrap align-items-center">                      
                      @php
                      $len = strlen($lObj->listing->title);
                      $dispLen = 0;
                      $othChar = "";
                      if($len < 150)
                      {
                        $dispLen = $len;
                      }else
                      {
                        $dispLen = 150;
                        $othChar = "...";
                      }
                      @endphp

                      {{substr($lObj->listing->title, 0, intval($dispLen)) . " " . $othChar}}
                      </div>
                    </td>                    
                    <td class="align-middle">
                      {{ !empty($lObj->listing->created_at) ? date('d M Y', strtotime($lObj->listing->created_at)) : '' }}
                    </td>
                    <td class="align-middle">{{ $lObj->cntMostViewed}}</td>
                  </tr>
                @endforeach
              @endif
            </tbody>
          </table>
        </div>
      </div>
      <div class="d-flex align-items-center justify-content-between mt-5">
        <h2 class="page-title">Inbox</h2>
      </div>
      <table class="table listing-table mt-4">
        <thead>
          <tr>
            <th>From</th>
            <th>Message</th>
            <th>Date</th>
            <th class="table-actions">&nbsp;</th>
          </tr>
        </thead>
        <tbody>
        @foreach($enquiryLst as $eObj)
          <tr>
            <td class="align-middle">
              <div class="d-flex text-nowrap">                
                {{$eObj->name}}
              </div>
            </td>
            <td class="align-middle">
              <p class="two-line-text" style="word-break: break-all;">
                @php
                  $len = strlen($eObj->message);
                  $dispLen = 0;
                  $othChar = "";
                  if($len < 150) {
                    $dispLen = $len;
                  } else {
                    $dispLen = 150;
                    $othChar = "...";
                  }
                @endphp
                {{substr($eObj->message, 0, intval($dispLen)) . " " . $othChar}}
              </p>
            </td>
            <td class="align-middle">
              <p class="text-grey text-nowrap">{{ !empty($eObj->created_at) ? date('d M Y', strtotime($eObj->created_at)) : '' }}</p>
            </td>
            <td class="table-actions align-middle">
              <div class="d-flex align-items-center justify-content-between">
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