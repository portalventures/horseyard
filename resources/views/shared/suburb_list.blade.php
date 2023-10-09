@if($from == 'user')
  <select name="suburb" id="suburb">
@else
  <select name="suburb" id="suburb" class="form-control checkvalidity" required>
@endif
  @foreach($suburb_list as $key => $suburb)
    <option value="{{$suburb->id}}">{{$suburb->suburb_name}}</option>
  @endforeach
</select>

@if($from == 'admin')
  <span class="errorMessage"></span>
@endif