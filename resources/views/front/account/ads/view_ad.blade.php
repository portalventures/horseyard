@extends('front.layouts.master')
@section('title', 'Horseyard | View Ad')
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
        <section id="inbox">
            <div class="container">
                <div class="d-block d-lg-none inbox-menu mb-3">
                    <div class="d-flex align-items-center">
                        <span class="icon inbox-menu mr-2"></span> Manage Ads
                    </div>
                </div>
                @include('front.account.account_layout.left_menu')
                <div class="inbox-right ads-view">
                    <div class="d-none d-lg-flex align-items-center justify-content-between">
                        <h3 class="create-listing-title d-flex align-items-center d-none d-lg-flex">
                            <span class="icon manage-ads"></span> Manage Ads
                        </h3>
                        <a href="manage-ads.html" class="back-link ml-2">Back</a>
                    </div>
                    <div class="card">
                        <div class="card-content">
                            <div class="ads-details">
                                <div
                                    class="d-flex align-items-start align-items-md-center justify-content-start justify-content-md-between flex-column-reverse flex-md-row">
                                    <h4 class="ad-title w-100"><span class="text-red">{{ $ad_data->title }}</span>
                                    </h4>
                                    <div
                                        class="d-flex justify-content-between flex-md-column justify-content-md-end text-right w-100">
                                        <span class="adId">ADId : {{ $ad_data->id }}</span>
                                        <span class="ad-type">{{ $ad_data->item_show_type }}</span>
                                    </div>
                                </div>                              
                                <div class="product-image-slider">
                                    <div class="main-images">
                                        @foreach ($ad_images as $key => $image)
                                            <div class="main-image-block">
                                                @if (!empty($ad_images))
                                                    <img src="{{ url($image->image_url . '/' . $image->image_name) }}"
                                                        alt="Featured listing" class="img-fluid" />
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="product-tumbnail-slider">
                                        @foreach ($ad_images as $key => $image)
                                            <div class="thumbnail">
                                                @if (!empty($ad_images))
                                                    <img src="{{ url($image->image_url . '/' . $image->image_name) }}"
                                                        alt="Featured listing" class="img-fluid" />
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                @php
                                    $category_details = get_category_dynamic_details_for_search($ad_data->identification_code, $ad_data->category_id);
                                @endphp
                                <!-- for horses -->
                                @if ($ad_data->category_id == 1)
                                    <div class="ad-specifications">
                                        <div class="block">
                                            <p>State</p>
                                            <h4><span
                                                    class="text-red">{{ get_state_name($ad_data->state_id) }}</span>
                                            </h4>
                                        </div>
                                        <div class="block">
                                            <p>Suburb</p>
                                            <h4><span
                                                    class="text-red">{{ get_suburb_name($ad_data->suburb_id) }}</span>
                                            </h4>
                                        </div>
                                        <div class="block">
                                            <p>Horse name</p>
                                            <h4><span class="text-red">{{ $ad_data->horse_name }}</span></h4>
                                        </div>
                                        <div class="block">
                                            <p>Horse registration no.</p>
                                            <h4><span class="text-red">{{ $ad_data->horse_registration_no }}</span>
                                            </h4>
                                        </div>
                                        <div class="block">
                                            <p>Sire</p>
                                            <h4><span class="text-red">{{ $ad_data->sire }}</span></h4>
                                        </div>
                                        <div class="block">
                                            <p>Dam</p>
                                            <h4><span class="text-red">{{ $ad_data->dam }}</span></h4>
                                        </div>
                                        <div class="block">
                                            <p>Discipline</p>
                                            <h4><span
                                                    class="text-red">{{ dynamic_field_data($category_details['horses_discipline']->dynamic_field_id) }}</span>
                                            </h4>
                                        </div>
                                        <div class="block">
                                            <p>Temperament</p>
                                            <h4><span
                                                    class="text-red">{{ dynamic_field_data($category_details['horses_temperament']->dynamic_field_id) }}</span>
                                            </h4>
                                        </div>
                                        <div class="block">
                                            <p>Breed (Primary)</p>
                                            <h4><span
                                                    class="text-red">{{ dynamic_field_data($category_details['horses_breed_primary']->dynamic_field_id) }}</span>
                                            </h4>
                                        </div>
                                        <div class="block">
                                            <p>Breed (Secondary)</p>
                                            <h4><span
                                                    class="text-red">{{ dynamic_field_data($category_details['horses_breed_secondary']->dynamic_field_id) }}</span>
                                            </h4>
                                        </div>
                                        <div class="block">
                                            <p>Colour</p>
                                            <h4><span
                                                    class="text-red">{{ dynamic_field_data($category_details['horses_color']->dynamic_field_id) }}</span>
                                            </h4>
                                        </div>
                                        <div class="block">
                                            <p>Gender</p>
                                            <h4><span
                                                    class="text-red">{{ dynamic_field_data($category_details['horses_gender']->dynamic_field_id) }}</span>
                                            </h4>
                                        </div>
                                        <div class="block">
                                            <p>Age</p>
                                            <h4><span
                                                    class="text-red">{{ dynamic_field_data($category_details['horses_age']->dynamic_field_id) }}</span>
                                            </h4>
                                        </div>
                                        <div class="block">
                                            <p>Rider level</p>
                                            <h4><span
                                                    class="text-red">{{ dynamic_field_data($category_details['horses_rider_Level']->dynamic_field_id) }}</span>
                                            </h4>
                                        </div>
                                        <div class="block">
                                            <p>Height</p>
                                            <h4><span
                                                    class="text-red">{{ dynamic_field_data($category_details['horses_height']->dynamic_field_id) }}</span>
                                            </h4>
                                        </div>
                                    </div>
                                @elseif($ad_data->category_id == 2)
                                    <div class="ad-specifications">
                                        <div class="block">
                                            <p>State</p>
                                            <h4><span
                                                    class="text-red">{{ get_state_name($ad_data->state_id) }}</span>
                                            </h4>
                                        </div>
                                        <div class="block">
                                            <p>Suburb</p>
                                            <h4><span
                                                    class="text-red">{{ get_suburb_name($ad_data->suburb_id) }}</span>
                                            </h4>
                                        </div>
                                        <div class="block">
                                            <p>Make</p>
                                            <h4><span class="text-red">{{ $ad_data->make }}</span></h4>
                                        </div>
                                        <div class="block">
                                            <p>Model</p>
                                            <h4><span class="text-red">{{ $ad_data->transport_model }}</span></h4>
                                        </div>
                                        <div class="block">
                                            <p>Year</p>
                                            <h4><span class="text-red">{{ $ad_data->year }}</span></h4>
                                        </div>
                                        <div class="block">
                                            <p>KMS</p>
                                            <h4><span class="text-red">{{ $ad_data->kms }}</span></h4>
                                        </div>

                                        <div class="block">
                                            <p>Type</p>
                                            <h4><span
                                                    class="text-red">{{ dynamic_field_data($category_details['transport_type']->dynamic_field_id) }}</span>
                                            </h4>
                                        </div>
                                        <div class="block">
                                            <p>Axles</p>
                                            <h4><span
                                                    class="text-red">{{ dynamic_field_data($category_details['transport_axles']->dynamic_field_id) }}</span>
                                            </h4>
                                        </div>
                                        <div class="block">
                                            <p>No. of Horses to carry</p>
                                            <h4><span
                                                    class="text-red">{{ dynamic_field_data($category_details['transport_no_of_horse_to_carry']->dynamic_field_id) }}</span>
                                            </h4>
                                        </div>
                                        <div class="block">
                                            <p>Registration state</p>
                                            <h4><span
                                                    class="text-red">{{ dynamic_field_data($category_details['transport_registration_state']->dynamic_field_id) }}</span>
                                            </h4>
                                        </div>
                                        <div class="block">
                                            <p>Ramp location</p>
                                            <h4><span
                                                    class="text-red">{{ dynamic_field_data($category_details['transport_ramp_location']->dynamic_field_id) }}</span>
                                            </h4>
                                        </div>
                                        <div class="block">
                                            <p>Vehicle registration number</p>
                                            <h4><span
                                                    class="text-red">{{ $ad_data->vehicle_registration_number }}</span>
                                            </h4>
                                        </div>
                                    </div>
                                @elseif($ad_data->category_id == 3)
                                    <div class="ad-specifications">
                                        <div class="block">
                                            <p>State</p>
                                            <h4><span
                                                    class="text-red">{{ get_state_name($ad_data->state_id) }}</span>
                                            </h4>
                                        </div>
                                        <div class="block">
                                            <p>Suburb</p>
                                            <h4><span
                                                    class="text-red">{{ get_suburb_name($ad_data->suburb_id) }}</span>
                                            </h4>
                                        </div>
                                        <div class="block">
                                            <p>Brand</p>
                                            <h4><span class="text-red">{{ $ad_data->brand }}</span></h4>
                                        </div>
                                        <div class="block">
                                            <p>Model</p>
                                            <h4><span class="text-red">{{ $ad_data->saddlery_model }}</span></h4>
                                        </div>
                                        <div class="block">
                                            <p>Type</p>
                                            <h4><span
                                                    class="text-red">{{ dynamic_field_data($category_details['saddlery_type']->dynamic_field_id) }}</span>
                                            </h4>
                                        </div>
                                        <div class="block">
                                            <p>Condition</p>
                                            <h4><span
                                                    class="text-red">{{ dynamic_field_data($category_details['saddlery_condition']->dynamic_field_id) }}</span>
                                            </h4>
                                        </div>
                                        <div class="block">
                                            <p>category</p>
                                            <h4><span
                                                    class="text-red">{{ dynamic_field_data($category_details['saddlery_category']->dynamic_field_id) }}</span>
                                            </h4>
                                        </div>
                                    </div>
                                @elseif($ad_data->category_id == 4)
                                    <div class="ad-specifications">
                                        <div class="block">
                                            <p>State</p>
                                            <h4><span
                                                    class="text-red">{{ get_state_name($ad_data->state_id) }}</span>
                                            </h4>
                                        </div>
                                        <div class="block">
                                            <p>Suburb</p>
                                            <h4><span
                                                    class="text-red">{{ get_suburb_name($ad_data->suburb_id) }}</span>
                                            </h4>
                                        </div>
                                        <div class="block">
                                            <p>Land Size</p>
                                            <h4><span class="text-red">{{ $ad_data->land_size }}</span></h4>
                                        </div>
                                        <div class="block">
                                            <p>Property Category</p>
                                            <h4><span class="text-red">{{ $ad_data->property_category }}</span>
                                            </h4>
                                        </div>
                                        <div class="block">
                                            <p>No. of Bathrooms</p>
                                            <h4><span
                                                    class="text-red">{{ dynamic_field_data($category_details['property_Bathrooms']->dynamic_field_id) }}</span>
                                            </h4>
                                        </div>
                                        <div class="block">
                                            <p>No. of Bedrooms</p>
                                            <h4><span
                                                    class="text-red">{{ dynamic_field_data($category_details['property_Bedrooms']->dynamic_field_id) }}</span>
                                            </h4>
                                        </div>
                                    </div>
                                @endif
                                <p class="description">{{ $ad_data->description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('js-content')  
  <script type="text/javascript" src="{{ asset('frontend/js/slick.min.js') }}?v={{ CSS_JS_VER }}"></script>
  <script type="text/javascript" src="{{ asset('frontend/js/jquery-ui.min.js') }}?v={{ CSS_JS_VER }}"></script>
  <script type="text/javascript" src="{{ asset('frontend/js/jquery.validate.min.js') }}?v={{ CSS_JS_VER }}"></script>
  <script type="text/javascript" src="{{ asset('frontend/js/additional-methods.min.js') }}?v={{ CSS_JS_VER }}"></script>  
  <script type="text/javascript" src="{{ asset('frontend/js/sweetalert.min.js') }}?v={{ CSS_JS_VER }}"></script>
  <script type="text/javascript" src="{{ asset('frontend/js/custom.min.js') }}?v={{ CSS_JS_VER }}"></script>
@endsection
@push('custom-scripts')
    <script type="text/javascript" src="{{ asset('/frontend/custom_js_css/js/ads_listing.js') }}?v={{ CSS_JS_VER }}">
    </script>
@endpush
