@extends('layouts.app')

@section('left-sidebar')
    <div class="col-md-3 panel panel-body sidebar">
        <ul class="nav nav-pills nav-stacked left-sidebar">
            <li class="header text">
                <h3>This week</h3>
            </li>
            <li>
                <a href="#">Monday<span class="badge right-circle">
                        {{\App\Http\Helper::getTasksCountByDay(\App\Http\Helper::getMonday())}}
                </span></a>
            </li>
            <li>
                <a href="#">Tuesday<span class="badge right-circle">
                        {{\App\Http\Helper::getTasksCountByDay(\App\Http\Helper::getTuesday())}}
                </span></a>
            </li>
            <li>
                <a href="#">Wednesday<span class="badge right-circle">
                        {{\App\Http\Helper::getTasksCountByDay(\App\Http\Helper::getWednesday())}}
                </span></a>
            </li>
            <li>
                <a href="#">Thirsday<span class="badge right-circle">
                        {{\App\Http\Helper::getTasksCountByDay(\App\Http\Helper::getThirsday())}}
                </span></a>
            </li>
            <li>
                <a href="#">Friday<span class="badge right-circle">
                        {{\App\Http\Helper::getTasksCountByDay(\App\Http\Helper::getFriday())}}
                </span></a>
            </li>
            <li>
                <a href="#">Saturday<span class="badge right-circle">
                        {{\App\Http\Helper::getTasksCountByDay(\App\Http\Helper::getSaturday())}}
                </span></a>
            </li>
            <li>
                <a href="#">Sunday<span class="badge right-circle">
                        {{\App\Http\Helper::getTasksCountByDay(\App\Http\Helper::getSunday())}}
                </span></a>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="panel panel-body list-head">
        <h3>Calendar</h3>
        <div class="panel-body">
            <h3 class="text-center">{{$month}}</h3>
            <table class="table" width="100%" cellpadding="5">
                <tr>
                    <th>Monday</th>
                    <th>Tuesday</th>
                    <th>Wednesday</th>
                    <th>Thirsday</th>
                    <th>Friday</th>
                    <th>Saturday</th>
                    <th>Sunday</th>
                </tr>
                <tr>
                @for($i = 0; $i < count($days); $i++)
                    @if($i%7 == 0 && $i != 0)
                </tr>
                <tr>
                    @endif
                    <td><a href="calendar/{{$days[$i][1]}}">{{$days[$i][0]}}</a></td>
                @endfor
                </tr>
            </table>
        </div>
    </div>
@endsection
