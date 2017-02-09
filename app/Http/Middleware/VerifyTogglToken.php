<?php

namespace App\Http\Middleware;

use Closure;

class VerifyTogglToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (is_null(auth()->user()->getProvider('toggl')) || auth()->user()->getProvider('toggl')->token === '') {
            // Store where they were trying to go so we can redirect them later.
            session()->put('intended', $request->getRequestUri());

            return redirect(route('link.toggl'));
        }

        return $next($request);
    }
}
