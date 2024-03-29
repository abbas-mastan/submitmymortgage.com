<?php

namespace App\Notifications;

use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TeamNotification extends Notification
{
    use Queueable;
    public $user;
    public $team;
    public $company;

    public function __construct($user,Request $request)
    {
        $this->user = $user;
        $this->team = $request->name;
        $this->company = $request->company;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }
    public function toArray($notifiable)
    {
        $data = [
            'user_name' => $this->user->name,
            'user_id' => $this->user->id,
            'team' => $this->team,
            'company' => $this->company,
            ];
        return $data;
    }
}
