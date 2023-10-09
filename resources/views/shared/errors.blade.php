@if (count($errors) > 0)
  <div class="col-md-12 mb-4 alert alert-danger">
    <strong>Whoops!</strong> There were problems with input:
    <ul>
        @foreach($errors->all() as $error)
          <li>{{$error}}</li>
        @endforeach
    </ul>
  </div>
@endif

@if ($message = Session::get('success'))
  <div class="mb-3 alert alert-success">
    {{ $message }}
    {{ Session::forget('success') }}
  </div>
@endif
@if ($message = Session::get('error'))
  <div class="mb-3 alert alert-danger">
    {{ $message }}
    {{ Session::forget('error') }}
  </div>
@endif
