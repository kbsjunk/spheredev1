{{ csrf_field() }}

<div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
  <label for="username" class="col-sm-3 control-label">Username</label>
  <div class="col-sm-6 col-md-4">
    <input type="text" class="form-control" id="username" placeholder="Username" name="username" value="{{ old('username', $user->username) }}">
    @if ($errors->has('username'))
    <span class="help-block">
      <strong>{{ $errors->first('username') }}</strong>
    </span>
    @endif
  </div>
</div>

<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
  <label for="name" class="col-sm-3 control-label">Name</label>
  <div class="col-sm-6">
    <input type="text" class="form-control" id="name" placeholder="Name" name="name" value="{{ old('name', $user->name) }}">
    @if ($errors->has('name'))
    <span class="help-block">
      <strong>{{ $errors->first('name') }}</strong>
    </span>
    @endif
  </div>
</div>

<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
  <label for="email" class="col-sm-3 control-label">Email</label>
  <div class="col-sm-6">
    <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="{{ old('email', $user->email) }}">
    @if ($errors->has('email'))
    <span class="help-block">
      <strong>{{ $errors->first('email') }}</strong>
    </span>
    @endif
  </div>
</div>