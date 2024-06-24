<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        if (session()->has('locale')) {
            App::setLocale(session('locale'));
            Log::info('Locale set from session: ' . session('locale'));
        } else {
            App::setLocale(Config::get('app.locale'));
            Log::info('Locale set from config: ' . Config::get('app.locale'));
        }

        return $next($request);
    }
}
