<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Iplist;
use Illuminate\Http\Request;

class BlockAccessWeb
{
    public $blockIps = ['180.252.63.139'];

    public function handle(Request $request, Closure $next)
    {
        $info        = json_decode(json_encode(getIpInfo()), true);
        $country     = @implode(',', $info['country']);
        $dataIP      = Iplist::where('ip_address',$request->ip())->first();
        $dataCountry = Iplist::where('country',$country)->first();
        if (@$dataIP->status==1 or @$dataCountry->status==1) {
            $notify[] = 'ACCESS RESTRICTED';
            return response()->json([
                'code'    => 403,
                'status'  => 'created',
                'message' => ['error'=>$notify],
            ],403);
        }
        return $next($request);
    }
}
