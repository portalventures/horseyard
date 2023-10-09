@extends('front.layouts.master')

@php
  $category_details = get_category_dynamic_details_for_search($listing->identification_code, $listing->category_id);  
  $price_title = $listing->price.'$.';  
  $state_title = get_state_name($listing->state_id).','; 
  $suburb_title = get_suburb_name($listing->suburb_id).'.';
@endphp

@if($listing->category_id == 1)
  @php
    $horses_discipline = dynamic_field_data($category_details['horses_discipline']->dynamic_field_id);     
    $horses_breed_primary = dynamic_field_data($category_details['horses_breed_primary']->dynamic_field_id);
    $horses_gender = dynamic_field_data($category_details['horses_gender']->dynamic_field_id);
    $horses_height = dynamic_field_data($category_details['horses_height']->dynamic_field_id);
    $horses_age = dynamic_field_data($category_details['horses_age']->dynamic_field_id);
    $horses_color = dynamic_field_data($category_details['horses_color']->dynamic_field_id);
    $horses_rider_Level = dynamic_field_data($category_details['horses_rider_Level']->dynamic_field_id);
  @endphp
@elseif($listing->category_id == 2)
  @php
    $transport_type = dynamic_field_data($category_details['transport_type']->dynamic_field_id);
    $transport_no_of_horse_to_carry = dynamic_field_data($category_details['transport_no_of_horse_to_carry']->dynamic_field_id);    
    $transport_axles = dynamic_field_data($category_details['transport_axles']->dynamic_field_id);    
    $transport_ramp_location = dynamic_field_data($category_details['transport_ramp_location']->dynamic_field_id);
    $transport_registration_state = dynamic_field_data($category_details['transport_registration_state']->dynamic_field_id);
  @endphp
@elseif($listing->category_id == 3)
  @php                  
    $saddlery_type = dynamic_field_data($category_details['saddlery_type']->dynamic_field_id);
    $saddlery_category = dynamic_field_data($category_details['saddlery_category']->dynamic_field_id);
    $saddlery_condition = dynamic_field_data($category_details['saddlery_condition']->dynamic_field_id);
  @endphp
@elseif($listing->category_id == 4)
  @php
    $property_Bathrooms = dynamic_field_data($category_details['property_Bathrooms']->dynamic_field_id);
    $property_Bedrooms = dynamic_field_data($category_details['property_Bedrooms']->dynamic_field_id);
  @endphp
@endif


@if($listing->category_id == 1)
  @section('title', $horses_breed_primary. ' ' .$horses_gender.' for '.$price_title.' Horses for sale at'. ' '. $state_title.' '.$suburb_title.' '.$horses_color. ' | HorseYard AU')
@elseif($listing->category_id == 2)
  @section('title', $transport_type. ' for ' .$price_title.' Transport for sale at'. ' '. $state_title.' '.$suburb_title.' '.$listing->transport_model. ' | HorseYard AU')
@elseif($listing->category_id == 3)
  @section('title', $saddlery_type. ' for ' .$price_title.' Saddlery for sale at'. ' '. $state_title.' '.$suburb_title.' '.$listing->brand. ' | HorseYard AU')
@elseif($listing->category_id == 4)
  @section('title', ' for ' .$price_title.' Saddlery for sale at'. ' '. $state_title.' '.$suburb_title.' | HorseYard AU')
@endif

@section('canonical-content')

  <link rel="canonical" href="{{URL::current()}}"/>
@endsection
@section('css-content')
  <link rel="stylesheet" href="{{ asset('/frontend/css/slick.min.css') }}?v={{ CSS_JS_VER }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('/frontend/css/sweetalert.min.css') }}?v={{ CSS_JS_VER }}">  
  <link rel="stylesheet" href="{{ asset('/frontend/css/custom.min.css') }}?v={{ CSS_JS_VER }}">  
  <link rel="stylesheet" href="{{ asset('/frontend/custom_js_css/css/custom.css') }}?v={{ CSS_JS_VER }}"> 
