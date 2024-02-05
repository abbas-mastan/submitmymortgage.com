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
    public $cat;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $message,$project = null,$cat = null)
    {
        $this->user = $user;
        $this->message = $message;
        $this->project = $project; 
        $this->cat = $cat; 
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
            'message' => $this->message,
        ];
        
        if ($this->project) {
            $data['project'] = $this->project;
        }
       
        if ($this->cat) {
            $data['category'] = $this->cat;
        }
        return $data;
    }
}
