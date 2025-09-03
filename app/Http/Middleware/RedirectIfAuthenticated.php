<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated //declares middleware class which redirects if they are already logged in 
{
    // 
    //Handle an incoming request.
    
    //  @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
    //  
public function handle(Request $request, Closure $next, string ...$guards): Response   //$request: current HTTP request,$next:nest middleware in pipeline, $guards: authentication guards
    {
    $guards = empty($guards) ? [null] : $guards;  //if no guards , null is default guard. if guards , uses those

         foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {  //checks if user is logged in under that guard
                return redirect('/dashboard');
            }
        }

    return $next($request);  //if user is not logged in, this passes next middleware
    }
}