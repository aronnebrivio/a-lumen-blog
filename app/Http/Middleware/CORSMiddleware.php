<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class CORSMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $this->isPreflightRequest($request) ? Response(null, 204) : $next($request);
        return $this->addCorsHeaders($request, $response);
    }

    /**
     * Determine if request is a preflight request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    protected function isPreflightRequest($request)
    {
        return $request->isMethod('OPTIONS');
    }

    /**
     * Add CORS headers.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Http\Response $response
     * @return Response
     */
    protected function addCorsHeaders($request, $response)
    {
        foreach ([
                     'Access-Control-Allow-Origin' => '*',
                     'Access-Control-Max-Age' => (60 * 60 * 24),
                     'Access-Control-Allow-Headers' => $request->header('Access-Control-Request-Headers'),
                     'Access-Control-Allow-Methods' => $request->header('Access-Control-Request-Methods')
                         ?: 'GET, HEAD, POST, PUT, PATCH, DELETE, OPTIONS',
                     'Access-Control-Allow-Credentials' => 'true',
                 ] as $header => $value) {
            $response->header($header, $value);
        }

        return $response;
    }
}
