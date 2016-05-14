<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    protected $fillable = [
        'email', 'token', 'is_activated', 'inviter_id', 'group_id'
    ];

    public function inviter()
    {
        return $this->belongsTo('App\User');
    }
    
    public function group() {
        return $this->belongsTo('App\Models\Group');
    }
    
    public static function getInviteByToken($token) {
        return self::where('token', '=', $token)->first();
    }
}
