<div class="row form-group-static">
  <div class="col-sm-3 control-label-static">Username</div>
  <div class="col-sm-6 col-md-4">
    <div class="form-control-static">
      {{ '@'.$user->username }}
    </div>
  </div>
</div>

<div class="row form-group-static">
  <div class="col-sm-3 control-label-static">Name</div>
  <div class="col-sm-6">
    <div class="form-control-static">
      {{ $user->name }}
    </div>
  </div>
</div>

<div class="row form-group-static">
  <div class="col-sm-3 control-label-static">Email</div>
  <div class="col-sm-6">
    <div class="form-control-static">
      {{ $user->email }}
    </div>
  </div>
</div>