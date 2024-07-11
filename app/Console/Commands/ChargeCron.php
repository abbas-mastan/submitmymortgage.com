<?php

namespace App\Console\Commands;

use Faker\Factory;
use App\Models\User;
use Illuminate\Console\Command;

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
        $factory = Factory::create();
        User::create([
            'name' => $factory->userName(),
            'email' => $factory->userName().'@gmail.com',
            'finance_type' => 'Purchase',
            'loan_type' => 'Private Loan',
            'password' => bcrypt($factory->password()),
        ]);
    }
}
