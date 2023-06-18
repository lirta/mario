<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function is_code_expired($verification)
    {
        //Y-m-d H:i:s
        $now = date('Y-m-d H:i:s');
        $date = $verification->updated_at;
        date_modify($date,"+1 days");
        return $now > $date;
    }
}