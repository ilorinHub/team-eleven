<?php
declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class WhitelistMonnifyIPAddresses
{
    private array $whilelistIps = [
        '35.242.133.146',
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
