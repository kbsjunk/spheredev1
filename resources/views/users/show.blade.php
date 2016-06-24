@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">
              Users
              <small>{{ '@'.$user->username }}</small>
            </h3>
          </div>
          <div class="panel-body">
          @include('users.static')
          </div>
          <div class="panel-footer">
            <div class="row">
              <div class="col-sm-offset-3 col-sm-6">
                <a href="{{ route('users.edit', $user) }}" class="btn btn-default">Edit</a>
                <a href="{{ route('users.index') }}" class="btn btn-link">Cancel</a>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
</div>
@endsection
