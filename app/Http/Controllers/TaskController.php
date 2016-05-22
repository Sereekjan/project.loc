<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Priority;
use App\Models\Task;
use App\Models\Comment;
use App\User;
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
            ->with('priorities', Priority::getPriorities())
            ->with('user', Auth::user());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Task $task)
    {
        $emails = implode(',', Group::getEmailsByUser());
        $groups = implode(',', Group::getGroupsNameArray());
        $emailError = null;
        $groupError = null;
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:20',
            'text' => 'required|max:500',
            'status' => 'required',
            'time' => 'required',
            'for' => 'required|digits_between:1,3',
            'name' => 'required|'.(($request->input('for') == '2') ? 'in:'.$emails :
                    (($request->input('for') == '3') ? 'in:'.$groups : ''))
        ]);
        $messages = array();
        if ($emailError != null) {
            $messages[] = [
                'name' => 'No members with email in your groups'
            ];
        }
        if ($groupError != null) {
            $messages[] = [
                'name' => 'You have not groups with name'
            ];
        }
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
        if ($request->input('for') == '1') {
            $user = $task->user()->attach($user->id, ['creator_id' => $user->id]);
        } elseif ($request->input('for') == '2') {
            $user = $task->user()->attach(User::getUserByEmail($request->input('name'))->id, ['creator_id' => $user->id]);
        } elseif ($request->input('for') == '3') {
            $user = $task->group()->attach(Group::getGroupByName($request->input('name'))->id, ['creator_id' => $user->id]);
        }

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
        if (count(Task::find($id)->user) == 1) {
            if (Task::find($id)->creator()->id == Auth::user()->id || Task::find($id)->user()->first()->id == Auth::user()->id ) {
                return view('tasks.show')
                    ->with('priorities', Priority::getPriorities())
                    ->with('task', Task::getTaskById($id))
                    ->with('comments', Task::getComments($id));
            }
        } elseif (count(Task::find($id)->group) == 1) {
            if (Task::find($id)->group()->first()->isMember(Auth::user()->id))
                return view('tasks.show')
                    ->with('priorities', Priority::getPriorities())
                    ->with('task', Task::getTaskById($id))
                    ->with('comments', Task::getComments($id));
        }
        return redirect(route('tasks.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (count(Task::find($id)->user) == 1) {
            if (Task::find($id)->creator()->id == Auth::user()->id) {
                return view('tasks.edit')
                    ->with('priorities', Priority::getPriorities())
                    ->with('task', Task::find($id));
            }
        } elseif (count(Task::find($id)->group) == 1) {
            if (Task::find($id)->group()->first()->isModer(Auth::user()->id))
                return view('tasks.edit')
                    ->with('priorities', Priority::getPriorities())
                    ->with('task', Task::find($id));
        }
        return redirect(route('tasks.index'));
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
                    $task = Task::find($_id);
                    $task->comments()->delete();
                    $task->user()->detach();
                    $task->delete();
                }
            } else {
                $task = Task::find($request['deleting']);
                $task->comments()->delete();
                $task->user()->detach();
                $task->delete();
            }
        }

        return redirect($_SERVER['HTTP_REFERER']);
    }

    public function commentAdd($task_id, Request $request) {
        if (Task::find($task_id) == null)
            return redirect(route('tasks.show', $task_id));

        if (count(Task::find($task_id)->user) == 1) {
            if (Task::find($task_id)->creator()->id != Auth::user()->id && Task::find($task_id)->user()->first()->id != Auth::user()->id ) {
                return redirect(route('tasks.show', $task_id));
            }
        } elseif (count(Task::find($task_id)->group) == 1) {
            if (!Task::find($task_id)->group()->first()->isMember(Auth::user()->id)) {
                return redirect(route('tasks.show', $task_id));
            }
        } else {
            return redirect(route('tasks.show', $task_id));
        }

        $validator = Validator::make($request->all(), [
            'text' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect($_SERVER['HTTP_REFERER'])
                ->withErrors($validator)
                ->withInput();
        }

        if (isset($request['submit'])) {
            $comment = new Comment([
                'text' => $request->input('text'),
                'task_id' => $task_id
            ]);
            $user = Auth::user();
            $comment = $user->comments()->save($comment);
        }

        return redirect(route('tasks.show', $task_id));
    }
    
    public function commentEdit($comment_id) {
        if (Comment::find($comment_id)->user_id == Auth::user()->id)
            return view('comments.edit')
                ->with('comment', Comment::find($comment_id));
        else
            return redirect(route('tasks.show', Comment::find($comment_id)->task_id));
    }
    
    public function commentUpdate($comment_id, Request $request) {
        $validator = Validator::make($request->all(), [
            'text' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect($_SERVER['HTTP_REFERER'])
                ->withErrors($validator)
                ->withInput();
        }
        
        $comment = Comment::find($comment_id);
        $comment->text = $request->input('text');
        $comment->save();
        
        return redirect(route('tasks.show', $comment->task->id));
    }
    
    public function commentDelete($id, Request $request) {
        if (Comment::find($id)->user_id != Auth::user()->id)
            return redirect(route('tasks.show', Comment::find($id)->task_id));

        $validator = Validator::make($request->all(), [
            'deleting' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect($_SERVER['HTTP_REFERER'])
                ->withErrors($validator)
                ->withInput();
        }

        if (isset($request['submit'])) {
            Comment::find($request->input('deleting'))->delete();
        }

        return redirect($_SERVER['HTTP_REFERER']);
    }
    
    public function tasksForSomeOne() {
        return view('tasks.index')
            ->with('tasks', Task::getTasksByCreatorId(Auth::user()->id));
    }
}
