<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Groupapplication extends Model
{
    use HasFactory;

    protected $fillable = ["description","group_id","user_id"];
    public static function checkApplication($user_id, $group_id)
{
    $application = static::where('user_id', $user_id)
                           ->where('group_id', $group_id)
                           ->first();
    return $application;
}

public static function countApplicationsByGroupId($groupId, $search = null)
{
    $query = Groupapplication::select(
        'groupapplications.*',
        'users.name',
        'users.profilepicture',
        DB::raw('DATE_FORMAT(groupapplications.created_at, "%d/%m/%Y") as created_date')
    )
    ->leftJoin('users', 'groupapplications.user_id', '=', 'users.id')
    ->where('group_id', $groupId);

    if ($search) {
        $query->where(function ($query) use ($search) {
            $query->where('users.name', 'LIKE', '%' . $search . '%')
                  ->orWhere('groupapplications.description', 'LIKE', '%' . $search . '%');
        });
    }

    $applications = $query->paginate(15);
    
    return $applications;
}




}
