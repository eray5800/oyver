<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Groupuser;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckNonGroupMember
{
    public function handle(Request $request, Closure $next)
    {
        if (!Groupuser::checkUserBelongsToGroup(auth()->id(),$request->route('group')->id)) {
            return $next($request);
        }

        return redirect('/groups');
    }
}
