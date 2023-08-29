<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Comment;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function likeOrUnlikeComment(Request $request){
        

        if(Like::hasLike(auth()->id(),$request->pool_id, $request->comment_id) == null and $request->like==true and $request->user_id == auth()->id()){
            if(Comment::find($request->comment_id)->pool_id == $request->pool_id){
    
            $like = new Like();
            $like->user_id = $request->user_id;
            $like->pool_id = $request->pool_id;
            $like->comment_id = $request->comment_id;
            $like->save();
            return response()->json(['success' => true, 'likes' =>  Like::getTotalLikesForComment($request->pool_id, $request->comment_id)]);
            }
            else {
                abort(404,"Bulunamadı");
            }
        }
        else if(Like::hasLike(auth()->id(),$request->pool_id, $request->comment_id) == true and $request->like==false and $request->user_id == auth()->id()){
            
            $like = Like::hasLike(auth()->id(),$request->pool_id, $request->comment_id);
            $like->delete();
    
            return response()->json(['success' => true, 'likes' =>  Like::getTotalLikesForComment($request->pool_id, $request->comment_id)]);
    
        }
        else {
            abort(403,"Yetkisiz işlem");
        }
        
        }
}
