<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotificationReadyForRegistration extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $subject = 'Inscripción registral';

    public $credito;

    /**
     * Create a new message instance.
     * @var $credit
     * @return void
     */
    public function __construct($credito)
    {
        $this->credito = $credito;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.notification_gerency');
    }

}