@endsection
@section('content')
  <div id="main">

    <div class="breadcrumbs">
      <div class="container">
        <ul>
          <li><a href="{{url('/')}}">Home</a></li>            
          @if($listing->category_id == 1)
            @php
              $attribute = dynamic_field_slug($category_details['horses_breed_primary']->dynamic_field_id);
            @endphp
            <li><a href="{{ url('horses-for-sale') }}">Horses for Sale</a></li>
            @if(isset($category_details['horses_breed_primary']->dynamic_field_id) && !empty($category_details['horses_breed_primary']->dynamic_field_id))
              <li>
                <a href="{{ url('horses-for-sale') }}/{{$attribute}}">
                {{dynamic_field_data($category_details['horses_breed_primary']->dynamic_field_id)}}</a>
              </li>
            @endif
          @elseif($listing->category_id == 2)
            @php
              $attribute = dynamic_field_slug($category_details['transport_type']->dynamic_field_id);
            @endphp
            <li><a href="{{ url('transport-for-horses')}}">Horse Transport for Sale</a></li>
            @if(isset($category_details['transport_type']->dynamic_field_id) && !empty($category_details['transport_type']->dynamic_field_id))
              <li>
                <a href="{{ url('transport-for-horses') }}/{{$attribute}}">
                {{dynamic_field_data($category_details['transport_type']->dynamic_field_id)}}</a>
              </li>
            @endif
          @elseif($listing->category_id == 3)
            @php
              $attribute = dynamic_field_slug($category_details['saddlery_type']->dynamic_field_id);
            @endphp
            <li><a href="{{ url('saddlery-and-tack')}}">Saddlery and Tack for Sale</a></li>
            @if(isset($category_details['saddlery_type']->dynamic_field_id) && !empty($category_details['saddlery_type']->dynamic_field_id))
              <li>
                <a href="{{ url('saddlery-and-tack') }}/{{$attribute}}">
                {{dynamic_field_data($category_details['saddlery_type']->dynamic_field_id)}}</a>
              </li>
            @endif
          @elseif($listing->category_id == 4)        
            <li><a href="{{ url('property-for-sale')}}">Property for Sale</a></li>                
          @endif
          <li>{{ $listing->title }}</li>
        </ul>
      </div>
    </div>
    <div class="container">
      <div class="d-flex align-items-center justify-content-between">
        <a href="javascript:history.back()" class="link backto">← Back to Search Results</a>
        @if(!Auth::user())
          <a href="{{ url('user/login')}}" class="link save listing_add_into_wishlist"><span class="icon heart"></span><span class="saved-text">Save</span></a>
        @elseif(Auth::user() && Auth::user()->role == 'user')
          @php
            $wishlist_count = user_listing_present_in_wishlist(Auth()->user()->id, $listing->id)
          @endphp
          <a href="javascript:void(0)" class="link save listing_add_into_wishlist" data-id="{{$listing->identification_code}}"></span><span class="icon heart"></span><span class="saved-text">{{ $wishlist_count > 0 ? 'Saved' : 'Save'}}</span></a>
        @endif
      </div>
      <div class="product-details d-flex">
        <div class="product-left">
          <div class="d-flex align-items-center justify-content-between">
            <h1 class="product-name">{{ $listing->title }}</h1>
            @if($listing->item_show_type != 'free')
              <p class="price">${{number_format($listing->price)}}
                <sub>{{substr($listing->item_show_type,0,3)}}</sub>
              </p>
            @else
              <p class="price">Free</p>
            @endif
          </div>
          <div class="views">
            <span class="icon view"></span>{{$listing_number_of_views}} views
          </div>
          <div class="product-image-slider">
            <div class="main-images">              
              @foreach($ad_images as $key => $image)
                <div class="main-image-block">
                  @if(!empty($ad_images))
                    <img src="{{ url($image->image_url.'/'.$image->image_name) }}" alt="Featured listing" class="img-fluid" />
                  @endif
                </div>
              @endforeach
            </div>
            <div class="product-tumbnail-slider">
              @foreach($ad_images as $key => $image)
                <div class="thumbnail">
                  @if(!empty($ad_images))
                    <img src="{{ url($image->image_url.'/'.$image->image_name) }}" alt="Featured listing" class="img-fluid" />
                  @endif
                </div>
              @endforeach
            </div>
          </div>
          <div class="product-description">
            <h3>Description</h3>
            <p>{{ $listing->description }}</p>
          </div>
          @if(!empty($listing->video_url))
            <div id="video">
              @php
                $video_url = explode("v=",$listing->video_url);
              @endphp
              @if(isset($video_url[1]))
                <iframe height="345" src="https://www.youtube.com/embed/{{$video_url[1]}}" width="100%">
                </iframe>
              @endif
            </div>
          @endif
        </div>
        <div class="product-right">
          <div class="product-right-col">
            <h4><span class="icon horse"></span>
            @if($listing->category_id == 1)
              Horse Details
            @elseif($listing->category_id == 2)
              Transport Details
            @elseif($listing->category_id == 3)
              Saddlery Details
            @elseif($listing->category_id == 4)
              Property Details
            @endif
            </h4>
            <span class="sku">{{ $listing->ad_id }}</span>
            @if($listing->category_id == 1) <!-- horses -->
              <div class="specifications">
                <table>
                  @if(!empty($horses_discipline))
                  <tr>
                    <th>Disciplines:</th>
                    <td>
                      <a href="{{ url('horses-for-sale') }}/{{Str::slug($horses_discipline,'-')}}" class="link">
                        {{$horses_discipline}}
                      </a>
                    </td>
                  </tr>
                  @endif
                  @if(!empty($horses_breed_primary))
                  <tr>
                    <th>Breed:</th>
                    <td>
                      <a href="{{ url('horses-for-sale') }}/{{Str::slug($horses_breed_primary,'-')}}" class="link">
                        {{$horses_breed_primary}}
                      </a>
                    </td>
                  </tr>
                  @endif
                  @if(!empty($horses_gender))
                  <tr>
                    <th>Sex:</th>
                    <td>
                      <a href="{{ url('field-sex') }}/{{Str::slug($horses_gender,'-')}}" class="link">
                        {{$horses_gender}}
                      </a>
                    </td>
                  </tr>
                  @endif
                  @if(!empty($horses_height))
                  <tr>
                    <th>Height:</th>
                    <td>
                    {{$horses_height}}hh
                    </td>
                  </tr>
                  @endif
                  @if(!empty($horses_age))
                  <tr>
                    <th>Age:</th>
                    <td>{{$horses_age}}</td>
                  </tr>
                  @endif
                  @if(!empty($horses_color))
                  <tr>
                    <th>Color:</th>
                    <td>
                      <a href="{{ url('horse-colour') }}/{{Str::slug($horses_color,'-')}}" class="link">
                        {{$horses_color}}
                      </a>
                    </td>
                  </tr>
                  @endif
                  @if(!empty($horses_rider_Level))
                  <tr>
                    <th>Rider Level:</th>
                    <td>
                      <a href="{{ url('rider-level') }}/{{Str::slug($horses_rider_Level,'-')}}" class="link">
                        {{$horses_rider_Level}}
                      </a>
                    </td>
                  </tr>
                  @endif
                  <tr>
                    <th>Location: </th>
                    <td>
                      @if(!empty($listing->suburb_id))
                        <a href="{{ url('suburb')}}/{{strtolower(get_Suburb_short_code($listing->suburb_id))}}" class="link">
                          {{get_suburb_name($listing->suburb_id)}},
                        </a>
                      @endif
                      @if(!empty($listing->state_id))
                        <a href="{{ url('horses-for-sale/location')}}/{{strtolower(get_state_short_code($listing->state_id))}}" class="link">
                          {{get_state_name($listing->state_id)}}
                        </a>
                      @endif
                    </td>
                  </tr>
                </table>
              </div>
            @elseif($listing->category_id == 2) <!-- transport -->
              <div class="specifications">
                <table>
                  @if(!empty($transport_type))
                  <tr>
                    <th>Transport Type:</th>
                    <td>
                      <a href="{{ url('transport-for-horses') }}/{{Str::slug($transport_type,'-')}}" class="link">
                        {{$transport_type}}
                      </a>
                    </td>
                  </tr>
                  @endif
                  @if(!empty($transport_no_of_horse_to_carry))
                  <tr>
                    <th>Horse Carry:</th>
                    <td>
                      <!-- <a href="{{ url('transport-for-horses') }}/{{Str::slug($transport_no_of_horse_to_carry,'-')}}" class="link"> -->
                        {{$transport_no_of_horse_to_carry}}
                      <!-- </a> -->
                    </td>
                  </tr>
                  @endif
                  @if(!empty($transport_axles))
                    <tr>
                      <th>Axles:</th>
                      <td>
                        <a href="{{ url('axles') }}/{{Str::slug($transport_axles,'-')}}" class="link">
                          {{$transport_axles}}
                        </a>
                      </td>
                    </tr>
                  @endif
                  @if(!empty($transport_ramp_location))
                    <tr>
                      <th>Ramp Location:</th>
                      <td>
                        <a href="{{ url('ramp-location') }}/{{Str::slug($transport_ramp_location,'-')}}" class="link">
                          {{$transport_ramp_location}}
                        </a>
                      </td>
                    </tr>
                  @endif
                  @if(!empty($transport_registration_state))
                  <tr>
                    <th>Registration State:</th>
                    <td>
                      <a href="{{ url('field-location-of-vehicle-state') }}/{{Str::slug($transport_registration_state,'-')}}" class="link">  {{$transport_registration_state}}
                      </a>
                    </td>
                  </tr>
                  @endif
                  <tr>
                    <th>Location: </th>
                    <td>
                      <a href="{{ url('suburb')}}/{{strtolower(get_Suburb_short_code($listing->suburb_id))}}" class="link">
                        {{get_suburb_name($listing->suburb_id)}},
                      </a>
                      <a href="{{ url('horses-for-sale/location')}}/{{strtolower(get_state_short_code($listing->state_id))}}" class="link">
                        {{get_state_name($listing->state_id)}}
                      </a>
                    </td>
                  </tr>
                </table>
              </div>
            @elseif($listing->category_id == 3) <!-- saddlery -->
              <div class="specifications">
                <table>
                  @if(!empty($saddlery_type))
                  <tr>
                    <th>Saddlery Type:</th>
                    <td>
                      <a href="{{ url('saddlery-type') }}/{{Str::slug($saddlery_type,'-')}}" class="link">
                        {{$saddlery_type}}
                      </a>
                    </td>
                  </tr>
                  @endif
                  @if(!empty($saddlery_category))
                  <tr>
                    <th>Category:</th>
                    <td>{{$saddlery_category}}</td>
                  </tr>
                  @endif
                  @if(!empty($saddlery_condition))
                  <tr>
                    <th>Condition:</th>
                    <td>{{$saddlery_condition}}</td>
                  </tr>
                  @endif
                  <tr>
                    <th>Location: </th>
                    <td>
                      <a href="{{ url('suburb')}}/{{strtolower(get_Suburb_short_code($listing->suburb_id))}}" class="link">
                        {{get_suburb_name($listing->suburb_id)}},
                      </a>
                      <a href="{{ url('horses-for-sale/location')}}/{{strtolower(get_state_short_code($listing->state_id))}}" class="link">
                        {{get_state_name($listing->state_id)}}
                      </a>
                    </td>
                  </tr>
                </table>
              </div>
            @elseif($listing->category_id == 4) <!-- property -->
              <div class="specifications">
                <table>
                  @if(!empty($property_Bathrooms))
                  <tr>
                    <th>Bathrooms:</th>
                    <td>{{$property_Bathrooms}}</td>
                  </tr>
                  @endif
                  @if(!empty($property_Bedrooms))
                  <tr>
                    <th>Bedrooms:</th>
                    <td>{{$property_Bedrooms}}</td>
                  </tr>
                  @endif
                  @if(!empty($listing->property_category))
                    <tr>
                      <th>Category:</th>
                      <td>{{$listing->property_category}}</td>
                    </tr>
                  @endif
                  <tr>
                    <th>Location: </th>
                    <td>
                      <a href="{{ url('suburb')}}/{{strtolower(get_Suburb_short_code($listing->suburb_id))}}" class="link">
                        {{get_suburb_name($listing->suburb_id)}},
                      </a>
                      <a href="{{ url('horses-for-sale/location')}}/{{strtolower(get_state_short_code($listing->state_id))}}" class="link">
                        {{get_state_name($listing->state_id)}}
                      </a>
                    </td>
                  </tr>
                </table>
              </div>
            @endif
            <div class="filter-block">
              <h4>Contact the Seller</h4>
              @if(!Auth::user())
              <div class="contact-details">
                <span class="icon phone"></span>Phone: <a href="javascript:void(0)" class="link">***** **{{ substr($listing->contact_number,-3) }}</a>
              </div>
              <a href="{{ url('user/login')}}" class="btn btn-primary" type="button">Click to reveal number</a>
              @else
                <div class="contact-details">
                  <span class="icon phone"></span>Phone: <a href="javascript:void(0)" class="link">{{ $listing->contact_number }}</a>
                </div>
              @endif
            </div>
          </div>
          <div class="share-listing">
            Share this listing
            <ul>
              <li><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{url()->current()}}&amp;src=sdkpreparse"><span class="icon share-facebook"></span></a></li>
              
              <li><a target="_blank" href="https://graph.facebook.com/v11.0/2365720400237118/media?image_url=https://qa.horseyard.indous.net/listing_images/4/horse.primary-e9a47e1c486c4fb7bf729e05b59cf0df.jpg"><span class="icon share-instagram"></span></a></li>
              
              <li><a href="https://twitter.com/intent/tweet?text={{$listing->title}}&url={{url()->current()}}"target="_blank"><span class="icon share-twitter"></span></a></li>

              <li><a href="mailto:{{$listing->contact_email}}?subject=Inquiry for {{ $listing->title }}&body=Hi,I found this website and thought you might like it http://www.geocities.com/wowhtml/"><span class="icon share-mail"></span></a></li>
            </ul>
          </div>
          <div class="report-listing">            
            <a @if(Auth::user()) data-target="#reportListing" data-toggle="modal" @else href="{{ url('user/login')}}" @endif class="btn btn-primary text_color_white">Report</a>            
          </div>
        </div>
      </div>
      <div class="recently-viewed">
        <h4>People who viewed this listing also viewed:</h4>
        <div class="isotope-main">
          <div class="tab-pane">
            @foreach($meta_data as $key => $listing_data)
              @php
                $listing_image = get_listing_first_image($listing_data->listing_master_id);
                $category_details = get_category_dynamic_details_for_search($listing_data->identification_code, $listing_data->category_id);

                $attributes = generate_ad_attribute_view_url($category_details, $listing_data->identification_code, $listing_data->category_id); 
               
                if($listing_data->category_id == 1)
                {
                  $breed = dynamic_field_slug($category_details['horses_breed_primary']->dynamic_field_id);
                }

                $location = generate_location_view_url($listing_data->identification_code)   
              @endphp
              @if($listing_data->category_id == 1)
                <a href="{{ url('ad')}}/{{$listing_data->slug}}">
              @elseif($listing_data->category_id == 2)
                <a href="{{ url('ad')}}/{{$listing_data->slug}}">
              @elseif($listing_data->category_id == 3)
                <a href="{{ url('ad')}}/{{$listing_data->slug}}">
              @elseif($listing_data->category_id == 4)
                <a href="{{ url('ad')}}/{{$listing_data->slug}}">
              @endif
                <div class="element-item">
                  <div class="image-box">
                    @if(!empty($listing_image))
                      <img src="{{ url($listing_image->image_url.'/'.$listing_image->image_name) }}" />
                    @else
                      <img src="{{ asset('admin/images/featured-table.png') }}" />
                    @endif
                  </div>
                  <div class="details">
                    <div class="d-flex align-items-center justify-content-between">
                      <label class="type">{{ get_listing_ad_id($listing_data->id) }}</label>
                      <label class="state">
                        <span class="icon address"></span>
                        {{get_state_short_code($listing_data->state_id)}}
                      </label>
                    </div>
                    <h3 class="name">{{ mb_strimwidth($listing_data->title, 0, 22,'...')}}</h3>
                    @if($listing_data->category_id == 1)
                        <label class="breedtype">Horse</label>
                      @elseif($listing_data->category_id == 2)
                        <label class="breedtype">Transport</label>
                      @elseif($listing_data->category_id == 3)
                        <label class="breedtype">Saddlery</label>
                      @elseif($listing_data->category_id == 4)
                        <label class="breedtype">Property</label>
                      @else
                        <label class="breedtype">NA</label>
                      @endif
                    @if($listing_data->item_show_type != 'free')
                      <p class="price">${{number_format($listing_data->price)}}
                        <sub>{{substr($listing_data->item_show_type,0,3)}}</sub>
                      </p>
                      @else
                        <p class="price">Free
                        </p>
                    @endif
                  </div>
                </div>
              </a>
            @endforeach              
          </div>
        </div>
      </div>
      <div class="product-detail-advertisement">
        <div class="advertisement-text">
          Advertise Now on
          <img src="{{ asset('frontend/images/logo.png') }}" alt="Logo">
        </div>
        <ul>
          <li>Various Ad Placements</li>
          <li>Over xxxxx visits / month</li>
          <li>Premium or Standard Placement</li>
        </ul>
        <a href="#" class="btn btn-primary">Start Advertising Today</a>
        <img src="{{ asset('frontend/images/product-adv-horse.png') }}" alt="Product advertisement" class="product-adv-horse">
      </div>
    </div>
  </div>
  <div class="modal" id="reportListing">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Report for Listing</h5>
        </div>
        <div class="modal-body">
          <form class="listing_report_form">
            <input type="hidden" name="listing_id" value="{{$listing->identification_code}}">
            <div class="form-group">
              <label for="" class="mb-2 mb-md-0">Name</label>
              <input type="text" class="form-control mt-2" placeholder="Name" name="name" id="name">
              <span class="errorMessage"></span>
            </div>
            <div class="form-group">
              <label for="" class="mb-2 mb-md-0">Email*</label>
              <input type="email" class="form-control mt-2" placeholder="Email" name="email" id="email">
              <span class="errorMessage"></span>
            </div>
            <div class="form-group">
              <label for="" class="mb-2 mb-md-0">Please select a reason for reporting this ad</label>
              <div class="d-flex flex-column">
                <label for="duplicate" class="custom-radio mr-3 mb-md-0 mt-2">
                  <input type="radio" name="report_reason" id="duplicate" value="Duplicate">
                  <span></span>Duplicate
                </label>
                <label for="scam" class="custom-radio mr-3 mb-md-0 mt-2">
                  <input type="radio" name="report_reason" id="scam" value="Scam">
                  <span></span>Scam
                </label>
                <label for="misscategorised" class="custom-radio mr-3 mb-md-0 mt-2">
                  <input type="radio" name="report_reason" id="misscategorised" value="Miss-categorised">
                  <span></span>Miss-categorised
                </label>
                <label for="noavailable" class="custom-radio mr-3 mb-md-0 mt-2">
                  <input type="radio" name="report_reason" id="noavailable" value="No longer available">
                  <span></span>No longer available
                </label>
                <label for="unresponsive" class="custom-radio mr-3 mb-md-0 mt-2">
                  <input type="radio" name="report_reason" id="unresponsive" value="Unresponsive Poster">
                  <span></span>Unresponsive Poster
                </label>
                <label for="other" class="custom-radio mr-3 mb-md-0 mt-2">
                  <input type="radio" name="report_reason" id="other" checked value="Other">
                  <span></span>Other
                </label>
                <span class="errorMessage"></span>
              </div>
            </div>
            <div class="form-group">
              <label for="" class="mb-2 mb-md-0">Message*</label>
              <textarea class="form-control mt-2" placeholder="Message" name="report_message"></textarea>
              <span class="errorMessage"></span>
            </div>
            <div class="d-flex justify-content-end align-items-center">
              <button type="submit" class="btn btn-primary">Save</button>
              <a href="javascript:void(0)" class="link ml-3" data-dismiss="modal"><span class="text-red">Cancel</span></a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('js-content')
   <script type="text/javascript" src="{{ asset('frontend/js/slick.min.js') }}?v={{ CSS_JS_VER }}"></script>
  <script type="text/javascript" src="{{ asset('frontend/js/jquery-ui.min.js') }}?v={{ CSS_JS_VER }}"></script>
  <script type="text/javascript" src="{{ asset('frontend/js/jquery.validate.min.js') }}?v={{ CSS_JS_VER }}"></script>
  <script type="text/javascript" src="{{ asset('frontend/js/additional-methods.min.js') }}?v={{ CSS_JS_VER }}"></script>
  <script type="text/javascript" src="{{ asset('frontend/js/custom.min.js') }}?v={{ CSS_JS_VER }}"></script>
@endsection
@push('custom-scripts')
  <script type="text/javascript" src="{{ asset('/frontend/custom_js_css/js/wishlist.js') }}?v={{CSS_JS_VER}}"></script>
  <script type="text/javascript" src="{{ asset('/frontend/custom_js_css/js/search.js') }}?v={{CSS_JS_VER}}"></script>
  <script type="text/javascript" src="{{ asset('/frontend/custom_js_css/js/ads_listing.js') }}?v={{CSS_JS_VER}}"></script>
  <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v6.0&appId=2365720400237118&autoLogAppEvents=1"></script>
@endpush