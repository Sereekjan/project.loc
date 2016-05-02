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
        <h3>GROUP LIST</h3>
        @foreach($groups as $group)
            <pre class="list-row"><form method="post" action="/groups/1"><h4><input type="checkbox" name="deleting[]" value="{{$group->id}}" form="delete">&nbsp;&nbsp;&nbsp;{{ $group->name }}</h4>{{csrf_field()}}<button class="btn glyphicon glyphicon-trash pull-right btn-sm" name="submit"></button><input type="hidden" name="deleting" value="{{$group->id}}"><a class="btn glyphicon glyphicon-edit pull-right btn-sm" href="{{ route('groups.edit', $group->id) }}"></a></form></pre>
        @endforeach
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
