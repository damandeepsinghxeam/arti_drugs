<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class GeneralMail extends Mailable
{

    use Queueable, SerializesModels;
    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct($mail_data)
    {
        $this->mail_data = $mail_data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */

    public function build()
    {
        return $this->from('XEAMHR@xeamventures.com')
                    ->subject($this->mail_data['subject'])
                    ->view('emails.general_mail')
                    ->with([
                        'mail_data' => $this->mail_data
                    ]);

    }

}

