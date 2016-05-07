<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'group_id', 'user_id', 'privilege_id'
    ];

    public static function getGroups() {
        return self::all();
    }

    public static function getGroupById($id) {
        return self::where('id', '=', $id)->get();
    }

    public static function getGroupByName($name) {
        return self::where('name', '=', $name)->first();
    }

    public function members() {
        return $this->belongsToMany('App\User', 'group_members');
    }

    public function tasks() {
        return $this->belongsToMany('App\Models\Task', 'tasks_groups_relations');
    }

    public function getUsers() {
        return $this->members()->paginate(10);
    }

    public function getTasks() {
        return $this->tasks()->paginate(10);
    }
}
