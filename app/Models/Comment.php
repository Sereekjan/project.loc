<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'user_id', 'task_id', 'text', 'time'
    ];

    public function task() {
        return $this->belongsTo('App\Models\Task');
    }
    
    public function author() {
        return $this->belongsTo('App\User');
    }
}
