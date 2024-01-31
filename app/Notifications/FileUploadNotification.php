<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class FileUploadNotification extends Notification
{
    use Queueable;
    public $user;
    public $message;
    public $project;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $message,$project = null)
    {
        $this->user = $user;
        $this->project = $project;
        $this->message = $message;
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
        return [
            'user_name' => $this->user->name,
            'user_id' => $this->user->id,
            'message' => $this->message,
            'project' => $this->project
        ];
    }
}
