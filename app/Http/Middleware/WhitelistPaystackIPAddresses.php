<?php
declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class WhitelistPaystackIPAddresses
{
    private array $whilelistIps = [
        '52.31.139.75',
        '52.49.173.169',
        '52.214.14.220',
    ];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (\App::environment('production')) {

            if (!in_array($request->ip(), $this->whilelistIps)) {
                abort(403);
            }
        }
        return $next($request);
    }
}
