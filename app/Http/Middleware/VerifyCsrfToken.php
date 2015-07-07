<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;
use Illuminate\Http\Request;

class VerifyCsrfToken extends BaseVerifier {


    /**
     * Handle an incoming request.
     * @param Request $request
     * @param callable $next
     * @return \Illuminate\Http\Response
     * @throws TokenMismatchException
     */
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
