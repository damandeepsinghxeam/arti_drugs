<?php



namespace App\Mail;



use Illuminate\Bus\Queueable;

use Illuminate\Mail\Mailable;

use Illuminate\Queue\SerializesModels;

use Illuminate\Contracts\Queue\ShouldQueue;



class ProbationCompletionNotice extends Mailable

{

    use Queueable, SerializesModels;



    /**

     * Create a new message instance.

     *

     * @return void

     */

    public function __construct($mailData)

    {

        $this->mailData = $mailData;

    }



    /**

     * Build the message.

     *

     * @return $this

     */

    public function build()

    {

        return $this->from('XEAMHR@xeamventures.com')

                    ->subject($this->mailData['subject'])

                    ->view('emails.probationCompletionNotice')

                    ->with([

                        'mailData' => $this->mailData

                    ]);

    }

}

