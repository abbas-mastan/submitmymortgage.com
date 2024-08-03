<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use App\Mail\TrialExpirationReminderMail;

class ChargeCron extends Command
{
    protected $signature = 'charge:cron';
    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        try {
            $targetDate = Carbon::now()->subDays(11)->toDateString();
            // Retrieve users with the role 'Admin' who were created exactly 11 days ago
            $users = User::where('role', 'Admin')
                ->whereDate('created_at', $targetDate)
                ->get();
            foreach ($users as $user) {
                $meta = $user->metas()->where('meta_key', 'email_sent')->first();
                if (!$meta && !$user->subscriptionDetails->stripe_subscription_id) {
                    $this->sendEmail($user->email);
                    $user->metas()->create([
                        'meta_key' => 'email_sent',
                        'meta_value' => now(),
                    ]);
                }
            }
        } catch (\Exception $ex) {
            Log::info($ex->getMessage());
            $data = ['message' => $ex->getMessage()];
            Mail::mailer('super_admin')->send('notifications::expiration-reminder-failed-mail-to-super-admin', $data, function ($message) {
                $message->to('shaun@submitmymortgage.com');
                $message->subject('Trial Expiration Reminder Failed');
                $message->from(env('SUPER_ADMIN_MAIL_FROM_ADDRESS'));
            });
        }
    }

    public function sendEmail($email)
    {
        $url = function () {return URL::signedRoute('continue.signup');};
        Mail::to($email)->send(new TrialExpirationReminderMail($url()));
    }
}
