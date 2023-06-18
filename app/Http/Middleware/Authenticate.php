<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
	/**
	 * Get the path the user should be redirected to when they are not authenticated.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return string|null
	 */
	protected function redirectTo($request)
	{
		if (! $request->expectsJson()) {
		    // return route('admin.login');
		    return route('api.unauthenticate');
		}


		// if (Auth::guard('admin')->check()) {

		// 	return redirect('/admin');
		// } else if (Auth::guard('web')->check()) {

		// 	return redirect('/user');
		// }
        if (Auth::check()) {
            return $next($request);
        }
        return redirect()->route('user.login');
	}
}
