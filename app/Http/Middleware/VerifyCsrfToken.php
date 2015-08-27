<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
    ];

    /* Work around for ajax requests */
    public function handle($request, Closure $next)
    {
        // return parent::handle($request, $next);
        $path = $request->path();
        $data = explode('/', $path);
        $data = end($data);
        $checkExclude = ($data == 'data') ? true : false;

        if ($this->isReading($request) || $this->tokensMatch($request) || $checkExclude || $request->ajax()) {
            return $this->addCookieToResponse($request, $next($request));
        }

        throw new TokenMismatchException;
    }
}
