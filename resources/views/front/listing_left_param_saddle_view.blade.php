<div class="filter-block">
  <h4>Saddlery Type</h4>
  <div class="filter-type">
    @foreach(session()->get('saddlery_type') as $key => $saddlerytype)
      <label for="adultridingclub{{$key}}" class="customCheckbox">
        <input type="checkbox" id="adultridingclub{{$key}}" value="{{$saddlerytype->dynamic_field_id}}" name="search_saddlerytype[]" class="search_saddlerytype" {{ !empty($searchParams->selectedSaddleryType) && in_array($saddlerytype->dynamic_field_id,$searchParams->selectedSaddleryType) ? 'checked' : '' }}>
        <span></span>
        {{$saddlerytype->field_value}}
      </label>
    @endforeach
  </div>
</div>

<div class="filter-block">
  <h4>Saddlery Category</h4>
  <div class="filter-type">
    @foreach(session()->get('saddlery_category') as $key => $saddlerycategory)
      <label for="adultridingclub{{$key}}" class="customCheckbox">
        <input type="checkbox" id="adultridingclub{{$key}}" value="{{$saddlerycategory->dynamic_field_id}}" name="search_saddlerycategory[]" class="search_saddlerycategory" {{ !empty($searchParams->selectedSaddleryCategory) && in_array($saddlerycategory->dynamic_field_id,$searchParams->selectedSaddleryCategory) ? 'checked' : '' }}>
        <span></span>
        {{$saddlerycategory->field_value}}
      </label>
    @endforeach
  </div>
</div>

<div class="filter-block">
  <h4>Saddlery Condition</h4>
  <div class="filter-type">
    @foreach(session()->get('saddlery_condition') as $key => $saddlerycondition)
      <label for="adultridingclub{{$key}}" class="customCheckbox">
        <input type="checkbox" id="adultridingclub{{$key}}" value="{{$saddlerycondition->dynamic_field_id}}" name="search_saddlerycondition[]" class="search_saddlerycondition" {{ !empty($searchParams->selectedSaddleryCondition) && in_array($saddlerycondition->dynamic_field_id,$searchParams->selectedSaddleryCondition) ? 'checked' : '' }}>
        <span></span>
        {{$saddlerycondition->field_value}}
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