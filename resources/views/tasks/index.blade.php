@extends('layouts.app')

@section('content')
    <div class="panel panel-body list-head">
        <h3>TASKS LIST</h3>
        @if(count($tasks) == 0)
            <div class="row text-center"><h4>Nothing to do</h4></div>
        @endif
        @foreach($tasks as $task)
            <pre class="list-row"><form method="post" action="/tasks/1"><h4><input type="checkbox" name="deleting[]" @if(($task->user_id != $task->creator_id) && $task->creator_id != \Illuminate\Support\Facades\Auth::user()->id) disabled @endif value="{{$task->task_id}}" form="delete">&nbsp;&nbsp;&nbsp;<a href="/tasks/{{$task->task_id}}">{{ $task->title }}</a></h4>{{csrf_field()}}@if($task->user_id == $task->creator_id || $task->creator_id == \Illuminate\Support\Facades\Auth::user()->id)<button class="btn glyphicon glyphicon-trash pull-right btn-sm" name="submit"></button><input type="hidden" name="deleting" value="{{$task->task_id}}"><a class="btn glyphicon glyphicon-edit pull-right btn-sm" href="{{ route('tasks.edit', $task->task_id) }}"></a>@endif</form></pre>
        @endforeach
        <div class="col-md-12">
            {!! $tasks->links() !!}
        </div>
        <div class="nav nav-tabs span2 clearfix"></div>
        <div class="panel-body">
            <a class="btn btn-success btn-lg" href=" {{ route('tasks.create') }} ">Add task</a>
            <button class="btn btn-danger btn-lg pull-right" name="submit" form="delete">Remove</button>
        </div>
    </div>
    <form action="/tasks/1" method="post" id="delete">
        {{csrf_field()}}
    </form>
@endsection
