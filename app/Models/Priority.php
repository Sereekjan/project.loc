<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
    protected $table = 'tasks_priorities';

    public static function getPriorities() {
        return self::all();
    }
}
