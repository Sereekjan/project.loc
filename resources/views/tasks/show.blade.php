@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Task info</div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" name="title" disabled value="{{$task->title}}">
                        </div>
                        <div class="form-group">
                            <label>Text</label>
                            <textarea name="text" class="form-control" disabled>{{$task->text}}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            {!! \App\Http\Helper::select($priorities, $task->priority_id, "Выберите важность", ['class' => 'form-control', 'name' => 'status', 'disabled' => 'disabled']) !!}
                        </div>
                        <div class="form-group">
                            <label>Time End</label>
                            <input type="datetime" name="time" class="form-control" disabled value="{{$task->time}}">
                        </div>
                        <div class="form-group">
                            <label>For</label>
                            <input type="text" name="for" class="form-control" disabled value="{{
                            (count($task->getUser()) != 0) ? $task->getUser()->email : $task->getGroup()->name
                            }}">
                        </div>
                        <div class="form-group">
                            <a class="btn btn-success" href=" {{ route('tasks.edit', $task->id) }} " name="submit">Edit task</a>
                            <a class="btn btn-danger pull-right" href="/tasks">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
            @foreach($comments as $comment)
            <form method="get" action="{{route('tasks.commentDelete', $comment->id)}}">
                {{csrf_field()}}
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="visible-md-inline">{{Auth::user()->name}}</h4>
                        <div class="btn-group pull-right" style="top:-5px;">
                            <input type="hidden" name="deleting" value="{{$comment->id}}">
                            <a class="btn glyphicon glyphicon-edit btn-default btn-sm" href="{{ route('tasks.commentEdit', $comment->id) }}"></a>
                            <button class="btn glyphicon glyphicon-trash btn-sm btn-default" name="submit"></button>
                        </div>
                    </div>
                    <div class="panel-body">{{$comment->text}}
                    </div>
                </div>
            </form>
            @endforeach
            <form action="{{route('tasks.commentAdd', $task->id)}}" method="post">
                {{csrf_field()}}
                <div class="panel panel-default">
                    <div class="panel-heading">New comment</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label>Text</label>
                            <textarea name="text" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success" name="submit">Add comment</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
