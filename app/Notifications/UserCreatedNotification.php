<?php

namespace App\Notifications;

use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserCreatedNotification extends Notification
{
    use Queueable;

    public $user;
    public $user_created;
    public $company;

    public function __construct($user,Request $request)
    {
        $this->user = $user;
        $this->user_created = $request->name;
        $this->company = $request->company;
    }

    public function via($notifiable)
    {
        return ['database'];
    }
    public function toArray($notifiable)
    {
        $data = [
            'user_name' => $this->user->name,
            'user_id' => $this->user->id,
            'user_created' => $this->user_created,
            'company' => $this->company,
            ];
        return $data;
    }
}
