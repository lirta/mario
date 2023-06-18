<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Iplist;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;

class BlockAccessMiddleware
{
    public $blockIps = ['180.252.63.139'];

    public function handle(Request $request, Closure $next)
    {
        $info    = json_decode(json_encode(getIpInfo()), true);
        $country = @implode(',', $info['country']);

        $dataIP      = Iplist::where('ip_address',$request->ip())->first();
        $dataCountry = Iplist::where('country',$country)->first();
        // dd(@$dataCountry);
        // if (@$dataIP->status==1 or @$dataCountry->status==1) {
        //     abort(403, __("You are restricted to access the site."));
        // }

        return $next($request);
    }
}
