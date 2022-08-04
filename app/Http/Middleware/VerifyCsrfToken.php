<?php

namespace App\Http\Middleware;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Closure;

class VerifyCsrfToken extends Middleware
{
    protected $except = [
        '/login'
    ];

    //modify this function
    public function handle($request, Closure $next)
    {
        //add this condition
        if($request->ajax()){
            return $next($request);
        }

        return parent::handle($request, $next);
    }
}
