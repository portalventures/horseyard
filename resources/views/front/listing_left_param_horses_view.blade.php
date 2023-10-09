<div class="filter-block">
  <h4>Disciplines</h4>
  <div class="filter-type">
    @foreach(session()->get('horses_discipline') as $key => $discipline)
      <label for="adultridingclub{{$key}}" class="customCheckbox">
        <input type="checkbox" id="adultridingclub{{$key}}" value="{{$discipline->dynamic_field_id}}" name="search_discipline[]" class="search_discipline" {{ !empty($searchParams->selectedDiscipline) && in_array($discipline->dynamic_field_id,$searchParams->selectedDiscipline) ? 'checked' : '' }}>
        <span></span>
        {{$discipline->field_value}}
      </label>
    @endforeach
  </div>
</div>

<div class="filter-block">
  <h4>Breed</h4>
  <div class="filter-type">    
    @foreach(session()->get('horses_breed_primary') as $key => $breed_primary)
      <label for="adultridingclub1_breed_primary{{$key}}" class="customCheckbox">
        <input type="checkbox" id="adultridingclub1_breed_primary{{$key}}" value="{{$breed_primary->dynamic_field_id}}" name="search_breed_primary[]" class="search_breed_primary" {{ !empty($searchParams->selectedBreed) && in_array($breed_primary->dynamic_field_id,$searchParams->selectedBreed) ? 'checked' : '' }}>
        <span></span>
        {{$breed_primary->field_value}}
      </label>
    @endforeach
  </div>
</div>

<div class="filter-block">
  <h4>Height</h4>
  <div class="filter-type noSpace">
    <div class="d-flex align-items-center justify-content-between">
      <div class="selectParent">
        <select id="minHeight" name="minHeight" class="clearfilter">
          <option value="">Min</option>
            @foreach(session()->get('horses_height') as $key => $height)
              <option value="{{$height->dynamic_field_id}},{{$height->field_value}}" 
                {{ !empty($searchParams->selectedMinHeight) && $height->dynamic_field_id == $searchParams->selectedMinHeight ? 'selected' : '' }}>{{$height->field_value}}</option>  
            @endforeach
        </select>
      </div>
      <span class="gap">-</span>
      <div class="selectParent">
        <select id="maxHeight" name="maxHeight" class="clearfilter">
          <option value="">Max</option>
          @foreach(session()->get('horses_height') as $key => $height)
            <option value="{{$height->dynamic_field_id}},{{$height->field_value}}" {{ !empty($searchParams->selectedMaxHeight) && $height->dynamic_field_id == $searchParams->selectedMaxHeight ? 'selected' : '' }}>{{$height->field_value}}</option>  
          @endforeach
        </select>
      </div>
      <button class="btn btn-secondary ml-2 MaxMinHeight_btn" type="button">Go</button>
    </div>
  </div>
</div>

<!-- <div class="filter-block">
   <div class="filter-type">
    @foreach(session()->get('horses_height') as $key => $height)
      <label for="adultridingclub1_height{{$key}}" class="customCheckbox">
        <input type="checkbox" id="adultridingclub1_height{{$key}}" value="{{$height->dynamic_field_id}}" name="search_height[]" class="search_height" {{ !empty($searchParams->selectedHeight) && in_array($height->dynamic_field_id,$searchParams->selectedHeight) ? 'checked' : '' }}>
        <span></span>
        {{$height->field_value}}
      </label>
    @endforeach
  </div>
</div> -->

<div class="filter-block">
  <h4>Age</h4>
  <div class="filter-type noSpace">
    <div class="d-flex align-items-center justify-content-between">
      <div class="selectParent">
        <select id="minAge" name="minAge" class="clearfilter">
          <option value="">Min</option>
          @foreach(session()->get('horses_age') as $key => $age)
            <option value="{{$age->dynamic_field_id}},{{$age->field_value}}" {{ !empty($searchParams->selectedMinAge) && $age->dynamic_field_id == $searchParams->selectedMinAge ? 'selected' : '' }}>{{$age->field_value}}</option>
          @endforeach
        </select>
      </div>
      <span class="gap">-</span>
      <div class="selectParent">
        <select id="maxAge" name="maxAge" class="clearfilter">
          <option value="">Max</option>
          @foreach(session()->get('horses_age') as $key => $age)
            <option value="{{$age->dynamic_field_id}},{{$age->field_value}}" {{ !empty($searchParams->selectedMaxAge) && $age->dynamic_field_id == $searchParams->selectedMaxAge ? 'selected' : '' }}>{{$age->field_value}}</option>
          @endforeach
        </select>
      </div>
      <button class="btn btn-secondary ml-2 MaxMinAge_btn" type="button">Go</button>
    </div>
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

<div class="filter-block">
  <h4>Sex</h4>
  <div class="filter-type">
    @foreach(session()->get('horses_gender') as $key => $gender)
     <label for="adultridingclub1_gender{{$key}}" class="customCheckbox">
        <input type="checkbox" id="adultridingclub1_gender{{$key}}" value="{{$gender->dynamic_field_id}}" name="search_gender[]" class="search_gender" {{ !empty($searchParams->selectedGender) && in_array($gender->dynamic_field_id,$searchParams->selectedGender) ? 'checked' : '' }}>
        <span></span>
        {{$gender->field_value}}
      </label>                   
    @endforeach
  </div>
</div>

<div class="filter-block">
  <h4>Rider level</h4>
  <div class="filter-type">
    @foreach(session()->get('horses_rider_Level') as $key => $rider_Level)
      <label for="adultridingclub1_rider_Level{{$key}}" class="customCheckbox">
        <input type="checkbox" id="adultridingclub1_rider_Level{{$key}}" value="{{$rider_Level->dynamic_field_id}}" name="search_rider_Level[]" class="search_rider_Level" {{ !empty($searchParams->selectedRiderLevel) && in_array($rider_Level->dynamic_field_id,$searchParams->selectedRiderLevel) ? 'checked' : '' }}>
        <span></span>
        {{$rider_Level->field_value}}
      </label>
    @endforeach
  </div>
</div>

<div class="filter-block">
  <h4>Color</h4>
  <div class="filter-type">
    @foreach(session()->get('horses_color') as $key => $color)
      <label for="adultridingclub1_color{{$key}}" class="customCheckbox">
        <input type="checkbox" id="adultridingclub1_color{{$key}}" value="{{$color->dynamic_field_id}}" name="search_color[]" class="search_color" {{ !empty($searchParams->selectedColor) && in_array($color->dynamic_field_id,$searchParams->selectedColor) ? 'checked' : '' }}>
        <span></span>
        {{$color->field_value}}
      </label>
    @endforeach
  </div>
</div>
