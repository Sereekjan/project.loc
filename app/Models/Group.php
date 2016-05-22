<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Group extends Model
{
    protected $fillable = [
        'group_id', 'user_id', 'privilege_id'
    ];
    
    public function getEmails() {
        $idArr = $this->members()->select('user_id')->get();
        return User::getEmailsByIds($idArr);
    }

    public function members() {
        return $this->belongsToMany('App\User', 'group_members');
    }

    public function tasks() {
        return $this->belongsToMany('App\Models\Task', 'tasks_groups_relations');
    }
    
    public function invites() {
        return $this->hasMany('App\Models\Invite');
    }

    public function getUsers() {
        return DB::table('users')
            ->join('group_members', 'users.id', '=', 'group_members.user_id')
            ->where('group_members.group_id', $this->id)
            ->paginate(10);
    }

    public function getTasks() {
        return DB::table('tasks')
            ->join('tasks_groups_relations', 'tasks.id', '=', 'tasks_groups_relations.task_id')
            ->where('tasks_groups_relations.group_id', $this->id)
            ->paginate(10);
    }

    public function getGroup() {
        return DB::table('groups')
            ->join('group_members', 'groups.id', '=', 'group_members.group_id')
            ->where('group_members.group_id', $this->id)
            ->where('group_members.user_id', Auth::user()->id)
            ->first();
    }

    public function deleteTasks() {
        $tasks = $this->tasks();
        $tasks->comments()->delete();
        $tasks->delete();
    }

    public function isModer($user_id) {
        $moders = DB::table('group_members')
            ->where('group_id', $this->id)
            ->where('privilege_id', '<>', 2)
            ->pluck('user_id');
        
        for ($i = 0; $i < count($moders); $i++) {
            if ($moders[$i] == $user_id)
                return true;
        }
        return false;
    }

    public function isMember($user_id)
    {
        $users = DB::table('group_members')
            ->where('group_id', $this->id)
            ->pluck('user_id');

        for ($i = 0; $i < count($users); $i++) {
            if ($users[$i] == $user_id)
                return true;
        }
        return false;
    }

    public static function getEmailsByUser() {
        $groupsArr = DB::table('group_members')->orWhere(function($query)
        {
            $query->where('privilege_id', '=', 1)
                ->orWhere('privilege_id', '=', 3);
        })->where('user_id', '=', Auth::user()->id)->get();
        //dd($groupsArr);
        $groupsMembersIds = [];
        for ($i = 0; $i < count($groupsArr); $i++) {
            $group = Group::find($groupsArr[$i]->group_id);
            $groupsMembersIds = array_merge($groupsMembersIds, $group->getEmails());
        }
        $groupsMembersIds = array_unique($groupsMembersIds);
        return $groupsMembersIds;
    }
    
    public static function getGroups() {
        return self::all();
    }

    public static function getGroupsNameArray() {
        $groups = DB::table('groups')
            ->join('group_members', 'groups.id', '=', 'group_members.group_id')
            ->where('group_members.user_id', '=', Auth::user()->id)
            ->where('group_members.privilege_id', '<>', 2)
            ->select('groups.name')->get();
        $namesArray = [];
        for ($i = 0; $i < count($groups); $i++) {
            $namesArray[] = $groups[$i]->name;
        }
        return $namesArray;
    }

    public static function getGroupById($id) {
        return self::where('id', '=', $id)->get();
    }

    public static function getGroupByName($name) {
        return self::where('name', '=', $name)->first();
    }

    public static function deleteGroups($groups_id) {
        for ($i = 0; $i < count($groups_id); $i++) {
            $group = Group::find($groups_id[$i]);
            if (count($group->members()) != 0)
                $group->members()->detach();
            if (count($group->tasks()) != 0) {
                for ($i = 0; $i < count($group->tasks); $i++) {
                    $group->tasks[$i]->comments()->delete();
                }
                $group->tasks()->delete();
                $group->tasks()->detach();
            }
            if (count($group->invites()) != 0)
                $group->invites()->delete();
            $group->delete();
        }
        return redirect(route('groups.index'));
    }
}
