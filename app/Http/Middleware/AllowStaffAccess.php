<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class AllowStaffAccess
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
        if(Gate::allows('is-staff')) {
            return $next($request);
        }
        abort(\Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN);
    }
}
