<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    public static function getTotalLikesForComment($poolId, $commentId)
{
    return self::where('pool_id', $poolId)
               ->where('comment_id', $commentId)
               ->count();
}

public static function hasLike($user_id, $pool_id, $comment_id)
{
    $like = static::where('user_id', $user_id)
                  ->where('pool_id', $pool_id)
                  ->where('comment_id', $comment_id)
                  ->first();

    return $like;
}

}
