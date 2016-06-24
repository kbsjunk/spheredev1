@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">
              Users
            </h3>
            <a href="{{ route('users.create') }}" class="btn btn-primary pull-right btn-round"><i class="mdi mdi-plus"></i></a>
          </div>
          <table class="table">
            <thead>
              <tr>
                <th>
                  User
                </th>
              </tr>
            </thead>
            <tbody>
              @foreach ($users as $user)
              <tr>
                <td>
                  <a href="{{ route('users.show', $user) }}">{{ $user->name }}</a><br>
                  <small class="text-muted">{{ '@'.$user->username }}</small>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <div class="panel-footer">
            {{ $users->appends(['per_page' => $users->perPage()])->links() }}
          </div>
        </div>
    </div>
  </div>
</div>
@endsection
