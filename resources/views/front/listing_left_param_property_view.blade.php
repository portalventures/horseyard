<div class="filter-block">
  <h4>Property Type</h4>
  <div class="filter-type">   
    @foreach(session()->get('property_category') as $key => $property_category)    
      <label for="adultridingclub{{$key}}" class="customCheckbox">
        <input type="checkbox" id="adultridingclub{{$key}}" value="{{$property_category}}" 
        name="search_property_category[]" class="search_property_category" 
        {{ !empty($searchParams->selectedPropertyType) && in_array($property_category, $searchParams->selectedPropertyType) ? 'checked' : '' }}>
        <span></span>
        {{$property_category}}
      </label>
    @endforeach
  </div>
</div>

<div class="filter-block">
  <h4>Bedrooms</h4>
  <div class="filter-type">
    @foreach(session()->get('property_Bedrooms') as $key => $property_Bedrooms)
      <label for="searchpropertybedrooms{{$key}}" class="customCheckbox">
        <input type="checkbox" id="searchpropertybedrooms{{$key}}" value="{{$property_Bedrooms->dynamic_field_id}}" name="search_property_Bedrooms[]" class="search_property_Bedrooms" {{ !empty($searchParams->selectedBedrooms) && in_array($property_Bedrooms->dynamic_field_id,$searchParams->selectedBedrooms) ? 'checked' : '' }}>
        <span></span>
        {{$property_Bedrooms->field_value}}
      </label>
    @endforeach
  </div>
</div>

<div class="filter-block">
  <h4>Bathrooms</h4>
  <div class="filter-type">
    @foreach(session()->get('property_Bathrooms') as $key => $property_Bathrooms)
      <label for="searchpropertybathrooms{{$key}}" class="customCheckbox">
        <input type="checkbox" id="searchpropertybathrooms{{$key}}" value="{{$property_Bathrooms->dynamic_field_id}}" name="search_property_Bathrooms[]" class="search_property_Bathrooms" {{ !empty($searchParams->selectedBathrooms) && in_array($property_Bathrooms->dynamic_field_id,$searchParams->selectedBathrooms) ? 'checked' : '' }}>
        <span></span>
        {{$property_Bathrooms->field_value}}
      </label>
    @endforeach
  </div>
</div>

<div class="filter-block">
  <h4>Keyword or SN</h4>
  <div class="filter-type keyword noSpace">
    <div class="d-flex align-items-center justify-content-between">      
      <input id="keyword_txt" name="keyword_or_sn" type="text" value="{{ !empty($searchParams->keywordTxt) ? $searchParams->keywordTxt : '' }}">
      <button class="btn btn-secondary keyword_SN_txt_btn" type="button">Go</button>
    </div>
  </div>
</div>