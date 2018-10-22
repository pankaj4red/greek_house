<?php

namespace App\Http\Middleware;

use App\Logging\Logger;
use App\Models\User;
use Illuminate\Contracts\Auth\Guard;

class UserType
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
     * @param                           $ability
     * @return mixed
     */
    public function handle($request, \Closure $next, $ability)
    {
        if (! $this->auth->check()) {
            return redirect('/dashboard');
        }
        /** @var User $user */
        $user = $this->auth->user();

        if ($ability == 'account_manager') {
            if ($user->type_code != $ability) {
                Logger::logLogicError('Access Denied');
                \App::abort(403, 'Access denied');
            }

            return $next($request);
        }

        if (! $user->type->{$ability}) {
            Logger::logLogicError('Access Denied');
            \App::abort(403, 'Access denied');
        }

        return $next($request);
    }
}
