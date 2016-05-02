<?php

namespace App\Http\Controllers;

use App\Models\Priority;
use App\Models\Task;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tasks.index')
            ->with('tasks', Task::getTasksByUserId(Auth::user()->id));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tasks.create')
            ->with('priorities', Priority::getPriorities());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Task $task)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:20',
            'text' => 'required|max:500',
            'status' => 'required',
            'time' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect(route('tasks.create'))
                ->withErrors($validator)
                ->withInput();
        }

        $task->title = $request->input('title');
        $task->text = $request->input('text');
        $task->priority_id = $request->input('status');
        $task->time = $request->input('time');
        $task->save();

        $user = Auth::user();
        $user = $task->users()->attach(88, ['creator_id' => $user->id]);

        return redirect(route('tasks.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('tasks.edit')
            ->with('priorities', Priority::getPriorities())
            ->with('task', Task::find($id));
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
            'title' => 'required|max:20',
            'text' => 'required|max:500',
            'status' => 'required',
            'time' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect(route('tasks.create'))
                ->withErrors($validator)
                ->withInput();
        }

        $task = Task::find($id);
        $task->title = $request->input('title');
        $task->text = $request->input('text');
        $task->priority_id = $request->input('status');
        $task->time = $request->input('time');
        $task->save();

        return redirect(route('tasks.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function delete($id, Request $request) {
        if (isset($request['submit'])) {
            if (is_array($request['deleting'])) {
                foreach ($request['deleting'] as $_id) {
                    $task = Task::find($_id);
                    $task->delete();
                }
            } else {
                $task = Task::find($request['deleting']);
                $task->delete();
            }
        }

        return redirect(route('tasks.index'));
    }
}
