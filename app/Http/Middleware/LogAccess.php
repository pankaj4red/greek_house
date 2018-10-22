<?php

namespace App\Http\Middleware;

use App\Logging\Logger;
use Illuminate\Contracts\Auth\Guard;
use Route;

class LogAccess
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        $result = preg_match('/^App\\\Http\\\Controllers\\\[a-z0-9]+\\\([a-z0-9]+)Controller@([a-z0-9]+)$/i', Route::currentRouteAction(), $matches);
        if ($result) {
            Logger::setModule($matches[0]);
        }

        Logger::logAccess();

        return $next($request);
    }
}
