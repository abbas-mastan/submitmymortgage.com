<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class FileUploadNotification extends Notification
{
    use Queueable;
    public $filetype;
    public $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($filetype,$user)
    {
        $this->filetype = $filetype;
        $this->user = $user;
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
            'filetype' => $this->filetype,
            'user_name'=>$this->user->name,
            'user_id'=>$this->user->id,
        ];
    }
}
