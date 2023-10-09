<div class="search-result-listing">
  @if(!empty($search_result))
    @foreach($search_result as $key => $ad)
      @php
        $listing_image = get_listing_first_image($ad->listing_id);
        //$listingObj = getListingObj($ad->id);
        $queryStr = $ad->generateQueryURL();
      @endphp
      <div class="result-block">
        <div class="image-box">
        @if(!empty($listing_image))
            <img src="{{ asset('listing_images_250/'.$ad->listing_id.'/'.$listing_image->image_name) }}" />
          @else
            <img src="{{ asset('noimage-big.jpg') }}"/>
          @endif
        </div>
        <div class="result-details">
          <div class="d-flex align-items-center justify-content-between">
            <a href="{{ url('ad')}}/{{$ad->slug_url}}"><h3>{{$ad->listing_title}}</h3></a>
            @if($ad->item_show_type == 'free')
              <p class="price">Free</p>
            @else
              <p class="price">${{number_format($ad->listing_price)}}<sub>{{substr($ad->item_show_type,0,3)}}</sub></p>
            @endif
          </div>
          <p class="sku">{{$ad->ad_id}}</p>
          @php 
          
            $category_details = get_category_dynamic_details_for_search($ad->listing_identification_code, $ad->listing_category_id);

            $attributes = generate_ad_attribute_view_url($category_details, $ad->listing_identification_code, $ad->listing_category_id); 
           
            if($ad->listing_category_id == 1)
            {
              $breed = dynamic_field_slug($category_details['horses_breed_primary']->dynamic_field_id);
            }

            $location = generate_location_view_url($ad->listing_identification_code) 

          @endphp

          @if($ad->listing_category_id == 1) <!-- horses -->
            <div class="specifications">
              <table>
                <tr>
                  @php
                    $horses_breed_primary = dynamic_field_data($category_details['horses_breed_primary']->dynamic_field_id);
                    $horses_gender = dynamic_field_data($category_details['horses_gender']->dynamic_field_id);
                  @endphp
                  @if(!empty($horses_breed_primary))
                    <th>Breed:</th>
                    <td>{{$horses_breed_primary}}</td>
                  @else
                    <th>&nbsp;</th>
                    <td>&nbsp;</td>
                  @endif
                  @if(!empty($horses_gender))
                    <th>Sex:</th>
                    <td>{{$horses_gender}}</td>
                  @else
                    <th>&nbsp;</th>
                    <td>&nbsp;</td>                  
                  @endif
                </tr>
                <tr>
                  @php
                    $horses_height = dynamic_field_data($category_details['horses_height']->dynamic_field_id);
                    $horses_age = dynamic_field_data($category_details['horses_age']->dynamic_field_id);
                  @endphp
                  @if(!empty($horses_height))
                    <th>Height:</th>
                    <td>{{$horses_height}}hh</td>
                  @else
                    <th>&nbsp;</th>
                    <td>&nbsp;</td>
                  @endif
                  @if(!empty($horses_age))
                    <th>Age:</th>
                    <td>{{$horses_age}}</td>
                  @else
                    <th>&nbsp;</th>
                    <td>&nbsp;</td>
                  @endif
                </tr>
                <tr>
                  @php 
                    $horses_color = dynamic_field_data($category_details['horses_color']->dynamic_field_id);
                  @endphp
                  <th>Location:</th>
                  <td>{{get_suburb_name($ad->suburb_id)}}, {{get_state_name($ad->state_id)}}</td>                
                  @if(!empty($horses_color))
                    <th>Color:</th>
                    <td>{{$horses_color}}</td>
                  @else
                    <th>&nbsp;</th>
                    <td>&nbsp;</td>
                  @endif
                </tr>
              </table>
            </div>                    
          @elseif($ad->listing_category_id == 2) <!-- transport -->
            <div class="specifications">
              <table>
                <tr>
                  @php
                    $transport_type = dynamic_field_data($category_details['transport_type']->dynamic_field_id);
                    $transport_no_of_horse_to_carry = dynamic_field_data($category_details['transport_no_of_horse_to_carry']->dynamic_field_id);
                    $transport_ramp_location = dynamic_field_data($category_details['transport_ramp_location']->dynamic_field_id);
                  @endphp
                  @if(!empty($transport_type))
                    <th>Transport Type:</th>
                    <td>{{$transport_type}}</td>
                  @else
                    <th>&nbsp;</th>
                    <td>&nbsp;</td>                  
                  @endif
                  @if(!empty($transport_no_of_horse_to_carry))
                    <th>Horse Carry:</th>
                    <td>{{$transport_no_of_horse_to_carry}}</td>
                  @else
                    <th>&nbsp;</th>
                    <td>&nbsp;</td>
                  @endif
                </tr>
                <tr>
                  @if(!empty($transport_ramp_location))
                    <th>Ramp Location:</th>
                    <td>{{$transport_ramp_location}}</td>
                  @else
                    <th>&nbsp;</th>
                    <td>&nbsp;</td>
                  @endif
                </tr>                          
              </table>
            </div>                    
          @elseif($ad->listing_category_id == 3) <!-- saddlery -->
            <div class="specifications">
              <table>
                <tr>
                  @php
                    $saddlery_type = dynamic_field_data($category_details['saddlery_type']->dynamic_field_id);
                    $saddlery_category = dynamic_field_data($category_details['saddlery_category']->dynamic_field_id);
                  @endphp
                  @if(!empty($saddlery_type))
                    <th>Saddlery Type:</th>
                    <td>{{$saddlery_type}}</td>
                  @else
                    <th>&nbsp;</th>
                    <td>&nbsp;</td>                                    
                  @endif
                  @if(!empty($saddlery_category))
                    <th>Category:</th>
                    <td>{{$saddlery_category}}</td>
                  @else
                    <th>&nbsp;</th>
                    <td>&nbsp;</td>                                    
                  @endif
                </tr>                                            
              </table>
            </div>
          @elseif($ad->listing_category_id == 4) <!-- property -->
            <div class="specifications">
              <table>
                <tr>
                  @php
                    $property_Bathrooms = dynamic_field_data($category_details['property_Bathrooms']->dynamic_field_id);
                    $property_Bedrooms = dynamic_field_data($category_details['property_Bedrooms']->dynamic_field_id);
                  @endphp
                  @if(!empty($property_Bathrooms))
                    <th>Bathrooms:</th>
                    <td>{{$property_Bathrooms}}</td>
                  @else
                    <th>&nbsp;</th>
                    <td>&nbsp;</td>
                  @endif
                  @if(!empty($property_Bedrooms))
                    <th>Bedrooms:</th>
                    <td>{{$property_Bedrooms}}</td>
                  @else
                    <th>&nbsp;</th>
                    <td>&nbsp;</td>
                  @endif
                </tr>
                <tr>
                  @if(!empty($ad->property_category))
                    <th>Category:</th>
                    <td>{{$ad->property_category}}</td>
                  @else
                    <th>&nbsp;</th>
                    <td>&nbsp;</td>
                  @endif
                </tr>                          
              </table>
            </div>                    
          @endif

          <div class="description">
            <p>{{$ad->listing_description}} Taken complete beginner to super confident independent rider. Grace can be ridden tackless , easy Taken complete beginner to super</p>
          </div>
          <div class="actions">
            <div class="d-flex align-items-center justify-content-between">
              @if(!Auth::user())
                <a href="{{ url('user/login')}}" class="link save listing_add_into_wishlist" type="button"><span class="icon heart"></span><span class="saved-text">Save</span></a>
              @elseif(Auth::user() && Auth::user()->role == 'user')
              @php
                $wishlist_count = user_listing_present_in_wishlist(Auth()->user()->id, $ad->listing_id)
              @endphp
                <a href="javascript:void(0)" class="link save listing_add_into_wishlist" data-id="{{$ad->listing_identification_code}}"><span class="icon heart {{ $wishlist_count > 0 ? 'active' : ''}}"></span><span class="saved-text">{{ $wishlist_count > 0 ? 'Saved' : 'Save'}}</span></a>
              @endif

              <a href="{{ url('ad')}}/{{$ad->slug_url}}" class="btn btn-primary">View Listing</a>

            </div>
          </div>
        </div>
      </div>
    @endforeach
  @else
    
  @endif
</div>
@if(!empty($search_result))
  <div class="pagination">
    {{ $search_result->appends(Request::capture()->except('page'))->onEachSide(0)->links() }}
  </div>  
@endif