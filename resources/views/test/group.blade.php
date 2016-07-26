@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <p>
        Group: <strong>{{ $group->name }}</strong>
      </p>
      
      <p>
        Direct Member Users:
      </p>
      
      <ul>
        @foreach($group->memberUsers as $member)
        <li><a href="{{ route('test.user', $member) }}">{{ $member->name }}</a></li>
        @endforeach
      </ul>
      
      <p>
        Direct Member Groups:
      </p>
      
      <ul>
        @foreach($group->memberGroups as $member)
        <li>
          <a href="{{ route('test.group', $member) }}">{{ $member->name }}</a>
        </li>
        @endforeach
      </ul>
      
      <p>
        All Direct Members:
      </p>
      
      <ul>
        @foreach($group->members as $member)
        <li>
        @if(get_class($member) == 'Sphere\User')
        <a href="{{ route('test.user', $member) }}">{{ $member->name }}</a> (User)
        @else
        <a href="{{ route('test.group', $member) }}">{{ $member->name }}</a> (Group)
        @endif
        </li>
        @endforeach
      </ul>    
      <p>
        All Member Users:
      </p>
      
      <ul>
        @foreach($group->allMemberUsers as $member)
        <li>
          <a href="{{ route('test.user', $member) }}">{{ $member->name }}</a> 
          @if($member->indirect) (via <a href="{{ route('test.group', $member->indirect) }}">{{ $member->indirect->name }}</a>) @endif
        </li>
        @endforeach
      </ul>
      
       <p>
        All Member Groups:
      </p>
      
      <ul>
        @foreach($group->allMemberGroups as $member)
        <li>
          <a href="{{ route('test.group', $member) }}">{{ $member->name }}</a> 
          @if($member->indirect) (via <a href="{{ route('test.group', $member->indirect) }}">{{ $member->indirect->name }}</a>) @endif
        </li>
        @endforeach
      </ul>
      
      <p>
        All Members:
      </p>
      
      <ul>
        @foreach($group->allMembers as $member)
        
        <li>
        @if(get_class($member) == 'Sphere\User')
        <a href="{{ route('test.user', $member) }}">{{ $member->name }}</a> (User)
        @else
        <a href="{{ route('test.group', $member) }}">{{ $member->name }}</a> (Group)
        @endif
        
        @if($member->indirect) (via <a href="{{ route('test.group', $member->indirect) }}">{{ $member->indirect->name }}</a>) @endif
        </li>
          
        @endforeach
      </ul>
      
      <p>
        Direct Member of Groups:
      </p>
      
      <ul>
        @foreach($group->inGroups as $inGroup)
        <li><a href="{{ route('test.group', $inGroup) }}">{{ $inGroup->name }}</a></li>
        @endforeach
      </ul>
      
      <p>
        Member of All Groups:
      </p>
      
      <ul>
        @foreach($group->inAllGroups as $inGroup)
        <li>
          <a href="{{ route('test.group', $inGroup) }}">{{ $inGroup->name }}</a> 
          @if($inGroup->indirect) (via <a href="{{ route('test.group', $inGroup->indirect) }}">{{ $inGroup->indirect->name }}</a>) @endif
        </li>
        @endforeach
      </ul>
      
      <p>
        <?php $child = Sphere\Group::find(55); ?>
        <?php $parent = Sphere\Group::find(42); ?>
        Can <strong>{{ $parent->name }}</strong> be parent of <strong>{{ $child->name }}</strong>?  {{ $child->canBeParent($parent) ? 'Y' : 'N' }} {{ $parent->canBeChild($child) ? 'Y' : 'N' }}
      </p>
      <p>
        Can <strong>{{ $child->name }}</strong> be parent of <strong>{{ $parent->name }}</strong>?  {{ $parent->canBeParent($child) ? 'Y' : 'N' }} {{ $child->canBeChild($parent) ? 'Y' : 'N' }}
      </p>
      
    </div>
  </div>
</div>
@endsection
