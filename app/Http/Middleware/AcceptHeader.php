<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response;

class AcceptHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($request->header('content-type') != 'application/json') {
            return response([
                'error' => [
                    'code' => Response::HTTP_BAD_REQUEST,
                    'message' => 'Request must contain json'
                ],
            ], Response::HTTP_BAD_REQUEST);
        }

        return $next($request);
    }
}
