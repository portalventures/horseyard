@extends('admin.layouts.master')
@section('pagetitle', 'Manage Ads')
@section('content')
  <div class="main-content">
    <section>
      <div class="d-flex align-items-center justify-content-between">
        <h2 class="page-title text-transform-none">Create an Ad</h2>
      </div>
      <div class="card mb-0">
        <div class="card-content">
          <form class="admin_create_ad_form">
            @csrf
            <ul class="stepper linear" id="linearStepper">
              <li class="step active">
                <div class="step-title waves-effect">Category</div>
                <div class="step-content">
                  <div class="form-group d-flex">
                    <label for="" class="mr-3 mb-0">Listing Category<span class="text-orange">*</span></label>
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
                  <div class="step-actions">
                    <button class="btn btn-primary next-step" type="button">Next</button>
                  </div>
                </div>
              </li>
              <li class="step">
                <div class="step-title waves-effect">Advertisement details</div>
                <div class="step-content adDetailsStep">

                  <div class="card-type">
                    <div class="row">
                      <div class="col col-md-2 pr-0">
                        <label for="" class="mb-0 mt-2 float-right">Price<span class="text-orange">*</span></label>
                      </div>
                      <div class="col col-md-4">
                        <div class="d-flex flex-column">
                          <input type="text" class="form-control checkvalidity item_price" placeholder="Enter Price" required name="price" id="price" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                          <span class="text-orange field-info">Enter price in numbers only (eg. 100 or 1000 or 10000)<br>Do not use full stops or commas (eg. 1,000 or 100.00)</span>
                          <span class="errorMessage"></span>
                        </div>
                      </div>
                      <div class="col col-md-6 pl-5 item_type_radio">
                        <div class="d-flex mt-2">
                          <label for="" class="mb-0 mr-3">Item show type</label>
                          <div class="d-flex ">
                            <label for="item-free" class="custom-radio mr-3 mb-0">
                              <input type="radio" name="item_show_type" id="item-free" value="free" class="item_type checkvalidity">
                              <span></span>
                              Free
                            </label>
                            <label for="item-negotiable" class="custom-radio mr-3 mb-0">
                              <input type="radio" name="item_show_type" id="item-negotiable" value="negotiable" class="item_type checkvalidity">
                              <span></span>
                              Negotiable
                            </label>
                            <label for="item-ono" class="custom-radio mr-3 mb-0">
                              <input type="radio" name="item_show_type" id="item-ono" value="ONO" class="item_type checkvalidity">
                              <span></span>
                              ONO
                            </label>
                          </div>
                        </div>
                        <span class="errorMessage"></span>
                      </div>
                    </div>
                  </div>
                  <div class="card-type">
                    <div class="form-group">
                      <div class="row">  
                        <input type="hidden" name="country" value="1" id="country">
                        <div class="col col-md-2 pr-0">
                          <label for="" class="mb-0 mt-2 float-right">State<span class="text-orange">*</span></label>
                        </div>
                        <div class="col col-md-4">
                          <select name="state" id="state" class="form-control checkvalidity state_list" required>
                            <option value="" selected>Select</option>
                            @foreach($all_state as $key => $value)
                              <option value="{{$value->id}}">{{$value->state_name}}</option>
                            @endforeach
                          </select>
                          <span class="errorMessage"></span>
                        </div>

                        <div class="col col-md-2 pr-0">
                          <label for="" class="mb-0 mt-2 float-right">Suburb<span class="text-orange">*</span></label>
                        </div>
                        <div class="col col-md-4 suburb_div">
                          <select name="suburb" id="suburb" class="form-control checkvalidity" required>
                            <option value="">Select</option>
                          </select>
                          <span class="errorMessage"></span>
                        </div>
                     
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col col-md-2 pr-0">
                          <label for="" class="mb-0 mt-2 float-right">PIC</label>
                        </div>
                        <div class="col col-md-4">
                          <div class="d-flex flex-column">
                            <input type="text" placeholder="PIC Number" class="form-control" name="pic_number" id="pic_number">
                            <span class="text-orange field-info">Enter your PIC (Property Identification Code) here</span>
                            <span class="errorMessage"></span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card-type">
                    <div class="form-group">
                      <div class="row">
                        <div class="col col-md-2 pr-0">
                          <label for="" class="mb-0 mt-2 float-right">Title<span class="text-orange">*</span></label>
                        </div>
                        <div class="col col-md-10">
                          <input type="text" placeholder="Title of Ad" class="form-control checkvalidity firstNoSpace" name="title" id="title" required>
                          <span class="errorMessage"></span>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col col-md-2 pr-0">
                          <label for="" class="mb-0 mt-2 float-right">Description<span class="text-orange">*</span></label>
                        </div>
                        <div class="col col-md-10">
                          <textarea name="description" id="description" cols="30" rows="5" placeholder="Description of Ad" class="form-control checkvalidity firstNoSpace" required></textarea>
                          <span class="errorMessage"></span>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="categories_dynamic_data">                 
                  </div>

                  <div class="step-actions">
                    <button class="btn btn-secondary previous-step" type="button">Prev</button>
                    <button class="btn btn-primary next-step" type="button">Next</button>
                  </div>
                </div>
              </li>
              <li class="step">
                <div class="step-title waves-effect">Images and video</div>
                <div class="step-content">
                  <div class="card-type">
                    <h2 class="card-title">Images</h2>
                    <div class="dropzone">
                      <div id="list"></div>
                      <div class="dropzone-text">
                        <h2 class="card-title">Drop files here or click to upload.</h2>
                        <span class="text-orange field-info">
                        Files must be less than <strong>20 MB</strong><br>Allowed file types: <strong>.png .gif .jpg .jpeg</strong><br>Recommended image size: <strong>800x600 px</strong>
                        </span>
                      </div>
                      <input type="file" id="postAdImages" name="ads_images[]" class="ads_images" multiple>
                    </div>
                  </div>
                  <div class="card-type">
                    <h2 class="card-title">Youtube Video</h2>
                    <div class="row">
                      <div class="col col-md-2 pr-0">
                        <label for="" class="mb-0 mt-2 float-right">Video URL</label>
                      </div>
                      <div class="col col-md-4">
                        <input type="text" placeholder="Enter URL" class="form-control" name="video_url" id="video_url">
                      </div>
                    </div>
                  </div>
                  <div class="step-actions">
                    <button class="btn btn-secondary previous-step" type="button">Prev</button>
                    <button class="btn btn-primary next-step" type="button">Next</button>
                  </div>
                </div>
              </li>
              <li class="step">
                <div class="step-title waves-effect">Contact details</div>
                <div class="step-content">
                  <div class="card-type">
                    <div class="form-group">
                      <div class="row">
                        <div class="col col-md-2 pr-0">
                          <label for="" class="mb-0 mt-2 float-right">Name<span class="text-orange">*</span></label>
                        </div>
                        <div class="col col-md-4">
                          <input type="text" placeholder="Name" name="contact_name" id="contact_name" class="form-control checkvalidity firstNoSpace" required>
                          <span class="errorMessage"></span>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col col-md-2 pr-0">
                          <label for="" class="mb-0 mt-2 float-right">Email<span class="text-orange">*</span></label>
                        </div>
                        <div class="col col-md-4">
                          <input type="email" placeholder="Enter Email Address" name="contact_email" id="contact_email" class="form-control checkvalidity firstNoSpace" required>
                          <span class="errorMessage"></span>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col col-md-2 pr-0">
                          <label for="" class="mb-0 mt-2 float-right">Mobile Number<span class="text-orange">*</span></label>
                        </div>
                        <div class="col col-md-4">
                          <input type="text" placeholder="Enter Mobile Number" name="contact_number" id="contact_number" class="form-control checkvalidity firstNoSpace" required>
                          <span class="errorMessage"></span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="step-actions">
                    <button class="btn btn-secondary previous-step" type="button">Prev</button>
                    <button class="btn btn-primary" type="submit">Submit</button>
                  </div>
                </div>
              </li>
            </ul>
          </form>
        </div>
      </div>
    </section>
  </div>
@endsection

@push('custom-scripts')
  <script type="text/javascript" src="{{ asset('/admin/custom_js_css/js/ad.js') }}?v={{CSS_JS_VER}}"></script>
@endpush
