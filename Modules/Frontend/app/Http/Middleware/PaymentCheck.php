<?php

namespace Modules\Frontend\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PaymentCheck
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
        if (SettingData('subscription', 'subscription_system') == 0 || (Auth::check() && Auth::user()->is_subscribe)) {
            return redirect()->route('browse');
        }

        return $next($request);
    }
}
