<?php

namespace App\Console\Commands;

use App\Mail\AdminEmail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-email-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command Test Schedule';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        //
        Mail::to('shahriarabiddut@gmail.com')->send(new AdminEmail('Test Schedule', 'Test Schedule', 'Test Schedule'));
    }
}
