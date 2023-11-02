<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AssistantMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $url;
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $url = $this->url;
        return $this->view('notifications::deal-email',compact('url'));
    }
}
