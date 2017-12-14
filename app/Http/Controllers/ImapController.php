<?php

namespace App\Http\Controllers;

use Ddeboer\Imap\Server;

class ImapController extends Controller
{
    
    public $server;
    public $connection;
    
    
    public function __construct()
    {
        $this->server     = new Server(config('imap.host'));
        $this->connection = $this->server->authenticate(config('imap.username'), config('imap.password'));
    }
    
    
    public function execute()
    {
        $this->checkInboxesAndCreateIfProcessed();
        $processed = $this->connection->getMailbox('Processed');
        $inbox     = $this->connection->getMailbox('INBOX');
        $messages  = $inbox->getMessages();
        foreach ($messages as $message) {
            $attachments = $message->getAttachments();
            foreach ($attachments as $attachment) {
                file_put_contents(storage_path('attachments/') . $attachment->getFilename(),
                    $attachment->getDecodedContent());
            }
            $message->move($processed);
        }
    }
    
    
    public function checkInboxesAndCreateIfProcessed()
    {
        $mailboxes = $this->connection->getMailboxes();
        if ( ! array_key_exists('Processed', $mailboxes)) {
            $this->connection->createMailbox('Processed');
        }
    }
    
    
    public function moveBackFromProcessed()
    {
        $processed = $this->connection->getMailbox('Processed');
        $inbox     = $this->connection->getMailbox('INBOX');
        $messages  = $processed->getMessages();
        foreach ($messages as $message) {
            $message->move($inbox);
        }
    }
}
