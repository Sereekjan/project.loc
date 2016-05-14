@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Edit comment</div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <input type="hidden" name="_method" value="put" form="put" />
                        <div class="form-group">
                            <label>Text</label>
                            <input type="text" class="form-control" name="text" class="form-control" value="{{ $comment->text }}" form="put">
                            <div>{{ $errors->first('text')}}</div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success" name="submit" form="put">Edit</button>
                            <a class="btn btn-danger pull-right" href="/groups">Cancel</a>
                        </div>
                        <form action="{{route('tasks.commentUpdate', $comment->id)}}" method="get" id="put">
                            {{csrf_field()}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
