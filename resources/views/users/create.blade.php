@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <form class="form-horizontal" action="{{ route('users.store') }}" method="POST">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">
              Users
              <small>New</small>
            </h3>
          </div>
          <div class="panel-body">
            @include('users.form')
          </div>
          <div class="panel-footer">
            <div class="row">
              <div class="col-sm-offset-3 col-sm-6">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('users.index') }}" class="btn btn-link">Cancel</a>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
