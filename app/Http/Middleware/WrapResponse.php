<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;

class WrapResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (
            $response instanceof JsonResponse &&
            app()->bound('debugbar') &&
            app('debugbar')->isEnabled() &&
            is_object($response->getData())
        ) {
            $data = app('debugbar')->getData();
            $response->setData($response->getData(true) + [
                    '_debugbar' =>[
                        'queries_count'=> data_get($data, 'queries.nb_statements'),
                        'queries'=> data_get($data, 'queries.statements.*.sql'),
                    ],
                ]);
        }

        return $response;
    }
}
