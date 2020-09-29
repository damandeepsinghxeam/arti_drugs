<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Support\Facades\Log;



class AccessLogMiddleware
{
    public function handle($request, Closure $next)
    {
        
        Log::info(['request' => $request->all()]);
        return $next($request);
    }
}