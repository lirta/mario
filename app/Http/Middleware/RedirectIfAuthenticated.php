<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;


class RedirectIfAuthenticated
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


		// if (Auth::guard($guard)->check()) {
		//     return redirect()->route('user.home');
		// }
		// end
		// if (Auth::guard('admin')->check()) {

		// 	return redirect('/admin');
		// } else if (Auth::guard('user')->check()) {

		// 	return redirect('/user');
		// } else {
		// 	return redirect()->route('member_login');
		// }
		// if ($guard == "admin" && Auth::guard($guard)->check()) {
		// 	return redirect('/admin');
		// }
		// if (Auth::guard($guard)->check()) {
		// 	return redirect('/home');
		// }
        switch ($guard) {
            case 'admin':
            if (Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::HOME);
                // return redirect()->route('admin.dashboard');
            }

            default:
            if (Auth::guard($guard)->check()) {
                //return redirect('/');
                return redirect(RouteServiceProvider::HOME);
            }
            break;
        }
        return $next($request);
	}
}
