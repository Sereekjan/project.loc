@extends('layouts.app')

@section('content')
    <div class="panel panel-body list-head">
        <h3>{{$group->name}}</h3>
        @if(count($tasks) == 0)
            <div class="row text-center"><h4>Nothing to do</h4></div>
        @endif
        @foreach($tasks as $task)
            <pre class="list-row"><form method="post" action="/tasks/1"><h4><input type="checkbox" name="deleting[]" value="{{$task->id}}" form="delete">&nbsp;&nbsp;&nbsp;<a href="/tasks/{{$task->id}}">{{ $task->title }}</a></h4>{{csrf_field()}}<button class="btn glyphicon glyphicon-trash pull-right btn-sm" name="submit"></button><input type="hidden" name="deleting" value="{{$task->id}}"><a class="btn glyphicon glyphicon-edit pull-right btn-sm" href="{{ route('tasks.edit', $task->id) }}"></a></form></pre>
        @endforeach
        <div class="col-md-12">
            {!! $tasks->links() !!}
        </div>
        <div class="nav nav-tabs span2 clearfix"></div>
        <div class="panel-body">
            <a class="btn btn-success btn-lg" href=" {{ route('tasks.create') }} ">Add task</a>
            <button class="btn btn-danger btn-lg pull-right" name="submit" form="delete">Remove</button>
        </div>

        <h3>MEMBERS LIST</h3>
        @foreach($users as $user)
            <pre class="list-row"><form method="post" action="{{route('groups.membersDelete', $group->id)}}"><h4><input type="checkbox" name="deleting[]" value="{{$user->id}}" form="delete">&nbsp;&nbsp;&nbsp;{{ $user->name.'('.$user->email.')' }}</h4>{{csrf_field()}}<button class="btn glyphicon glyphicon-trash pull-right btn-sm" name="submit"></button><input type="hidden" name="deleting" value="{{$user->id}}"></form></pre>
        @endforeach
        <div class="col-md-12">
            {!! $users->links() !!}
        </div>
        <div class="nav nav-tabs span2 clearfix"></div>
        <div class="panel-body">
            <a class="btn btn-success btn-lg" href=" {{ route('groups.memberAddForm', $group->id) }} ">Add member</a>
            <button class="btn btn-danger btn-lg pull-right" name="submit" form="delete">Remove</button>
        </div>
        <form action="/{{$group->id}}/delete" method="post" id="delete">
            {{csrf_field()}}
        </form>
    </div>
@endsection
