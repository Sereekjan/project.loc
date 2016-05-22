<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

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
        $groups = DB::table('groups')
            ->join('group_members', 'groups.id', '=', 'group_members.group_id')
            ->where('group_members.user_id', '=', $this->id)
            ->pluck('group_id');

        return DB::table('groups')
            ->join('group_members', 'groups.id', '=', 'group_members.group_id')
            ->whereIn('group_members.group_id', $groups)
            ->where('group_members.user_id', '=', $this->id)
            ->paginate(10);
    }

    public static function getUserByEmail($email) {
        return self::where('email', '=', $email)->first();
    }

    public static function getEmailsByIds($ids) {
        $returnArr = [];
        for ($i = 0; $i < count($ids); $i++) {
            $returnArr[] = User::find($ids[$i]->user_id)->email;
        }
        return $returnArr;
    }
}
