<?php

namespace App\Http\Controllers;

use App\Models\Group;
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
            ->with('groups', Group::getGroups());
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
        dd('KEK');
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
}
