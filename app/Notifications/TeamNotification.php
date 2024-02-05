<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TeamNotification extends Notification
{
    use Queueable;
    public $user;
    public $team;

    public function __construct($user,$team)
    {
        $this->user = $user;
        $this->team = $team;
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
            ];
        return $data;
    }
}
