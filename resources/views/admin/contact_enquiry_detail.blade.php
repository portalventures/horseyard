@extends('admin.layouts.master')
@section('pagetitle', 'Contact Enquiries')
@section('content')
      <div class="main-content">
      <section>
          <div class="d-flex align-items-center justify-content-between">
            <h2 class="page-title">Original Message From</h2>
          </div>

          <div class="card">
            <div class="card-content">
                <div class="mb-3 row align-items-start justify-content-between">
                  <label for="" class="col-12 col-md-3 text-right mt-2">Name:</label>
                  <div class="col col-md-4 mr-auto">
                    <input type="text" readonly value="{{ $enqObj->name }}" class="form-control">
                  </div>
                </div>
                <div class="mb-3 row align-items-start justify-content-between">
                  <label for="" class="col-12 col-md-3 text-right mt-2">Email:</label>
                  <div class="col col-md-4 mr-auto">
                    <input type="text" readonly value="{{ $enqObj->email }}" class="form-control">
                  </div>
                </div>
                <div class="mb-3 row align-items-start justify-content-between">
                  <label for="" class="col-12 col-md-3 text-right mt-2">Phone:</label>
                  <div class="col col-md-4 mr-auto">
                    <input type="text" readonly value="{{ $enqObj->phone }}" class="form-control">
                  </div>
                </div>
                <div class="mb-3 row align-items-start justify-content-between">
                  <label for="" class="col-12 col-md-3 text-right mt-2">Company:</label>
                  <div class="col col-md-4 mr-auto">
                    <input type="text" readonly value="{{ $enqObj->company }}" class="form-control">
                  </div>
                </div>
                <div class="mb-3 row align-items-start justify-content-between">
                  <label for="" class="col-12 col-md-3 text-right mt-2">Message Received Date:</label>
                  <div class="col col-md-4 mr-auto">
                    <input type="text" readonly value="{{ date('d M Y', strtotime($enqObj->created_at)) }}" class="form-control">
                  </div>
                </div>
                <div class="mb-3 row align-items-start justify-content-between">
                  <label for="" class="col-12 col-md-3 text-right mt-2">Message:</label>
                  <div class="col col-md-8 mr-auto">
                    <div readonly class="form-control textarea-message">{{ $enqObj->message }}</div>
                  </div>
                </div>
            </div>
          </div>
        </section>

        @if(empty($respObj))
        <section>
          <div class="d-flex align-items-center justify-content-between">
            <h2 class="page-title">Reply</h2>
          </div>
          <div class="card">
            <div class="card-content">
              <form action="{{ url('admin/send-enquiry-response')}}" method="POST" enctype="multipart/form-data" class="user_update_form">
                @csrf
                <div class="form-group row align-items-start justify-content-between">
                  <label for="" class="col-12 col-md-2 text-right m-0 mt-2">To<span class="text-orange">*</span></label>
                  <div class="col mr-auto">
                    <input type="text" class="form-control" placeholder="Email Address" value="{{ $enqObj->email }}" disabled>
                  </div>
                </div>
                <div class="form-group row align-items-start justify-content-between">
                  <label for="" class="col-12 col-md-2 text-right m-0 mt-2">Subject<span class="text-orange">*</span></label>
                  <div class="col mr-auto">
                    <input type="text" class="form-control" placeholder="Subject" value="Response to your email...">
                  </div>
                </div>
                <div class="form-group row align-items-start justify-content-between">
                  <label for="" class="col-12 col-md-2 text-right m-0 mt-2">Message <span class="text-orange">*</span></label>
                  <div class="col w-100">
                  <textarea name="response_text" id="response_text" cols="50" rows="10" placeholder="Start here..." class="w-100 form-control"></textarea>
                  </div>
                </div>
                <div class="form-group row align-items-start justify-content-between">
                  <div class="col-12 col-md-2"></div>
                  <div class="col col-md-4 mr-auto d-flex align-items-center">
                  <input type="hidden" id="idfield" name="idfield" value="{{ $enqObj->id }}">
                    <button type="submit" class="btn btn-primary">Send</button>
                    <a href="{{ url('admin/contact-enquiries') }}" class="text-link ml-4">Cancel</a>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </section>
        @else
        <section>
          <div class="d-flex align-items-center justify-content-between">
            <h2 class="page-title">Response Text</h2>
          </div>
          <div class="card">
            <div class="card-content">
              <table width="100%">
                <tr>
                  <td>
              Response Date : {{ date('d M Y', strtotime($respObj->created_at)) }}
              </td></tr>
              </table>
            </div>
          <div class="card">
            <div class="card-content">
            {{ $respObj->message }}
            </div>
          </div>
        </section>
        @endif
      </div>
@endsection