<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class TrainingMailToSuperAdmin extends Mailable
{
    use Queueable, SerializesModels;
    public $time;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($time)
    {
        $this->time = $time;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $time = $this->time;
        return $this->subject("Training Date & Time")->view('notifications::traing-mail-to-super-admin', compact('time'));
    }
}
