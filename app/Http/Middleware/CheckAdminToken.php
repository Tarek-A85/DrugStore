<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\ResponseTrait;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminToken
{
    use ResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!auth()->user()->is_admin)
        return $this->Error("Un Authenticated");
        return $next($request);
    }
}
