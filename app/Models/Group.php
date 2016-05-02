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

    public function members() {
        return $this->belongsToMany('App\User', 'group_members');
    }
}
