<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminMail extends Mailable
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
        return $this->subject('Welcome to Your 7-Day Trial of Submit My Mortgage!')->view('notifications::admin-email',compact('url'));
    }
}
