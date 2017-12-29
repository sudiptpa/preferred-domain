<?php

namespace Sujip\PreferredDomain;

use Closure;

/**
 * Class PreferredDomain
 * @package Sujip\PreferredDomain
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
