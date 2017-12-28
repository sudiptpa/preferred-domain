<?php

namespace Sujip\Middleware;

use Closure;
use Sujip\Domain;

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
        $domain = new Domain(
            $request,
            app('config')
        );

        if ($domain->diff()) {
            return \Redirect::to(
                $domain->getTranslated(),
                301
            );
        }

        return $next($request);
    }
}
