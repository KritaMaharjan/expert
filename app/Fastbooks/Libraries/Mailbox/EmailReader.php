<?php
namespace App\Fastbooks\Libraries\Mailbox;

use Ddeboer\Imap\Search\Date\After;
use Ddeboer\Imap\SearchExpression;
use Ddeboer\Imap\Server;

/*
 * Example
 * host: alucio.com   / imap.gmail.com
 * email : krita@alucio.com / krita@gmail.com
 * password : @1uc!0 /asdfasdf
 * port : 25 /993
 * */

class EmailReader {

    public $folder = 'INBOX';

    private $host;
    private $port;
    private $email;
    private $password;
    private $connection;
    private $error;

    function __construct($host, $email, $password, $port = 993)
    {
        /*$this->host = $host;
        $this->email = $email;
        $this->password = $password;*/
        $this->host = 'imap.gmail.com';
        $this->email = 'manish.alucio@gmail.com';
        $this->password = '@sdf@sdf';
        $this->port = (empty($port)) ? 993 : $port;
    }

    function connect()
    {
        try {
            $this->authenticate();
        } catch (\Exception $e) {
            $this->error = $e->getMessage();

            return false;
        }

        return true;
    }

    function error()
    {
        return $this->error;
    }

    function authenticate()
    {
        $server = new Server($this->host, $this->port);
        $this->connection = $server->authenticate($this->email, $this->password);
    }

    function mailbox()
    {
        return $this->connection->getMailbox($this->folder);
    }

    function messageSince($date)
    {
        $mailbox = $this->mailbox();
        $search = new SearchExpression();
        $since = new \DateTime($date);
        $search->addCondition(new After($since));

        return $mailbox->getMessages($search);
    }


    function read($date = null)
    {

        ini_set('max_execution_time', 300);

        if ($date == null) {
            $date = date('Y-m-d');
        }
        $messages = $this->messageSince($date);
        $inbox = array();
        foreach ($messages as $message) {
            $m = new \stdClass();
            $m->msid = $message->getNumber();
            $m->subject = $message->getSubject();
            $m->fromEmail = $message->getFrom()->getAddress();
            $m->fromName = $message->getFrom()->getName();
            $m->getTo = $message->getTo();
            $m->date = $message->getDate();
            $m->receivedDate = $message->getDate()->format('Y-m-d h:m:s');
            $m->isSeen = $message->isSeen();
            $m->body = $message->keepUnseen()->getBodyHtml();
            $m->body_text = $message->keepUnseen()->getBodyText();

            $inbox[] = $m;
        }

        return $inbox;
    }

} 