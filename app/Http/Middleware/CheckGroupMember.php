<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Pool;
use App\Models\Option;
use App\Models\Groupuser;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckGroupMember
{

    public function handle(Request $request, Closure $next): Response
    {
        
        if($request->route()->getName()=="show"){

            if($request->route("pool")->group_id){
                
                if(Groupuser::checkUserBelongsToGroup(auth()->id(),$request->route('pool')->group_id)){
                    return $next($request);
                } else {
                    return redirect('/');
                }
            }
            else {
                return $next($request);
            }
           
            
        }
        
        else if($request->route()->getName()=="saveVote" ){
            
            $pool = Pool::find(Option::find($request->option)->pool_id);
            if($pool == null) {
                abort(404);
            }
            if($pool->group_id){
                if(Groupuser::checkUserBelongsToGroup(auth()->id(),$pool->group_id) ){
                
                    return $next($request);
                } else {
                    return redirect('/');
                }
            }
            else {
                return $next($request);
            }
        }
        
        else if(Groupuser::checkUserBelongsToGroup(auth()->id(),$request->route('group')->id)) {
            return $next($request);
        }

        return redirect('/groups');
    }
}
