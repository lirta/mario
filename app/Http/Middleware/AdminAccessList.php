<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminAccessList
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        @$admin = Auth::guard('admin')->user();
        if(@$admin->is_listed_access==1){
            $ipAdmin = DB::table('admin_ipaddresses')->where('admin_id',@$admin->id)->where('ip_address',@$request->ip())->first();
            if(@$ipAdmin){
                return $next($request);
            } else {
                Auth::guard('admin')->logout();
                $notify[] = ['error',"You are restricted to access the site from this IP Address : ".$request->ip()];
                return redirect()->route('admin.login')->withNotify($notify);
            }
        }
        return $next($request);
    }
}
