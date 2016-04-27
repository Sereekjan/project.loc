<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title', 'text', 'time', 'priority_id'
    ];

    public static function getTasks() {
        return self::all();
    }

    public static function getTaskById($id) {
        return self::where('id', '=', $id)->firstOrFail();
    }
}
