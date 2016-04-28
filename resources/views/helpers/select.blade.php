<select
@foreach($attrs as $key => $value)
    {!! $key."='$value'" !!}
        @endforeach
        >
    @if($first_option)
        <option value="">{{$first_option}}</option>
    @endif
    @foreach($options as $option)
        @if($selected == $option['id'])
            <option value="{{$option['id']}}" selected>{{$option['name']}}</option>
        @else
            <option value="{{$option['id']}}">{{$option['name']}}</option>
        @endif
    @endforeach
</select>