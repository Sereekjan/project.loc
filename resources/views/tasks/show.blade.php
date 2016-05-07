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
        </div>
    </div>

@endsection
