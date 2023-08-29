<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Groupuser;
use Illuminate\Http\Request;
use App\Models\Groupapplication;
use Symfony\Component\HttpFoundation\Response;

class CheckGroupApplication
{
    public function handle(Request $request, Closure $next)
    {
        if (!Groupapplication::checkApplication(auth()->id(),$request->route('group')->id) and !Groupuser::checkUserBelongsToGroup(auth()->id(),$request->route('group')->id)) {
            return $next($request);
        }

        return redirect('/groups');
    }
}
