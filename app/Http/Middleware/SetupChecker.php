<?php namespace App\Http\Middleware;

use Closure;

class SetupChecker {

      /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $setup =\App::make('App\Fastbooks\Libraries\SetupChecker');
        //redirect to setup page if tenant has not completed setup
        if ($setup->isSetupComplete()==false)
        {
            return $setup->redirectRoute();
        }
        return $next($request);
    }





}