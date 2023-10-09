<div class="step-content">
  <div class="form-group">
    <div class="row">
      <div class="col col-md-2 pr-md-0">
        <label for="" class="mb-md-0 mt-md-2 float-md-right text-md-right">Horse Name<span class="text-red">*</span></label>
      </div>
      <div class="col col-md-4 mb-3 mb-md-0">
        <input type="text" placeholder="Name" class="form-control check-validity firstNoSpace" name="horse_name" id="horse_name" 
        value="{{ !empty($ad_data) ? $ad_data->horse_name : ''}}" required>
        <span class="errorMessage"></span>
      </div>
      <div class="col col-md-2 pr-md-0">
        <label for="" class="mb-md-0 mt-md-2 float-md-right text-md-right">Horse Registration No.<span class="text-red">*</span></label>
      </div>
      <div class="col col-md-4 mb-3 mb-md-0">
        <input type="text" placeholder="Registration No." class="form-control check-validity firstNoSpace" name="horse_registration_no" id="horse_registration_no" value="{{ !empty($ad_data) ? $ad_data->horse_registration_no : ''}}" required>
        <span class="errorMessage"></span>
      </div>
    </div>
  </div>
  <div class="form-group">
    <div class="row">
      <div class="col col-md-2 pr-md-0">
        <label for="" class="mb-md-0 mt-md-2 float-md-right text-md-right">Sire</label>
      </div>
      <div class="col col-md-4 mb-3 mb-md-0">
        <input type="text" placeholder="Sire" class="form-control" name="sire" id="sire" value="{{ !empty($ad_data) ? $ad_data->sire : ''}}">
        <span class="errorMessage"></span>
      </div>
      <div class="col col-md-2 pr-md-0">
        <label for="" class="mb-md-0 mt-md-2 float-md-right text-md-right">Dam</label>
      </div>
      <div class="col col-md-4 mb-3 mb-md-0">
        <input type="text" placeholder="Dam" class="form-control" name="dam" id="dam" value="{{ !empty($ad_data) ? $ad_data->dam : ''}}">
        <span class="errorMessage"></span>
      </div>
    </div>
  </div>
