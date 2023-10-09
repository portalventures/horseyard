@extends('front.layouts.master')
@section('title', 'Submit a Listing - Horseyard')
@section('canonical-content')
  <link rel="canonical" href="{{URL::current()}}"/>
@endsection
@section('css-content')
  <link rel="stylesheet" type="text/css" href="{{ asset('/frontend/css/sweetalert.min.css') }}?v={{ CSS_JS_VER }}">  
  <link rel="stylesheet" href="{{ asset('/frontend/css/custom.min.css') }}?v={{ CSS_JS_VER }}">  
  <link rel="stylesheet" href="{{ asset('/frontend/custom_js_css/css/custom.css') }}?v={{ CSS_JS_VER }}"> 
@endsection

@section('content')
  <div id="main">
    <section id="inbox" class="onlyRight">
      <div class="container">
        @include('front.account.account_layout.left_menu')
        <div class="inbox-right">
          <h3 class="create-listing-title d-flex align-items-center">
            <span class="icon create-listing"></span> Create Listing
          </h3>
          <form action="" class="user_create_ad_form">
            @csrf
            <div id="wizard">
              @if($category_type == '')
                <div class="wizard-step active">
                  <div class="card">
                    <div class="step-heading">
                      <h3><span class="text-red">Step 1</span> Of 4 <span class="title">Category: <span class="selected-category">Horses</span></span>
                      </h3>
                    </div>
                    <div class="step-body">
                      <div class="step-content">
                        <div class="form-group">
                          <div class="row">
                            <div class="col flex-grow-0">
                              <label for="" class="m-0 text-nowrap">Listing Category<span class="text-red">*</span></label>
                            </div>
                            <div class="col pl-md-0">
                              <div class="d-flex flex-column">
                                @foreach($all_top_categories as $key => $top_categories)
                                  <label for="cat-{{$top_categories->category_name}}" class="custom-radio all_top_categories">
                                    <input type="radio" name="listing_category" value="{{$top_categories->id}}" {{ $key == 0 ? 'checked' : '' }}  id="cat-{{$top_categories->category_name}}" data-id="{{strtolower($top_categories->category_name)}}">
                                    <span></span>
                                    {{$top_categories->category_name}}
                                  </label>
                                @endforeach
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="step-content border-0 p-0">
                        <div class="d-flex justify-content-end align-items-center mt-4 mb-3">
                          <button class="btn btn-secondary prevWizardStep" type="button">Prev</button>
                          <button class="btn btn-primary nextWizardStep" type="button">Next</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              @endif
              <div class="wizard-step {{ $category_type != '' ? 'active' : '' }}">
                <div class="card">
                  <div class="step-heading">
                    <h3><span class="text-red">Step 2</span> Of 4 <span class="title">Ad details</span>
                    </h3>
                  </div>
                  <div class="step-body adDetailsStep">
                    @if($category_type != '')
                      <input type="hidden" name="listing_category" value="{{$category_id}}">
                    @endif
                    <div class="step-content">
                      <div class="form-group">
                        <div class="row">
                          <div class="col col-md-2 pr-md-0">
                            <label for="" class="mb-md-0 mt-md-2 float-md-right text-md-right">Price<span class="text-red">*</span></label>
                          </div>
                          <div class="col col-md-4 mb-3 mb-md-0">
                            <div class="d-flex flex-column">
                              <input type="text" class="form-control check-validity item_price" placeholder="Enter Price" required name="price" id="price" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                              <span class="text-orange field-info">Enter price in numbers only (eg. 100 or 1000 or 10000)<br>Do not use full stops or commas (eg. 1,000 or 100.00)</span>
                              <span class="errorMessage"></span>
                            </div>
                          </div>
                          <div class="col col-md-6 pl-md-5 item_type_radio">
                            <div class="d-flex mt-2 flex-column flex-md-row">
                              <label for="" class="mb-md-0 mr-3">Item show type</label>
                              <div class="d-flex flex-column flex-md-row">
                                <label for="item-free" class="custom-radio mr-3 mb-0">
                                  <input type="radio" name="item_show_type" id="item-free" class="item_type" value="free">
                                  <span></span>
                                  Free
                                </label>
                                <label for="item-negotiable" class="custom-radio mr-3 mb-0">
                                  <input type="radio" name="item_show_type" id="item-negotiable" class="item_type" value="negotiable">
                                  <span></span>
                                  Negotiable
                                </label>
                                <label for="item-ono" class="custom-radio mr-3 mb-0">
                                  <input type="radio" name="item_show_type" id="item-ono" class="item_type" value="ONO">
                                  <span></span>
                                  ONO
                                </label>
                              </div>
                            </div>
                            <span class="errorMessage"></span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="step-content">
                      <div class="form-group">
                        <div class="row">
                          <div class="col col-md-2 pr-md-0">
                            <label for="" class="mb-md-0 mt-md-2 float-md-right text-md-right">State<span class="text-red">*</span></label>
                          </div>
                          <div class="col col-md-4 mb-3 mb-md-0">
                            <div class="selectParent">
                              <select name="state" id="state" class="form-control check-validity state_list" required>
                                <option value="" selected>Select</option>
                                @foreach($all_state as $key => $value)
                                  <option value="{{$value->id}}">{{$value->state_name}}</option>
                                @endforeach
                              </select>
                              <span class="errorMessage"></span>
                            </div>
                          </div>
                          <div class="col col-md-2 pr-md-0">
                            <label for="" class="mb-md-0 mt-md-2 float-md-right text-md-right">Suburb<span class="text-red">*</span></label>
                          </div>
                          <div class="col col-md-4 mb-3 mb-md-0">
                            <div class="selectParent suburb_div">
                              <select name="suburb" id="suburb" class="form-control check-validity" required>
                                <option value="">Select</option>
                              </select>
                              <span class="errorMessage"></span>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col col-md-2 pr-md-0">
                            <label for="" class="mb-md-0 mt-md-2 float-md-right text-md-right">PIC</label>
                          </div>
                          <div class="col col-md-4 mb-3 mb-md-0">
                            <div class="d-flex flex-column">
                              <input type="text" placeholder="PIC Number" class="form-control" name="pic_number" id="pic_number">
                              <span class="text-orange field-info">Enter your PIC (Property Identification Code) here</span>
                              <span class="errorMessage"></span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="step-content">
                      <div class="form-group">
                        <div class="row">
                          <div class="col col-md-2 pr-md-0">
                            <label for="" class="mb-md-0 mt-md-2 float-md-right text-md-right">Title<span class="text-red">*</span></label>
                          </div>
                          <div class="col col-md-10 mb-3 mb-md-0">
                            <input type="text" placeholder="Title of Ad" class="form-control check-validity firstNoSpace" name="title" id="title" required>
                            <span class="errorMessage"></span>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col col-md-2 pr-md-0">
                            <label for="" class="mb-md-0 mt-md-2 float-md-right text-md-right">Description<span class="text-red">*</span></label>
                          </div>
                          <div class="col col-md-10">
                            <textarea name="description" id="description" cols="30" rows="5" placeholder="Description of Ad" class="form-control check-validity firstNoSpace" required></textarea>
                            <span class="errorMessage"></span>
                          </div>
                        </div>
                      </div>
                    </div>
                    @if($category_type == '')
                      <div class="categories_dynamic_data">
                      </div>
                    @else
                      @if($category_type == 'horses')
                        @include('front.account.ads.listingTypeHorses')
                      @endif
                      @if($category_type == 'transport')
                        @include('front.account.ads.listingTypeTransport')
                      @endif
                      @if($category_type == 'saddlery')
                        @include('front.account.ads.listingTypeSaddlery')
                      @endif
                      @if($category_type == 'property')
                        @include('front.account.ads.listingTypeProperty')
                      @endif
                    @endif
                    <div class="step-content border-0 p-0">
                      <div class="d-flex justify-content-end align-items-center mt-4 mb-3">
                        @if($category_type == '')
                          <button class="btn btn-secondary prevWizardStep" type="button">Prev</button>
                        @endif
                        <button class="btn btn-primary nextWizardStep" type="button">Next</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="wizard-step">
                <div class="card">
                  <div class="step-heading">
                    <h3><span class="text-red">Step 3</span> Of 4 <span class="title">Images & Videos</span>
                    </h3>
                  </div>
                  <div class="step-body">
                    <div class="step-content">
                      <h2 class="card-title">Images<span class="text-red">*</span></h2>
                      <div class="dropzone">
                        <div id="list"></div>
                        <div class="dropzone-text">
                          <h2 class="card-title">Drop files here or click to upload.</h2>
                          <span class="text-orange field-info">
                          Files must be less than <strong>20 MB</strong><br>Allowed file types: <strong>.png .gif .jpg .jpeg</strong><br>Recommended image size: <strong>800x600 px</strong>
                        </span>
                        </div>
                        <input type="file" id="postAdImages" name="ads_images[]" class="ads_images check-validity" multiple>
                      </div>
                    </div>
                    <div class="step-content">
                      <h2 class="card-title">Youtube URL</h2>
                      <div class="form-group">
                        <div class="row">
                          <div class="col col-md-2 pr-md-0">
                            <label for="" class="mb-md-0 mt-md-2 float-md-right text-md-right">Youtube URL</label>
                          </div>
                          <div class="col col-md-4 mb-3 mb-md-0">
                            <div class="d-flex flex-column flex-md-row">
                              <div class="field-with-icon right w-100">
                                <input type="text" placeholder="Enter URL" class="form-control" name="video_url" id="video_url">
                                <span class="icon social youtube"></span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="step-content border-0 p-0">
                      <div class="d-flex justify-content-end align-items-center mt-4 mb-3">
                        <button class="btn btn-secondary prevWizardStep" type="button">Prev</button>
                        <button class="btn btn-primary nextWizardStep" type="button">Next</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="wizard-step">
                <div class="card">
                  <div class="step-heading">
                    <h3><span class="text-red">Step 4</span> Of 4 <span class="title">Contact Details</span>
                    </h3>
                  </div>
                  <div class="step-body">
                    <div class="step-content">
                      <div class="form-group">
                        <div class="row">
                          <div class="col col-md-2 pr-md-0">
                            <label for="" class="mb-md-0 mt-md-2 float-md-right text-md-right">Name<span class="text-red">*</span></label>
                          </div>
                          <div class="col col-md-4 mb-3 mb-md-0">
                            <div class="d-flex flex-column">
                              <input type="text" placeholder="Name" name="contact_name" id="contact_name" class="form-control check-validity firstNoSpace" required>
                              <span class="errorMessage"></span>
                            </div>
                          </div>
                          <div class="col col-md-2 pr-md-0">
                            <label for="" class="mb-md-0 mt-md-2 float-md-right text-md-right">Mobile number<span class="text-red">*</span></label>
                          </div>
                          <div class="col col-md-4 mb-3 mb-md-0">
                            <div class="d-flex flex-column">
                              <input type="text" placeholder="Enter Mobile Number" name="contact_number" id="contact_number" class="form-control check-validity firstNoSpace" required>
                              <span class="errorMessage"></span>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col col-md-2 pr-md-0">
                            <label for="" class="mb-md-0 mt-md-2 float-md-right text-md-right">Email<span class="text-red">*</span></label>
                          </div>
                          <div class="col col-md-4 mb-3 mb-md-0">
                            <div class="d-flex flex-column">
                              <input type="email" placeholder="Enter Email Address" name="contact_email" id="contact_email" class="form-control check-validity firstNoSpace" required>
                              <span class="errorMessage"></span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="step-content border-0 p-0">
                      <div class="d-flex justify-content-end align-items-center mt-4 mb-3">
                        <button class="btn btn-secondary prevWizardStep" type="button">Prev</button>
                        <button class="btn btn-primary ml-2" type="submit">Save</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </section>
  </div>
@endsection
@section('js-content')
<script type="text/javascript" src="{{ asset('frontend/js/select2.min.js') }}?v={{ CSS_JS_VER }}"></script>
<script type="text/javascript" src="{{ asset('frontend/js/jquery-ui.min.js') }}?v={{ CSS_JS_VER }}"></script>
<script type="text/javascript" src="{{ asset('frontend/js/jquery.validate.min.js') }}?v={{ CSS_JS_VER }}"></script>
<script type="text/javascript" src="{{ asset('frontend/js/additional-methods.min.js') }}?v={{ CSS_JS_VER }}"></script>
<script type="text/javascript" src="{{ asset('frontend/js/sweetalert.min.js') }}?v={{ CSS_JS_VER }}"></script>
<script type="text/javascript" src="{{ asset('frontend/js/custom.min.js') }}?v={{ CSS_JS_VER }}"></script>
@endsection
@push('custom-scripts')
  <script type="text/javascript" src="{{ asset('/frontend/custom_js_css/js/ads_listing.js') }}?v={{CSS_JS_VER}}"></script>
@endpush
