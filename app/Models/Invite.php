<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    protected $fillable = [
        'email', 'token', 'is_activated', 'inviter_id'
    ];

    public function inviter()
    {
        return $this->belongsTo('App\User');
    }
}
