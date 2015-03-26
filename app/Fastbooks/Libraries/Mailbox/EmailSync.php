<?php
/**
 * Created by PhpStorm.
 * User: manishg.singh
 * Date: 3/26/2015
 * Time: 4:05 PM
 */

namespace App\Fastbooks\Libraries\Mailbox;


class EmailSync {


    function run()
    {

        $mailbox = new EmailReader('imap.gmail.com', 'manish.alucio@gmail.com', '@sdf@sdf', 993);

        if ($mailbox->connect()) {
            $data = $mailbox->read();

        } else {
            echo $mailbox->error();
            die;
        }

    }


    function store()
    {

    }

} 