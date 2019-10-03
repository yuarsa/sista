<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Auth\AuthenticationException;
use Laravel\Passport\Http\Middleware\CheckClientCredentials;
use Symfony\Component\HttpFoundation\Response;

class ApiSista
{
    protected $auth;


    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if($this->auth->guard($guard)->guest()) {
            try {
                app(CheckClientCredentials::class)->handle($request, function(){});
            } catch(AuthenticationException $ae) {
                return response()->json(
                    (['error' => [
                            'code' => Response::HTTP_UNAUTHORIZED,
                            'message' => 'Unauthorized'
                        ]
                    ]),
                    Response::HTTP_UNAUTHORIZED
                );
            }
        }

        return $next($request);
    }
}
