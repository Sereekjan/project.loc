@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Profile info</div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="title" disabled value="{{$profile->name}}">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" disabled value="{{$profile->email}}">
                        </div>
                        <div class="form-group">
                            <label>Register date</label>
                            <input type="text" class="form-control" name="created_at" disabled value="{{$profile->created_at}}">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success" name="submit" form="edit_profile">Edit profile</button>
                            <a class="btn btn-danger pull-right" href="/tasks">Cancel</a>
                        </div>
                        <form method="post" action="{{ route('profile.edit') }}" id="edit_profile">
                            {{csrf_field()}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
