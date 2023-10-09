@if($category == 'horses')
<h1>Find a Horse</h1>
@elseif($category == 'transport')
<h1>Find a Transport</h1>
@elseif($category == 'saddlery')
<h1>Find a Saddlery</h1>
@elseif($category == 'property')
<h1>Find a Property</h1>
@endif
<div class="form-fields">
  <input type="hidden" name="category" value="{{$category}}">
  @if($category == 'horses')
    <div class="form-group m-0">
      <div class="selectParent">
        <select name="discipline" id="discipline">
          <!-- <option value="all_discipline">discipline</option> -->
          <option value="">Discipline</option>
          @foreach($horses_discipline as $key => $discipline)
           <option value="{{$discipline->dynamic_field_id}}">
              {{$discipline->field_value}}
            </option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="form-group m-0">
      <div class="selectParent">
        <select name="breed" id="breed">
          <!-- <option value="all_breed">breed</option> -->
          <option value="">Breed</option>
          @foreach($horses_breed as $key => $breed_primary)
            <option value="{{$breed_primary->dynamic_field_id}}">
              {{$breed_primary->field_value}}
            </option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="form-group m-0">
      <div class="selectParent">
        <select name="sex" id="sex" class="form-control">
          <!-- <option value="all_sex">sex</option> -->
          <option value="">Sex</option>
          @foreach($horses_gender as $key => $gender)
            <option value="{{$gender->dynamic_field_id}}">
              {{$gender->field_value}}
            </option>
          @endforeach
        </select>
      </div>
    </div>
  @elseif($category == 'transport')              
    <div class="form-group m-0">
      <div class="selectParent">
        <select name="transport_type" id="transport_type" class="form-control">
          <!-- <option value="all_transport_type">Type</option> -->
          <option value="">Type</option>
          @foreach($transport_type as $key => $type)
            <option value="{{$type->dynamic_field_id}}">
              {{$type->field_value}}
            </option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="form-group m-0">
      <div class="selectParent">
        <select name="transport_horse_number" id="transport_horse_number" class="form-control">
          <!-- <option value="all_transport_horse_number">Horse Number</option> -->
          <option value="">Horse Number</option>
           @foreach($horse_number as $key => $no_of_horse_to_carry)
            <option value="{{$no_of_horse_to_carry->dynamic_field_id}}">
            {{$no_of_horse_to_carry->field_value}}
          </option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="form-group m-0">
      <div class="selectParent">
        <select name="transport_ramp_location" id="transport_ramp_location" class="form-control">
          <!-- <option value="all_transport_ramp_location">Ramp Location</option> -->
          <option value="">Ramp Location</option>
          @foreach($ramp_location as $key => $ramp_location)
            <option value="{{$ramp_location->dynamic_field_id}}">
              {{$ramp_location->field_value}}
            </option>
          @endforeach
        </select>
      </div>
    </div>
  @elseif($category == 'saddlery')
    <div class="form-group m-0">
      <div class="selectParent">
        <select name="saddlery_type" id="saddlery_type" class="form-control">
          <!-- <option value="all_saddlery_type">Saddlery Type</option> -->
          <option value="">Saddlery Type</option>
          @foreach($saddlery_type as $key => $type)
            <option value="{{$type->dynamic_field_id}}">
              {{$type->field_value}}
            </option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="form-group m-0">
      <div class="selectParent">
        <select name="saddlery_category" id="saddlery_category" class="form-control">
          <!-- <option value="all_saddlery_category">Saddlery Category</option> -->
          <option value="">Saddlery Category</option>
          @foreach($saddlery_category as $key => $sadcategory)
            <option value="{{$sadcategory->dynamic_field_id}}">
            {{$sadcategory->field_value}}
            </option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="form-group"></div>
  @elseif($category == 'property')
    <div class="form-group m-0">
      <div class="selectParent">
        <select class="form-control" name="property_category" id="property_category">
          <!-- <option value="all_property_category">Property Category</option> -->
          <option value="">Property Category</option>
          @foreach($property_category as $key => $property_category)
            <option value="{{$property_category}}">
            {{$property_category}}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="form-group m-0">
      <div class="selectParent">
        <select name="property_Bathrooms" id="property_Bathrooms" class="form-control">
          <!-- <option value="all_property_bathrooms">Property Bathrooms</option> -->
          <option value="">Property Bathrooms</option>
          @foreach($property_bathrooms as $key => $bathrooms)
            <option value="{{$bathrooms->dynamic_field_id}}">
              {{$bathrooms->field_value}}
            </option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="form-group m-0">
      <div class="selectParent">
        <select name="property_Bedrooms" id="property_Bedrooms" class="form-control">
          <!-- <option value="all_property_Bedrooms">Property Bedrooms</option> -->
          <option value="">Property Bedrooms</option>
          @foreach($property_bedrooms as $key => $bedrooms)
            <option value="{{$bedrooms->dynamic_field_id}}">
              {{$bedrooms->field_value}}
            </option>
          @endforeach
        </select>
      </div>
    </div>
  @endif
  <div class="form-group d-flex align-items-center">
    <div class="minPrice">
      <input type="text" name="price_min" id="pricemin" placeholder="Min Price" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
    </div>
    <div class="maxPrice">
      <input type="text" name="price_max" id="pricemax" placeholder="Max Price" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
    </div>
  </div>
  
  <div class="form-group m-0">
    <div class="selectParent">
      <select name="state" id="state" class="form-control">
        <!-- <option value="all_state">State</option> -->
        <option value="">State</option>
        @foreach($all_state as $key => $value)
            <option value="{{$value->state_id}}">{{$value->state_name}}</option>
        @endforeach
      </select>
    </div>
  </div>
  <div class="form-group">
    <input placeholder="Keyword Search" id="keyword_txt" name="keyword_txt" type="text">
  </div>
</div>
<div class="d-flex justify-content-between align-items-center flex-sm-wrap">
  <button type="submit" class="btn btn-primary" id="searchBtn">
    @if($category == 'horses')
    Search Horses
    @elseif($category == 'transport')
    Search Transport
    @elseif($category == 'saddlery')
    Search Saddleries
    @elseif($category == 'property')
    Search Properties
    @endif
    <span class="icon rightArrow"></span>
  </button>
  <button type="reset" class="reset-btn" onclick="reset_quick_search_filter()">Reset</button>
</div>