</div>
<div class="step-content">
  <div class="form-group">
    <div class="row">
      <div class="col col-md-2 pr-md-0">
        <label for="" class="mb-md-0 mt-md-2 float-md-right text-md-right">Discipline<span class="text-red">*</span></label>
      </div>
      <div class="col col-md-4 mb-3 mb-md-0">
        <div class="selectParent">
          <select name="discipline" id="discipline" class="form-control check-validity" required>
            <option value="">Select discipline</option>
            @foreach($get_all_horses_dynamicFields['horses_discipline'] as $key => $discipline)
              <option value="{{$discipline->field_id}},{{$discipline->id}}" 
                @if(!empty($horses_discipline) && $discipline->id == $horses_discipline->dynamic_field_id)
                 {{'selected'}}
                @endif>
                {{$discipline->field_value}}
              </option>
            @endforeach
          </select>
          <span class="errorMessage"></span>
        </div>
      </div>
      <div class="col col-md-2 pr-md-0">
        <label for="" class="mb-md-0 mt-md-2 float-md-right text-md-right">Temperament</label>
      </div>
      <div class="col col-md-4 mb-3 mb-md-0">
        <div class="selectParent">
          <select name="temperament" id="temperament" class="form-control">
            <option value="">Select temperament</option>
            @foreach($get_all_horses_dynamicFields['horses_temperament'] as $key => $temperament)
              <option value="{{$temperament->field_id}},{{$temperament->id}}"
                @if(!empty($horses_temperament) && $temperament->id == $horses_temperament->dynamic_field_id)
                 {{'selected'}}
                @endif>
                {{$temperament->field_value}}
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
        <label for="" class="mb-md-0 mt-md-2 float-md-right text-md-right">Breed (Primary)<span class="text-red">*</span></label>
      </div>
      <div class="col col-md-4 mb-3 mb-md-0">
        <div class="selectParent">
          <select name="breed_primary" id="breed" class="form-control check-validity" required>
            <option value="">Select breed (primary)</option>
            @foreach($get_all_horses_dynamicFields['horses_breed_primary'] as $key => $breed_primary)
              <option value="{{$breed_primary->field_id}},{{$breed_primary->id}}" 
                @if(!empty($horses_breed_primary) && $breed_primary->id == $horses_breed_primary->dynamic_field_id)
                   {{'selected'}}
                  @endif>
                {{$breed_primary->field_value}}
              </option>
            @endforeach
          </select>
          <span class="errorMessage"></span>
        </div>
      </div>
      <div class="col col-md-2 pr-md-0">
        <label for="" class="mb-md-0 mt-md-2 float-md-right text-md-right">Age</label>
      </div>
      <div class="col col-md-4 mb-3 mb-md-0">
        <div class="selectParent">
          <select name="age" id="age" class="form-control">
            <option value="">Select age</option>
            @foreach($get_all_horses_dynamicFields['horses_age'] as $key => $age)
              <option value="{{$age->field_id}},{{$age->id}}" 
                @if(!empty($horses_age) && $age->id == $horses_age->dynamic_field_id)
                  {{'selected'}}
                @endif>
                {{$age->field_value}}
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
        <label for="" class="mb-md-0 mt-md-2 float-md-right text-md-right">Breed (Secondary)</label>
      </div>
      <div class="col col-md-4 mb-3 mb-md-0">
        <div class="selectParent">
          <select name="breed_secondary" id="breedSecondary" class="form-control">
            <option value="">Select breed (secondary)</option>
            @foreach($get_all_horses_dynamicFields['horses_breed_secondary'] as $key => $breed_secondary)
              <option value="{{$breed_secondary->field_id}},{{$breed_secondary->id}}" 
                @if(!empty($horses_breed_secondary) && $breed_secondary->id == $horses_breed_secondary->dynamic_field_id)
                  {{'selected'}}
                @endif>
                {{$breed_secondary->field_value}}
              </option>
            @endforeach
          </select>
          <span class="errorMessage"></span>
        </div>
      </div>
      <div class="col col-md-2 pr-md-0">
        <label for="" class="mb-md-0 mt-md-2 float-md-right text-md-right">Rider Level</label>
      </div>
      <div class="col col-md-4 mb-3 mb-md-0">
        <div class="selectParent">
          <select name="horses_rider_Level" id="horses_rider_Level" class="form-control">
            <option value="">Select rider level</option>
            @foreach($get_all_horses_dynamicFields['horses_rider_Level'] as $key => $rider_Level)
              <option value="{{$rider_Level->field_id}},{{$rider_Level->id}}"
                @if(!empty($horses_rider_Level) && $rider_Level->id == $horses_rider_Level->dynamic_field_id)
                  {{'selected'}}
                @endif>
                {{$rider_Level->field_value}}
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
        <label for="" class="mb-md-0 mt-md-2 float-md-right text-md-right">Color</label>
      </div>
      <div class="col col-md-4 mb-3 mb-md-0">
        <div class="selectParent">
          <select name="color" id="color" class="form-control">
            <option value="">Select color</option>
            @foreach($get_all_horses_dynamicFields['horses_color'] as $key => $color)
              <option value="{{$color->field_id}},{{$color->id}}" 
                @if(!empty($horses_color) && $color->id == $horses_color->dynamic_field_id)
                  {{'selected'}}
                @endif>
                {{$color->field_value}}
              </option>
            @endforeach
          </select>
          <span class="errorMessage"></span>
        </div>
      </div>
      <div class="col col-md-2 pr-md-0">
        <label for="" class="mb-md-0 mt-md-2 float-md-right text-md-right">Height</label>
      </div>
      <div class="col col-md-4 mb-3 mb-md-0">
        <div class="selectParent">
        <select name="height" id="height" class="form-control">
          <option value="">Select height</option>
          @foreach($get_all_horses_dynamicFields['horses_height'] as $key => $height)
            <option value="{{$height->field_id}},{{$height->id}}" 
              @if(!empty($horses_height) && $height->id == $horses_height->dynamic_field_id)
                {{'selected'}}
              @endif>
              {{$height->field_value}}
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
        <label for="" class="mb-md-0 mt-md-2 float-md-right text-md-right">Gender<span class="text-red">*</span></label>
      </div>
      <div class="col col-md-4 mb-3 mb-md-0">
        <div class="selectParent">
          <select name="gender" id="gender" class="form-control check-validity" required>
            <option value="">Select gender</option>
            @foreach($get_all_horses_dynamicFields['horses_gender'] as $key => $gender)
              <option value="{{$gender->field_id}},{{$gender->id}}" 
                @if(!empty($horses_gender) && $gender->id == $horses_gender->dynamic_field_id)
                  {{'selected'}}
                @endif>
                {{$gender->field_value}}
              </option>
            @endforeach
          </select>
          <span class="errorMessage"></span>
        </div>
      </div>
    </div>
  </div>
</div>