@extends('layouts.app')

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
