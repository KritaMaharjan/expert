<?php namespace App\Providers;

use App\Expert\Libraries\General;
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
        foreach (glob(app_path() . '/Expert/Helpers/*.php') as $filename) {
            require_once($filename);
        }

        \App::bind('general', function()
        {
            return new General;
        });
    }

}
