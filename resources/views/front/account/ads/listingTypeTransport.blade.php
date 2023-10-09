<div class="step-content">
  <div class="form-group">
    <div class="row">
      <div class="col col-md-2 pr-md-0">
        <label for="" class="mb-md-0 mt-md-2 float-md-right text-md-right">Make</label>
      </div>
      <div class="col col-md-4 mb-3 mb-md-0">
        <input type="text" placeholder="Name" class="form-control" name="make" id="make" value="{{ !empty($ad_data) ? $ad_data->make : ''}}">
        <span class="errorMessage"></span>
      </div>
      <div class="col col-md-2 pr-md-0">
        <label for="" class="mb-md-0 mt-md-2 float-md-right text-md-right">Model</label>
      </div>
      <div class="col col-md-4 mb-3 mb-md-0">
        <input type="text" placeholder="Registration No." class="form-control" name="transport_model" id="transport_model" value="{{ !empty($ad_data) ? $ad_data->transport_model : ''}}">
        <span class="errorMessage"></span>
      </div>
    </div>
  </div>
  <div class="form-group">
    <div class="row">
      <div class="col col-md-2 pr-md-0">
        <label for="" class="mb-md-0 mt-md-2 float-md-right text-md-right">Year</label>
      </div>
      <div class="col col-md-4 mb-3 mb-md-0">
        <input type="text" placeholder="2002" class="form-control" name="year" id="year" value="{{ !empty($ad_data) ? $ad_data->year : ''}}">
        <span class="errorMessage"></span>
      </div>
      <div class="col col-md-2 pr-md-0">
        <label for="" class="mb-md-0 mt-md-2 float-md-right text-md-right">KMS</label>
      </div>
      <div class="col col-md-4 mb-3 mb-md-0">
        <input type="text" placeholder="10000" class="form-control" name="kms" id="kms" value="{{ !empty($ad_data) ? $ad_data->kms : ''}}">
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
        <select name="transport_type" id="transport_type" class="form-control check-validity" required name="transport_type" id="transport_type">
          <option value="">Select type</option>
          @foreach($get_all_horses_dynamicFields['transport_type'] as $key => $type)
            <option value="{{$type->field_id}},{{$type->id}}" 
              @if(!empty($transport_type) && $type->id == $transport_type->dynamic_field_id)
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
        <label for="" class="mb-md-0 mt-md-2 float-md-right text-md-right">Axles</label>
      </div>
      <div class="col col-md-4 mb-3 mb-md-0">
        <div class="selectParent">
        <select name="axles" id="axles" class="form-control">
          <option value="">Select axles</option>
          @foreach($get_all_horses_dynamicFields['transport_axles'] as $key => $axles)
            <option value="{{$axles->field_id}},{{$axles->id}}" 
              @if(!empty($transport_axles) && $axles->id == $transport_axles->dynamic_field_id)
                {{'selected'}}
              @endif>
              {{$axles->field_value}}
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
        <label for="" class="mb-md-0 mt-md-2 float-md-right text-md-right text-transform-none">No. of Horses to carry<span class="text-red">*</span></label>
      </div>
      <div class="col col-md-4 mb-3 mb-md-0">
        <div class="selectParent">
          <select name="transport_no_of_horse_to_carry" id="transport_no_of_horse_to_carry" class="form-control check-validity" required>
            <option value="">Select no. of horses to carry</option>
            @foreach($get_all_horses_dynamicFields['transport_no_of_horse_to_carry'] as $key => $no_of_horse_to_carry)
              <option value="{{$no_of_horse_to_carry->field_id}},{{$no_of_horse_to_carry->id}}" @if(!empty($transport_no_of_horse_to_carry) && $no_of_horse_to_carry->id == $transport_no_of_horse_to_carry->dynamic_field_id)
               {{'selected'}}
              @endif>
              {{$no_of_horse_to_carry->field_value}}
            </option>
            @endforeach
          </select>
          <span class="errorMessage"></span>
        </div>
      </div>
      <div class="col col-md-2 pr-md-0">
        <label for="" class="mb-md-0 mt-md-2 float-md-right text-md-right text-transform-none">Registration state</label>
      </div>
      <div class="col col-md-4 mb-3 mb-md-0">
        <div class="selectParent">
          <select name="transport_registration_state" id="transport_registration_state" class="form-control">
            <option value="">Select registration state</option>
            @foreach($get_all_horses_dynamicFields['transport_registration_state'] as $key => $registration_state)
              <option value="{{$registration_state->field_id}},{{$registration_state->id}}" 
                @if(!empty($transport_registration_state) && $registration_state->id == $transport_registration_state->dynamic_field_id)
                  {{'selected'}}
                @endif>
              {{$registration_state->field_value}}
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
        <label for="" class="mb-md-0 mt-md-2 float-md-right text-md-right text-transform-none">Ramp Location<span class="text-red">*</span></label>
      </div>
      <div class="col col-md-4 mb-3 mb-md-0">
        <div class="selectParent">
          <select name="transport_ramp_location" id="transport_ramp_location" class="form-control check-validity" required>
            <option value="">Select ramp location</option>
            @foreach($get_all_horses_dynamicFields['transport_ramp_location'] as $key => $ramp_location)
              <option value="{{$ramp_location->field_id}},{{$ramp_location->id}}" 
                @if(!empty($transport_ramp_location) && $ramp_location->id == $transport_ramp_location->dynamic_field_id)
                  {{'selected'}}
                @endif>
                {{$ramp_location->field_value}}
              </option>
            @endforeach
          </select>
          <span class="errorMessage"></span>
        </div>
      </div>
      <div class="col col-md-2 pr-md-0">
        <label for="" class="mb-md-0 mt-md-2 float-md-right text-md-right text-transform-none">Vehicle registration number</label>
      </div>
      <div class="col col-md-4 mb-3 mb-md-0">
        <input type="text" placeholder="Vehicle registration number" class="form-control" name="vehicle_registration_number" id="vehicle_registration_number" value="{{ !empty($ad_data) ? $ad_data->vehicle_registration_number : ''}}">
        <span class="errorMessage"></span>
      </div>
    </div>
  </div>
</div>