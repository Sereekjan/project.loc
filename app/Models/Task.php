<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Task extends Model
{
    protected $fillable = [
        'title', 'text', 'time', 'priority_id'
    ];

    public static function getTasksByUserId($user_id) {
        $tasks = DB::table('tasks')
            ->join('tasks_users_relations', 'tasks.id', '=', 'tasks_users_relations.task_id')
            ->where('tasks_users_relations.user_id', '=', $user_id)
            ->pluck('task_id');

        return self::join('tasks_users_relations', 'tasks.id', '=', 'tasks_users_relations.task_id')
            ->whereIn('tasks.id', $tasks)
            ->paginate(10);
    }

    public static function getTasksByUserIdAndDate($user_id, $date) {
        $tasks = self::getTasksByUserId($user_id);
        $returnTasks = [];
        for ($i = 0; $i < count($tasks); $i++) {
            $time = getdate(strtotime($tasks[$i]['time']));
            $day = mktime(0, 0, 0, $time['mon'], $time['mday'], $time['year']);
            if ($date == $day) {
                $returnTasks[] = $tasks[$i];
            }
        }
        return $returnTasks;
    }

    public static function getTasksByCreatorId($user_id) {
        $tasks = DB::table('users')
            ->join('tasks_users_relations', 'users.id', '=', 'tasks_users_relations.user_id')
            ->where('creator_id', '=', $user_id)
            ->where('user_id', '!=', $user_id)
            ->pluck('task_id');

        return self::join('tasks_users_relations', 'tasks.id', '=', 'tasks_users_relations.task_id')
            ->whereIn('tasks.id', $tasks)
            ->paginate(10);
    }

    public static function getTaskById($id) {
        $tasks = self::join('tasks_users_relations', 'tasks.id', '=', 'tasks_users_relations.task_id')
            ->where('tasks.id', $id)
            ->first();
        if ($tasks == null) {
            $tasks = self::join('tasks_groups_relations', 'tasks.id', '=', 'tasks_groups_relations.task_id')
                ->where('tasks.id', $id)
                ->first();
        }
        return $tasks;
    }

    public static function getComments($task_id) {
        $task = self::where('id', '=', $task_id)->first();
        if ($task == null) {
            return null;
        } else {
            return $task->comments;
        }
    }

    public function user()
    {
        return $this->belongsToMany('App\User', 'tasks_users_relations');
    }
    
    public function creator() {
        $creator = DB::table('tasks_users_relations')
            ->where('task_id', $this->id)
            ->first();
        if ($creator == null) {
            $creator = DB::table('tasks_groups_relations')
                ->where('task_id', $this->id)
                ->first();
        }
        return User::find($creator->creator_id);
    }

    public function comments() {
        return $this->hasMany('App\Models\Comment', 'task_id');
    }
    
    public function group()
    {
        return $this->belongsToMany('App\Models\Group', 'tasks_groups_relations');
    }
    
    public function getGroup() {
        return $this->group()->first();
    }

    public function getUser() {
        return $this->user()->first();
    }
}
