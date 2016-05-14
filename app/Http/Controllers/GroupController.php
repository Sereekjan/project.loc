<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Invite;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('groups.index')
            ->with('groups', Auth::user()->getGroups());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Group $group)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:20'
        ]);

        if ($validator->fails()) {
            return redirect(route('groups.create'))
                ->withErrors($validator)
                ->withInput();
        }

        $group->name = $request->input('name');
        $group->save();

        $user = Auth::user();
        $user = $group->members()->attach(1, [
            'user_id' => $user->id,
            'privilege_id' => 1
        ]);

        return redirect(route('groups.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('groups.show')
            ->with('group', Group::find($id))
            ->with('tasks', Group::find($id)->getTasks())
            ->with('users', Group::find($id)->getUsers());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('groups.edit')
            ->with('group', Group::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:20'
        ]);

        if ($validator->fails()) {
            return redirect(route('groups.edit', $id))
                ->withErrors($validator)
                ->withInput();
        }

        $group = Group::find($id);
        $group->name = $request->input('name');
        $group->save();

        return redirect(route('groups.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        dd('YEAH');
        //self::find($id)->delete();
    }

    public function delete($id, Request $request) {
        $validator = Validator::make($request->all(), [
            'deleting' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect($_SERVER['HTTP_REFERER'])
                ->withErrors($validator)
                ->withInput();
        }

        if (isset($request['submit'])) {
            if (is_array($request['deleting'])) {
                foreach ($request['deleting'] as $_id) {
                    $group = Group::find($_id);
                    $group->delete();
                }
            } else {
                $group = Group::find($request['deleting']);
                $group->delete();
            }
        }

        return redirect(route('groups.index'));
    }
    
    public function deleteMembers($group_id, Request $request) {
        $validator = Validator::make($request->all(), [
            'deleting' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect($_SERVER['HTTP_REFERER'])
                ->withErrors($validator)
                ->withInput();
        }

        if (isset($request['submit'])) {
            if (is_array($request['deleting'])) {
                foreach ($request['deleting'] as $_id) {
                    $group = Group::find($group_id);
                    dd($group->members->where('user_id', '=', $$_id));
                    $group->members()->detach($_id);
                }
            } else {
                $group = Group::find($group_id);
                $group->members()->detach($request['deleting']);
            }
        }

        return redirect(route('groups.index'));
    }

    public function memberAddForm($group_id) {
        return view('groups.member_add')
            ->with('group_id', $group_id);
    }

    public function memberAdd($group_id, Request $request) {
        $arr = [];
        for($i = 0; $i < count(User::getEmails()); $i++) {
            $arr[] = User::getEmails()[$i]->email;
        }
        $arr = implode(',', $arr);
        $validator = Validator::make($request->all(), [
            'email' => 'required|not_in:'.$arr
        ]);
        dd($validator->fails());
        if ($validator->fails()) {
            return redirect($_SERVER['HTTP_REFERER'])
                ->withErrors($validator)
                ->withInput();
        }

        if (isset($request['submit'])) {
            $user = User::getUserByEmail($request->input('email'));
            if ($user == null) {
                $invite = new Invite([
                    'email' => $request->input('email'),
                    'token' => str_random(32),
                    'is_activated' => 0,
                    'group_id' => $group_id
                ]);
                $user = Auth::user();
                $invite = $user->invites()->save($invite);
            } else {
                $group = Group::find($group_id);
                $user = $group->members()->save($user);
            }
        }

        return redirect(route('groups.show', $group_id));
    }
}
