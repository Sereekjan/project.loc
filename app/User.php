<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'remember_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function tasks()
    {
        return $this->belongsToMany('App\Models\Task', 'tasks_users_relations');
    }

    public function groups()
    {
        return $this->belongsToMany('App\Models\Group', 'group_members');
    }

    public function invites()
    {
        return $this->hasMany('App\Models\Invite', 'inviter_id');
    }
    
    public function comments() {
        return $this->hasMany('App\Models\Comment', 'user_id');
    }
    
    public function getGroups() {
        return $this->groups()->paginate(10);
    }

    public static function getUserByEmail($email) {
        return self::where('email', '=', $email)->first();
    }
    
    public static function getEmailsByIds($ids) {
        $returnArr = [];
        //for ($i = 0; $i < count(self::))
        return self::where()->select('email')->get();
    }
}
