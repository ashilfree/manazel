<?php

namespace App\Http\Middleware;

use Closure;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (\auth('admins')->user())
        {
            if( \auth('admins')->user()->admin == 1 || \auth('admins')->user()->admin == 2)
            {
                return $next($request);
            }
            else
            {
                \Auth::logout();
                return redirect('/login');
            }
        }
        return redirect('/login');
    }
}
