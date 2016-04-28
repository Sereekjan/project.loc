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
        @foreach($tasks as $task)
            <pre class="list-row"><h4><input type="checkbox">&nbsp;&nbsp;&nbsp;{{ $task->title }}</h4><span class="glyphicon glyphicon-trash pull-right btn-sm"></span><span class="glyphicon glyphicon-edit pull-right btn-sm"></span></pre>
        @endforeach
        <div class="nav nav-tabs span2 clearfix"></div>
        <div class="panel-body">
            <a class="btn btn-success btn-lg" href=" {{ route('tasks.create') }} ">Add task</a>
            <a class="btn btn-danger btn-lg pull-right" href="#">Remove</a>
        </div>
    </div>
@endsection
