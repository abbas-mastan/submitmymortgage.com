<?php

namespace App\Console\Commands;

use Faker\Factory;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ChargeCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'charge:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $subject = ['data'=> 'test mail'];
        Mail::send('notifications::cancel-subscription-mail',$subject,function($message){
            $message->to('miyodet783@vasomly.com')->subject('test cron');
        });
    }
}
