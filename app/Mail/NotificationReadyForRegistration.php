<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotificationReadyForRegistration extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = 'Inscripción registral';

    public $credit;

    /**
     * Create a new message instance.
     * @var $credit
     * @return void
     */
    public function __construct($credit)
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.notification_gerency');
    }

}
