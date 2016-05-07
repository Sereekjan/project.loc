@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Add task</div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <form action="{{route('tasks.store')}}" method="post">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control" name="title" class="form-control" value="{{old('title')}}">
                                <div>{{ $errors->first('title')}}</div>
                            </div>
                            <div class="form-group">
                                <label>Text</label>
                                <textarea name="text" class="form-control">{{old('text')}}</textarea>
                                <div>{{ $errors->first('text') }}</div>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                {!! \App\Http\Helper::select($priorities, old('status'), "Выберите важность", ['class' => 'form-control', 'name' => 'status']) !!}
                                <div>{{ $errors->first('status') }}</div>
                            </div>
                            <div class="form-group">
                                <label>Date End</label>
                                <input type="datetime" name="time" class="form-control" value="{{old('time')}}">
                                <div>{{ $errors->first('time') }}</div>
                            </div>
                            <div class="form-group">
                                <label>For</label>
                                <select class="form-control" name="for" onchange="fillName(this.value, '{{$user->name}}')">
                                    <option>For</option>
                                    <option value="1">Myself</option>
                                    <option value="2">Someone</option>
                                    <option value="3">Group</option>
                                </select>
                                <div>{{ $errors->first('for') }}</div>
                            </div>
                            <div class="form-group">
                                <label id="name_label">Name</label>
                                <input type="text" class="form-control" name="name" id="name">
                                <div>{{ $errors->first('name') }}</div>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-success" name="submit">Add task</button>
                                <a class="btn btn-danger pull-right" href="/tasks">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
