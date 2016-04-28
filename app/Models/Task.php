<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Task extends Model
{
    protected $fillable = [
        'title', 'text', 'time', 'priority_id'
    ];

    public static function getTasksByUserId($user_id) { // ТУТА
        return self::all();
        //return self::select('tasks.*')->join('tasks_users_relations', '	tasks_users_relations.user_id', '=', 'tasks.id');
    }

    public static function getTaskById($id) {
        return self::where('id', '=', $id)->firstOrFail();
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'tasks_users_relations');
    }
}
