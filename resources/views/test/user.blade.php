@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <p>
        User: <strong>{{ $user->name }}</strong>
        <br>
        Place of Birth: <strong>{{ $user->place_of_birth }}</strong>
        Date of Birth: <strong>{{ $user->date_of_birth }}</strong>
        Instruments: <strong>{{ implode(', ', $user->instruments_display) }}</strong>
      </p>
      
      <p>
        Direct Member of Groups:
      </p> 
      
      <ul>
        @foreach($user->inGroups as $inGroup)
        <li>
          <a href="{{ route('test.group', $inGroup) }}">{{ $inGroup->name }}</a>
        </li>
        @endforeach
      </ul>
      
      <p>
        Member of All Groups:
      </p>
      
      <ul>
        @foreach($user->inAllGroups as $inGroup)
        <li>
          <a href="{{ route('test.group', $inGroup) }}">{{ $inGroup->name }}</a> 
          @if($inGroup->indirect) (via <a href="{{ route('test.group', $inGroup->indirect) }}">{{ $inGroup->indirect->name }}</a>) @endif
        </li>
        @endforeach
      </ul>
      
      <hr>
     
      
      <p>
        Custom Fields for Users
      </p>
      
      <form class="form-horizontal">
        @foreach ($user->getCustomFields() as $field)
          {!! $field->getView($user) !!}
        @endforeach
      </form> 
      
      <p>
        Custom Fields for this User
      </p>
      {{--
      <ul>
        @foreach ($user->customValues as $value)
        <li>
          {{ $value->name }}:
          
          @if($value->is_multiple)
          {{ implode(', ', $value->display_value) }}
          @if($value->display_default) ({{ implode(', ', $value->display_default) }}) @endif
          @else
          {{ $value->display_value }}
          @if($value->display_default) ({{ $value->display_default }}) @endif
          @endif
          
        </li>
        @endforeach
      </ul>
      --}}
    </div>
  </div>
</div>
@endsection
