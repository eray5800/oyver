<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class Groupuser extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getUsersByGroupId($group_id, $search = null)
{
    $query = static::where('group_id', $group_id)
                ->with('user')
                ->orderByRaw('CASE WHEN authoritylevel = 2 THEN 0 ELSE 1 END');

    if ($search) {
        $query->whereHas('user', function ($query) use ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        });
    }

    $users = $query->get(['id', 'user_id', 'group_id', 'authoritylevel'])
                ->map(function ($groupuser) {
                    $user = $groupuser->user;
                    $user->id = $groupuser->id;
                    $user->user_id = $groupuser->user_id;
                    $user->authoritylevel = $groupuser->authoritylevel;
                    return $user;
                });

    $perPage = 15;
    $currentPage = Paginator::resolveCurrentPage();
    $pagedData = $users->slice(($currentPage - 1) * $perPage, $perPage)->all();
    $users = new LengthAwarePaginator($pagedData, count($users), $perPage);
    $users->setPath(request()->url());

    return $users;
}

public static function checkUserBelongsToGroup($user_id, $group_id)
{
    $groupUser = static::where('user_id', $user_id)
                           ->where('group_id', $group_id)
                           ->first();
    return $groupUser;
}


public static function isLeader($user_id, $group_id)
    {
        $groupuser = self::where('user_id', $user_id)->where('group_id', $group_id)->first();

        if ($groupuser && $groupuser->authoritylevel == 2) {
            return true;
        }

        return false;
    }

    public static function getUsersWithAuthorityLevelTwo($user_id)
    {
        $group_user_records = self::where('user_id', $user_id)
                                    ->where('authoritylevel', 2)
                                    ->get();
    
        $group_ids = $group_user_records->pluck('group_id')->unique();
    
        $group_records = Group::whereIn('id', $group_ids)->get();
    
        return $group_records;
    }

    public static function getUserGroups($user_id) {
        $groups = self::where('user_id', $user_id)->pluck('group_id')->toArray();
        return $groups;
    }



}
