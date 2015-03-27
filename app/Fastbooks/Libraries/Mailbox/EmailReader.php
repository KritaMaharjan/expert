<?php
namespace App\Fastbooks\Libraries\Mailbox;

use Ddeboer\Imap\Search\Date\After;
use Ddeboer\Imap\SearchExpression;
use Ddeboer\Imap\Server;

class EmailReader {

    public $folder = 'INBOX';

    private $host;
    private $port;
    private $email;
    private $password;
    private $connection;
    private $error;

    function __construct($host, $email, $password, $port=993)
    {
        $this->host = $host;
        $this->email = $email;
        $this->password = $password;
        $this->port = $port;

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

    function getMailbox()
    {
        return $this->connection->getMailbox($this->folder);
    }

    function messageSince($date)
    {
        $mailbox = $this->getMailbox();
        $search = new SearchExpression();
        $since = new \DateTime($date);
        $search->addCondition(new After($since));

        return $mailbox->getMessages($search);
    }


    function read()
    {
        ini_set('max_execution_time', 300);

        $messages = $this->messageSince('2015-03-26');
        $inbox = array();
        foreach ($messages as $message) {
            $m = new \stdClass();
            $m->getSubject = $message->getSubject();
            $m->getFrom = $message->getFrom();
            $m->getTo = $message->getTo();
            $m->getDate = $message->getDate();
            $m->isSeen = $message->isSeen();
            $m->body = $message->keepUnseen()->getBodyHtml();
            $inbox[] = $m;
        }

        return $inbox;
    }

} 