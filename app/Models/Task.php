<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public static function getTasks() {
        return self::all();
    }

    public static function getTaskById($id) {
        return self::where('id', '=', $id)->firstOrFail();
    }
}
