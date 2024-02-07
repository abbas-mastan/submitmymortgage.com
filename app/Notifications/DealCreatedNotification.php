<?php

namespace App\Notifications;

use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class DealCreatedNotification extends Notification
{
    use Queueable;
    public $user;
    public $project;
    public $company;

    public function __construct($user,Request $request)
    {
        $this->user = $user;
        $this->project = $request->id;
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
            'project' => $this->project,
            'company' => $this->company,
            ];
        return $data;
    }


}
