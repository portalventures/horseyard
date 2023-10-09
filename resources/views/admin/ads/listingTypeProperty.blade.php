<div class="card-type">
  <div class="form-group">
    <div class="row">
      <div class="col col-md-2 pr-0">
        <label for="" class="mb-0 mt-2 float-right text-right">Land Size</label>
      </div>
      <div class="col col-md-10">
        <input type="text" placeholder="Name" class="form-control" name="land_size" id="land_size" value="{{ !empty($ad_data) ? $ad_data->land_size : ''}}">
        <span class="errorMessage"></span>
      </div>
    </div>
  </div>
</div>
<div class="card-type">
  <div class="form-group">
    <div class="row">
      <div class="col col-md-2 pr-0">
        <label for="" class="mb-0 mt-2 float-right text-right">Property Category<span class="text-orange">*</span></label>
      </div>
      <div class="col col-md-4">
        <select class="form-control" name="property_category" id="property_category" required>
          <option value="">Select property category</option>
          @foreach($property_category_array as $key => $property_category)
            <option value="{{$property_category}}"
                @if(!empty($ad_data) && $ad_data->property_category == $property_category)
                  {{'selected'}}
                @endif>
              {{$property_category}}
            </option>
          @endforeach
        </select>
        <span class="errorMessage"></span>
      </div>
      <div class="col col-md-2 pr-0">
        <label for="" class="mb-0 mt-2 float-right text-right">No. of Bathrooms</label>
      </div>
      <div class="col col-md-4">
        <select name="property_Bathrooms" id="property_Bathrooms" class="form-control">
          <option value="">Select no. of bathrooms</option>
          @foreach($get_all_horses_dynamicFields['property_Bathrooms'] as $key => $bathrooms)
            <option value="{{$bathrooms->field_id}},{{$bathrooms->id}}"
              @if(!empty($property_Bathrooms) && $bathrooms->id == $property_Bathrooms->dynamic_field_id)
                {{'selected'}}
              @endif>
              {{$bathrooms->field_value}}
            </option>
          @endforeach
        </select>
        <span class="errorMessage"></span>
      </div>
    </div>
  </div>
  <div class="form-group">
    <div class="row">
      <div class="col col-md-2 pr-0">
        <label for="" class="mb-0 mt-2 float-right text-right">No. of Bedrooms</label>
      </div>
      <div class="col col-md-4">
        <select name="property_Bedrooms" id="property_Bedrooms" class="form-control">
          <option value="">Select no. of bedrooms</option>
          @foreach($get_all_horses_dynamicFields['property_Bedrooms'] as $key => $bedrooms)
            <option value="{{$bedrooms->field_id}},{{$bedrooms->id}}"
              @if(!empty($property_Bedrooms) && $bedrooms->id == $property_Bedrooms->dynamic_field_id)
                {{'selected'}}
              @endif>
              {{$bedrooms->field_value}}
            </option>
          @endforeach
        </select>
        <span class="errorMessage"></span>
      </div>
    </div>
  </div>
</div>