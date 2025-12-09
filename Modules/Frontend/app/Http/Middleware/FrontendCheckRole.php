<?php

namespace Modules\Frontend\Http\Middleware;

use Closure;

class FrontendCheckRole
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
        $user = auth()->user();
        
        if (!$user || !$user->hasRole('user')) { 
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
