<?php

namespace App\Http\Controllers;

use App\Http\Helper;
use App\Models\Task;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function calendar() {
        return view('main.calendar')
            ->with('days', Helper::getCalendarDays())
            ->with('month', Helper::getMonth());
    }
    
    public function day($date){
        return view('main.day')
            ->with('tasks', Task::getTasksByUserIdAndDate(Auth::user()->id, $date));
    }
}
