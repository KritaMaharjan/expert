<?php
/**
 * User: manishg.singh
 * Date: 2/19/2015
 * Time: 12:07 PM
 */

namespace App\Fastbooks\Facades;

use Illuminate\Support\Facades\Facade;

class General extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'general';
    }
} 