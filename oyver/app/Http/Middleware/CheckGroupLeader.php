<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Groupuser;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckGroupLeader
{
    public function handle(Request $request, Closure $next)
    {   

        if (Groupuser::isLeader(auth()->id(), $request->route('group') ? $request->route('group')->id : ($request->route('groupuser') ? ($request->route('groupuser')->group_id ?? null) : ($request->route('application')->group_id ?? null) ) )) {
            return $next($request);
        }
        

        return redirect('/groups');
    }
}