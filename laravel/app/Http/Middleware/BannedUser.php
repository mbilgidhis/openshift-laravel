<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class BannedUser
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
        if( !Auth::guest() ) {
            if( $request->user()->active !== 'Yes' ) {
                Auth::logout();
                return redirect('/login');
            }
        }

        return $next($request);
    }
}
