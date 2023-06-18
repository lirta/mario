<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Language as mdLanguage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class Language
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
        session()->put('lang', $this->getCode());
        app()->setLocale(session('lang',  $this->getCode()));
        return $next($request);
    }

    public function getCode()
    {
        if (session()->has('lang')) {
            return session('lang');
        }
        $language = mdLanguage::where('is_default', 1)->first();
        return $language ? $language->code : 'en';
    }
}
