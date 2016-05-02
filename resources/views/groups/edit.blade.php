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
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Edit group</div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <input type="hidden" name="_method" value="put" form="put" />
                        <div class="form-group">
                            <label>Group name</label>
                            <input type="text" class="form-control" name="name" class="form-control" value="{{ $group->name }}" form="put">
                            <div>{{ $errors->first('name')}}</div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success" name="submit" form="put">Edit</button>
                            <a class="btn btn-danger pull-right" href="/groups">Cancel</a>
                        </div>
                        <form action="/groups/{{$group->id}}" method="post" id="put">
                            {{csrf_field()}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
