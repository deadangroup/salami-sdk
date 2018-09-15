<?php

namespace Deadan\Support\Http;

use Closure;
use Symfony\Component\HttpFoundation\HeaderBag;

class MimicJsonRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //this is bad practice. We want to make sure api requests always get a json response
        $request->server->set('HTTP_ACCEPT', 'application/json');
        $request->server->set('Accept', 'application/json');

        $request->headers = new HeaderBag($request->server->getHeaders());
        return $next($request);
    }
}
