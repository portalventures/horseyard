<div class="filter-block">
  <h4>Transport Type</h4>
  <div class="filter-type">
    @foreach(session()->get('transport_type') as $key => $transtype)
      <label for="adultridingclub{{$key}}" class="customCheckbox">
        <input type="checkbox" id="adultridingclub{{$key}}" value="{{$transtype->dynamic_field_id}}" name="search_transtype[]" class="search_trans_type" {{ !empty($searchParams->selectedTransportType) && in_array($transtype->dynamic_field_id,$searchParams->selectedTransportType) ? 'checked' : '' }}>
        <span></span>
        {{$transtype->field_value}}
      </label>
    @endforeach
  </div>
</div>

<div class="filter-block">
  <h4>Number of Horses</h4>
  <div class="filter-type">
    @foreach(session()->get('transport_no_of_horse_to_carry') as $key => $no_of_horses)
      <label for="adultridingclub1_no_of_horses{{$key}}" class="customCheckbox">
        <input type="checkbox" id="adultridingclub1_no_of_horses{{$key}}" value="{{$no_of_horses->dynamic_field_id}}" name="search_no_of_horses[]" class="search_no_of_horses" {{ !empty($searchParams->selectedHorseNumber) && in_array($no_of_horses->dynamic_field_id,$searchParams->selectedHorseNumber) ? 'checked' : '' }}>
        <span></span>
        {{$no_of_horses->field_value}}
      </label>
    @endforeach
  </div>
</div>

<div class="filter-block">
  <h4>Ramp Location</h4>
  <div class="filter-type">
    @foreach(session()->get('transport_ramp_location') as $key => $ramplocation)
      <label for="adultridingclub1_ramplocation{{$key}}" class="customCheckbox">
        <input type="checkbox" id="adultridingclub1_ramplocation{{$key}}" value="{{$ramplocation->dynamic_field_id}}" name="search_ramplocation[]" class="search_ramplocation" {{ !empty($searchParams->selectedRampLocation) && in_array($ramplocation->dynamic_field_id,$searchParams->selectedRampLocation) ? 'checked' : '' }}>
        <span></span>
        {{$ramplocation->field_value}}
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