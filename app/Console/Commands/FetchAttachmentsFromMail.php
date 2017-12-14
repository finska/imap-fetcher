<?php

namespace App\Console\Commands;

use App\Http\Controllers\ImapController;
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
    
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        (new ImapController())->execute();
    }
}
