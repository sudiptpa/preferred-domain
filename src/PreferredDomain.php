<?php

namespace Sujip\Domain;

use Closure;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Str;

class PreferredDomain
{

    /**
     * @param Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Str::startsWith($request->header('host'), 'www.') && !$this->config->get('domain.www')) {
            $host = str_replace('www.', '', $request->header('host'));
            $request->headers->set('host', $host);
        }

        if (Str::startsWith($request->header('host'), 'http') && $this->config->get('domain.www')) {
            //to do
        }

        return $next($request);
    }
}
