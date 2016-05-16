<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Task extends Model
{
    protected $fillable = [
        'title', 'text', 'time', 'priority_id'
    ];

    public static function getTasksByUserId($user_id) {
        $tasks = DB::table('users')
            ->join('tasks_users_relations', 'users.id', '=', 'tasks_users_relations.user_id')
            ->where('users.id', '=', $user_id)
            ->pluck('task_id');

        return self::whereIn('id', $tasks)->paginate(10);
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

    public static function getTaskById($id) {
        return self::where('id', '=', $id)->firstOrFail();
    }

    public function user()
    {
        return $this->belongsToMany('App\User', 'tasks_users_relations');
    }

    /*public function creator() {
        return $this->belongsToMany('App\User', 'tasks_users_relations', 'creator_id');
    }*/

    /*public function getCreator() {
        return $this->creator()->first();
    }*/

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
