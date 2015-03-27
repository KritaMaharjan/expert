<?php
/**
 * Created by PhpStorm.
 * User: manishg.singh
 * Date: 3/27/2015
 * Time: 11:27 AM
 */

namespace APP\Http\Tenant\Email\Controllers;


use App\Fastbooks\Libraries\Mailbox\EmailReader;
use App\Http\Controllers\Tenant\BaseController;
use App\Models\Tenant\User;

class CronController extends BaseController {


    function run(User $user)
    {

        dd($user);
    }

    function getMails()
    {
        $mailbox = new EmailReader('imap.gmail.com', 'manish.alucio@gmail.com', '@sdf@sdf', 993);

        if ($mailbox->connect()) {
            $data = $mailbox->read();

            return $data;
        } else {
            echo $mailbox->error();
        }
    }


} 