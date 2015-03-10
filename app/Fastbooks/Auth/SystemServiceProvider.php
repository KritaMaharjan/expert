<?php

namespace App\Fastbooks\Auth;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Auth\Reminders\PasswordBroker;
use Illuminate\Auth\Reminders\DatabaseReminderRepository;
use ClientGuard;
use ClientAuth;

class SystemServiceProvider extends ServiceProvider {


    public function register()
    {
        $this->registerAuth();
        $this->registerReminders();
    }

    protected function registerAuth()
    {
        $this->registerClientCrypt();
        $this->registerClientProvider();
        $this->registerClientGuard();
    }

    protected function registerClientCrypt()
    {
        $this->app['system.auth.crypt'] = $this->app->share(function($app)
        {
            return new BcryptHasher;
        });
    }

    protected function registerClientProvider()
    {
        $this->app['system.auth.provider'] = $this->app->share(function($app)
        {
            return new EloquentUserProvider(
                $app['system.auth.crypt'],
                'Client'
            );
        });
    }

    protected function registerClientGuard()
    {
        $this->app['system.auth'] = $this->app->share(function($app)
        {
            $guard = new Guard(
                $app['system.auth.provider'],
                $app['session.store']
            );

            $guard->setCookieJar($app['cookie']);
            return $guard;
        });
    }

    protected function registerReminders()
    {
        # DatabaseReminderRepository
        $this->registerReminderDatabaseRepository();

        # PasswordBroker
        $this->app['system.reminder'] = $this->app->share(function($app)
        {
            return new PasswordBroker(
                $app['system.reminder.repository'],
                $app['system.auth.provider'],
                $app['redirect'],
                $app['mailer'],
                'emails.system.reminder' // email template for the reminder
            );
        });
    }

    protected function registerReminderDatabaseRepository()
    {
        $this->app['system.reminder.repository'] = $this->app->share(function($app)
        {
            $connection   = $app['db']->connection();
            $table        = 'system_reminders';
            $key          = $app['config']['app.key'];

            return new DatabaseReminderRepository($connection, $table, $key);
        });
    }

    public function provides()
    {
        return array(
            'system.auth',
            'system.auth.provider',
            'system.auth.crypt',
            'system.reminder.repository',
            'system.reminder',
        );
    }
}