<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Pool;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;  

class CommentController extends Controller
{
    public function saveComment(Request $request,Pool $pool){
   

        $formFields = $request->validate([
            'postComment' => [
                'required',
                'string',
                'max:700',
                Rule::unique('comments','comment')->where(function ($query) use ($pool) {
                    return $query->where('pool_id', $pool->id)
                                 ->where('user_id', auth()->id());
                }),
            ],
        ],[
            'postComment.required' => 'Yorum zorunludur.',
            'postComment.max' => 'Bir yorum :max karakter olabilir.',
            'postComment.unique' => 'Aynı yorumu iki kez gönderemezsiniz.',
        ]);

        
      
        $comment = new Comment(["comment" => $formFields["postComment"]]);
        $comment->user_id = auth()->id();
        $comment->pool_id = $pool->id;
        $comment->save();

    
    
       return  back()->with('message','Yorumunuz başarıyla oluşturuldu.');   
    }

    public function deleteComment(Comment $comment,Request $request){
       if(auth()->id() != $comment->user_id){
        abort(403,"Yetkisiz işlem");
       }

       $comment->delete();


       $paginator = Comment::getCommentsWithUserByPoolId($comment->pool_id);
    if($paginator->lastPage() == 1) {
     return redirect("/pool/$comment->pool_id")->with('message','Yorumunuz başarıyla silindi.');
    } else {
     $url = url()->previous();
     $page = ($request->page <= $paginator->lastPage()) ? $request->page : $paginator->lastPage();
     $requestUrl = Request::create($url, 'GET', ['page' => $page])->fullUrl();
    
     return redirect($requestUrl)->with('message','Yorumunuz başarıyla silindi.');
    }
    
}

    public function updateComment(Comment $comment,Request $request){

        if(auth()->id() != $comment->user_id){
            abort(403,"Yetkisiz işlem");
        }

        $pool = Pool::find($comment->pool_id);
        $formFields = $request->validate([
            'comment_'.$comment->id => [
                'required',
                'string',
                'max:700',
                Rule::unique('comments','comment')->where(function ($query) use ($pool) {
                    return $query->where('pool_id', $pool->id)
                                 ->where('user_id', auth()->id());
                }),
            ],
        ],[
            'comment_'.$comment->id.'.required' => 'Yorum boş olarak değiştirilemez.',
            'comment_'.$comment->id.'.unique' => 'Aynı yorumu iki kez gönderemezsiniz.',
            'comment_'.$comment->id.'.max' => 'Bir yorum :max karakter olabilir.'
        ]);

        $comment->update(["comment" => $formFields['comment_'.$comment->id]]);

        $paginator = Comment::getCommentsWithUserByPoolId($comment->pool_id);
        $url = url()->previous();
        $page = ($request->page <= $paginator->lastPage()) ? $request->page : $paginator->lastPage();
        $requestUrl = Request::create($url, 'GET', ['page' => $page])->fullUrl();
    
        return redirect($requestUrl)->with('message','Yorumunuz başarıyla düzenlendi.');
    }

}
