<?php

namespace App\Console\Commands;

use Ddeboer\Imap\Server;
use Illuminate\Console\Command;

class FetchAttachmentsFromMail extends Command
{
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:fetch-attachments-from-mail';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fixes stuff';
    public    $server;
    public    $connection;
    
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->server     = new Server(config('imap.host'));
        $this->connection = $this->server->authenticate(config('imap.username'), config('imap.password'));
    }
    
    
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->go();
    }
    
    
    public function go()
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
}
