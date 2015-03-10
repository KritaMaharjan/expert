<?php
namespace  App\Fastbooks\Auth;

use Illuminate\Auth\Guard as AuthGuard;

class SystemGuard extends AuthGuard
{

    public function getName()
    {
        return 'login_' . md5('SystemGuard');
    }

    public function getRecallerName()
    {
        return 'remember_' . md5('SystemGuard');
    }
}