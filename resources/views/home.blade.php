@extends('layouts.app')

@section('left-sidebar')
    <div class="col-md-3 panel panel-body sidebar">
        <ul class="nav nav-pills nav-stacked left-sidebar">
            <li class="header text">
                <h3>This week</h3>
            </li>
            <li>
                <a href="#">Monday<span class="badge right-circle">3</span></a>
            </li>
            <li>
                <a href="#">Tuesday<span class="badge right-circle">3</span></a>
            </li>
            <li>
                <a href="#">Wednesday<span class="badge right-circle">3</span></a>
            </li>
            <li>
                <a href="#">Thirsday<span class="badge right-circle">3</span></a>
            </li>
            <li>
                <a href="#">Friday<span class="badge right-circle">3</span></a>
            </li>
            <li>
                <a href="#">Saturday<span class="badge right-circle">3</span></a>
            </li>
            <li>
                <a href="#">Sunday<span class="badge right-circle">3</span></a>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="panel panel-body list-head">
        <h3>List</h3>
        @if(count($tasks) == 0)
            <div class="row text-center"><h4>Nothing to do</h4></div>
        @endif
        @foreach($tasks as $task)
            <pre class="list-row"><form method="post" action="/tasks/1"><h4><input type="checkbox" name="deleting[]" value="{{$task->id}}" form="delete">&nbsp;&nbsp;&nbsp;{{ $task->title }}</h4>{{csrf_field()}}<button class="btn glyphicon glyphicon-trash pull-right btn-sm" name="submit"></button><input type="hidden" name="deleting" value="{{$task->id}}"><a class="btn glyphicon glyphicon-edit pull-right btn-sm" href="{{ route('tasks.edit', $task->id) }}"></a></form></pre>
        @endforeach
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
