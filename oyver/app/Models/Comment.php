<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

 
    
    protected $fillable = ['comment'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getCommentsWithUserByPoolId($poolId)
{
    $comments = Comment::join('users', 'comments.user_id', '=', 'users.id')
        ->select("comments.id as id","users.id as user_id" ,'users.name', 'users.email', 'users.profilepicture', 'comments.comment', DB::raw("DATE_FORMAT(comments.created_at, '%d/%m/%Y') as created_date"))
        ->where('comments.pool_id', '=', $poolId)
        ->orderBy('comments.created_at', 'desc')
        ->latest('comments.created_at')
        ->paginate(10);
    
    return $comments;

}
    

    
    
    

    
    

}
