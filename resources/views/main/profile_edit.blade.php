@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Edit profile</div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <form method="post" action="{{ route('profile.update') }}" id="update_profile">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" value="{{$profile->name}}">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" value="{{$profile->email}}">
                            </div>
                            <div class="form-group">
                                <button class="btn btn-success" name="submit">Edit profile</button>
                                <a class="btn btn-danger pull-right" href="/tasks">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
