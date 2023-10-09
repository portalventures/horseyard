<div class="step-content">
  <div class="form-group">
    <div class="row">
      <div class="col col-md-2 pr-md-0">
        <label for="" class="mb-md-0 mt-md-2 float-md-right text-md-right">Brand</label>
      </div>
      <div class="col col-md-4 mb-3 mb-md-0">
        <input type="text" placeholder="Name" class="form-control" name="brand" id="brand" value="{{ !empty($ad_data) ? $ad_data->brand : ''}}">
        <span class="errorMessage"></span>
      </div>
      <div class="col col-md-2 pr-md-0">
        <label for="" class="mb-md-0 mt-md-2 float-md-right text-md-right">Model</label>
      </div>
      <div class="col col-md-4 mb-3 mb-md-0">
        <input type="text" placeholder="Registration No." class="form-control" name="saddlery_model" id="saddlery_model" value="{{ !empty($ad_data) ? $ad_data->saddlery_model : ''}}">
        <span class="errorMessage"></span>
      </div>
    </div>
  </div>
</div>
<div class="step-content">
  <div class="form-group">
    <div class="row">
      <div class="col col-md-2 pr-md-0">
        <label for="" class="mb-md-0 mt-md-2 float-md-right text-md-right">Type<span class="text-red">*</span></label>
      </div>
      <div class="col col-md-4 mb-3 mb-md-0">
        <div class="selectParent">
          <select name="saddlery_type" id="saddlery_type" class="form-control check-validity" required>
            <option value="">Select Type</option>
            @foreach($get_all_horses_dynamicFields['saddlery_type'] as $key => $type)
              <option value="{{$type->field_id}},{{$type->id}}" 
                @if(!empty($saddlery_type) && $type->id == $saddlery_type->dynamic_field_id)
                  {{'selected'}}
                @endif>
                {{$type->field_value}}
              </option>
            @endforeach
          </select>
          <span class="errorMessage"></span>
        </div>
      </div>
      <div class="col col-md-2 pr-md-0">
        <label for="" class="mb-md-0 mt-md-2 float-md-right text-md-right">Condition</label>
      </div>
      <div class="col col-md-4 mb-3 mb-md-0">
        <div class="selectParent">
          <select name="saddlery_condition" id="saddlery_condition" class="form-control">
            <option value="">Select condition</option>
            @foreach($get_all_horses_dynamicFields['saddlery_condition'] as $key => $condition)
              <option value="{{$condition->field_id}},{{$condition->id}}" 
                @if(!empty($saddlery_condition) && $condition->id == $saddlery_condition->dynamic_field_id)
                  {{'selected'}}
                @endif>
                {{$condition->field_value}}
              </option>
            @endforeach
          </select>
          <span class="errorMessage"></span>
        </div>
      </div>
    </div>
  </div>
  <div class="form-group">
    <div class="row">
      <div class="col col-md-2 pr-md-0">
        <label for="" class="mb-md-0 mt-md-2 float-md-right text-md-right">Category</label>
      </div>
      <div class="col col-md-4 mb-3 mb-md-0">
        <div class="selectParent">
          <select name="saddlery_category" id="saddlery_category" class="form-control">
            <option value="">Select category</option>
            @foreach($get_all_horses_dynamicFields['saddlery_category'] as $key => $category)
              <option value="{{$category->field_id}},{{$category->id}}" 
                @if(!empty($saddlery_category) && $category->id == $saddlery_category->dynamic_field_id)
                  {{'selected'}}
                @endif>
              {{$category->field_value}}
              </option>
            @endforeach
          </select>
          <span class="errorMessage"></span>
        </div>
      </div>
    </div>
  </div>
</div>