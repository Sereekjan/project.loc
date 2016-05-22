@extends('layouts.app')

@section('content')
    <div class="panel panel-body list-head">
        <h3>{{$group->name}}</h3>
        @if(count($tasks) == 0)
            <div class="row text-center"><h4>Nothing to do</h4></div>
        @endif
        @foreach($tasks as $task)
            <pre class="list-row"><form method="post" action="/tasks/1"><h4><input type="checkbox" @if($task->creator_id != \Illuminate\Support\Facades\Auth::user()->id)) disabled @endif name="deleting[]" value="{{$task->task_id}}" form="delete">&nbsp;&nbsp;&nbsp;<a href="/tasks/{{$task->task_id}}">{{ $task->title }}</a></h4>{{csrf_field()}}@if($task->creator_id == \Illuminate\Support\Facades\Auth::user()->id)<button class="btn glyphicon glyphicon-trash pull-right btn-sm" name="submit"></button><input type="hidden" name="deleting" value="{{$task->task_id}}"><a class="btn glyphicon glyphicon-edit pull-right btn-sm" href="{{ route('tasks.edit', $task->task_id) }}"></a>@endif</form></pre>
        @endforeach
        <div class="col-md-12">
            {!! $tasks->links() !!}
        </div>
        <div class="nav nav-tabs span2 clearfix"></div>
        <div class="panel-body">
            @if($group->privilege_id != 2)
                <a class="btn btn-success btn-lg" href=" {{ route('tasks.create') }} ">Add task</a>
                <button class="btn btn-danger btn-lg pull-right" name="submit" form="delete">Remove</button>
            @endif
        </div>
        <h3>MEMBERS LIST</h3>
        @foreach($users as $user)
            <pre class="list-row"><form method="post" action="{{route('groups.membersDelete', $group->group_id)}}"><h4><input type="checkbox" @if($group->privilege_id == 2  || $user->privilege_id == 3 || ($group->privilege_id == 1 && $user->privilege_id == 1) || $group->user_id == $user->user_id) disabled @endif name="deleting[]" value="{{$user->id}}" form="delete">&nbsp;&nbsp;&nbsp;{{ $user->name.'('.$user->email.')' }}</h4>{{csrf_field()}}@if(($group->privilege_id == 3 && $user->privilege_id != 3) || ($group->privilege_id == 1 && $user->privilege_id == 2))<button class="btn glyphicon glyphicon-trash pull-right btn-sm" name="submit"></button><input type="hidden" name="deleting" value="{{$user->id}}">@endif</form></pre>
        @endforeach
        <div class="col-md-12">
            {!! $users->links() !!}
        </div>
        <div class="nav nav-tabs span2 clearfix"></div>
        <div class="panel-body">
            @if($group->privilege_id != 2)
                <a class="btn btn-success btn-lg" href=" {{ route('groups.memberAddForm', $group->group_id) }} ">Add member</a>
                <button class="btn btn-danger btn-lg pull-right" name="submit" form="delete">Remove</button>
            @endif
                <a class="btn btn-warning btn-lg pull-right" href=" {{ route('groups.leave', $group->group_id) }} ">Leave group</a>
        </div>
        <form action="/groups/{{$group->group_id}}/delete" method="post" id="delete">
            {{csrf_field()}}
        </form>
    </div>
@endsection
