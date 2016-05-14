@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Add member</div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <form action="{{route('groups.memberAdd', $group_id)}}" method="post">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label>User's email</label>
                                <input type="email" class="form-control" name="email" class="form-control" value="{{old('email')}}">
                                <div>{{ $errors->first('email')}}</div>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-success" name="submit">Add member</button>
                                <a class="btn btn-danger pull-right" href="/groups">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
