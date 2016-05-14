<?php

namespace App\Http\Controllers;

use App\Http\Helper;
use App\Models\Invite;
use App\Models\Task;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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

    public function invitedToken($token) {
        $invite = Invite::getInviteByToken($token);
        if (count($invite) == 0) {
            App::abort(404);
        }

        $name = $invite->email;
        $arr = explode('@', $name);
        $name = $arr[0];
        $user = new User([
            'name' => $name,
            'email' => $invite->email,
            'password' => bcrypt('qwerty'),
            'remember_token' => str_random(32)
        ]);
        $invite->is_activated = 1;
        $user->save();
        $invite->save();

        return redirect(route('tasks.index'));
    }
    
    public function profile() {
        return view('main.profile')
            ->with('profile', Auth::user());
    }
    
    public function profileEdit() {
        return view('main.profile_edit')
            ->with('profile', Auth::user());
    }

    public function profileUpdate(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect(route('profile.edit'))
                ->withErrors($validator)
                ->withInput();
        }

        if (isset($request['submit'])) {
            $user = Auth::user();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->save();
        }

        return redirect('/profile');
    }
}
