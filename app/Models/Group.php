<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'group_id', 'user_id', 'privilege_id'
    ];

    public static function getGroups() {
        self::all();
    }
}
