<?php namespace App\Providers;

use App\Fastbooks\Libraries\General;
use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }


    public function register()
    {
        foreach (glob(app_path() . '/Fastbooks/Helpers/*.php') as $filename) {
            require_once($filename);
        }

        \App::bind('general', function()
        {
            return new General;
        });
    }

}
