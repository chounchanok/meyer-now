<?php

namespace App\Http\Middleware;

use Closure;
use Barryvdh\Debugbar\Middleware\InjectDebugbar;

class EnableDebugBarMiddleware extends InjectDebugbar
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
        if (auth()->user()?->hasRole('Developer')) {
            config()->set('debugbar.enabled', true);
            \Debugbar::enable();
        }
        return parent::handle($request, $next);
    }
}
