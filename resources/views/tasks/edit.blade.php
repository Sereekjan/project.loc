@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Edit task</div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <form action="/tasks/{{$task->id}}" method="post" id="put">
                            {{csrf_field()}}
                            <input type="hidden" name="_method" value="put" form="put" />
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control" name="title" class="form-control" value="{{$task->title}}">
                                <div>{{ $errors->first('title')}}</div>
                            </div>
                            <div class="form-group">
                                <label>Text</label>
                                <textarea name="text" class="form-control">{{$task->text}}</textarea>
                                <div>{{ $errors->first('text') }}</div>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                {!! \App\Http\Helper::select($priorities, $task->priority_id, "Выберите важность", ['class' => 'form-control', 'name' => 'status']) !!}
                                <div>{{ $errors->first('status') }}</div>
                            </div>
                            <div class="form-group">
                                <label>Date End</label>
                                <input type="datetime" name="time" class="form-control" value="{{$task->time}}">
                                <div>{{ $errors->first('time') }}</div>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-success" name="submit">Edit</button>
                                <a class="btn btn-danger pull-right" href="/tasks">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
