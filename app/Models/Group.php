<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $fillable = ["userprivacy","title","description"];

    public function users()
    {
        return $this->hasManyThrough(User::class, GroupUser::class, 'group_id', 'id', 'id', 'user_id');
    }
    public function scopeFilter($query , array $filters){
    

        if($filters['search']   ?? false ){
            $query->where('title','like','%'.$filters['search'].'%')->orWhere('description','like','%'.$filters['search'].'%');
           }
 
     }

     public function hasMultipleInstances()
    {
        $groups = $this->where('title', $this->title)->get();
        $found = false;
        foreach ($groups as $group) {
            $user = $group->users()->where('authoritylevel', 2)->first();
            if ($user && $user->user_id != $this->users()->where('authoritylevel', 2)->first()->user_id) {
                $found = true;
                break;
            }
        }
        return $found;
    }
}
