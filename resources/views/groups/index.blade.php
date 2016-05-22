@extends('layouts.app')

@section('content')
    <div class="panel panel-body list-head">
        <h3>GROUPS LIST</h3>
        @if(count($groups) == 0)
            <div class="row text-center"><h4>You are haven't any group</h4></div>
        @endif
        @foreach($groups as $group)
            <pre class="list-row"><form method="post" action="/groups/1"><h4><input type="checkbox" @if($group->privilege_id == 2) disabled @endif name="deleting[]" value="{{$group->group_id}}" form="delete">&nbsp;&nbsp;&nbsp;<a href="{{ route('groups.show', $group->group_id) }}">{{ $group->name }}</a></h4>{{csrf_field()}}@if($group->privilege_id != 2)<button class="btn glyphicon glyphicon-trash pull-right btn-sm" name="submit"></button><input type="hidden" name="deleting" value="{{$group->group_id}}"><a class="btn glyphicon glyphicon-edit pull-right btn-sm" href="{{ route('groups.edit', $group->group_id) }}"></a>@endif</form></pre>
        @endforeach
        <div class="col-md-12">
            {!! $groups->links() !!}
        </div>
        <div class="nav nav-tabs span2 clearfix"></div>
        <div class="panel-body">
            <a class="btn btn-success btn-lg" href=" {{ route('groups.create') }} ">Add group</a>
            <button class="btn btn-danger btn-lg pull-right" name="submit" form="delete">Remove</button>
        </div>
    </div>
    <form action="/groups/1" method="post" id="delete">
        {{csrf_field()}}
    </form>
@endsection
