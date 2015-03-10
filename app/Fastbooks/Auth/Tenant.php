<?php
namespace App\Fastbooks\Auth;

use Illuminate\Auth\Guard as AuthGuard;

class TenantGuard extends AuthGuard {

    public function getName()
    {
        return 'login_' . md5('TenantGuard');
    }

    public function getRecallerName()
    {
        return 'remember_' . md5('TenantGuard');
    }
}