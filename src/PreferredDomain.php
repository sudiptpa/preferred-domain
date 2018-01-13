<?php

namespace Sujip\Middleware;

use Closure;

/**
 * Class PreferredDomain
 * @package Sujip\Middleware
 */
class PreferredDomain
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
        $domain = new Domain($request);

        if ($domain->diff()) {
            return redirect()->to(
                $domain->getTranslated(), 301
            );
        }

        return $next($request);
    }
}
