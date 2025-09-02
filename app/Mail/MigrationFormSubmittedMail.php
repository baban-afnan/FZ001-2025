<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MigrationFormSubmittedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reference;
    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $reference)
    {
        $this->user = $user;
        $this->reference = $reference;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Migration Form Submitted Successfully')
                    ->view('emails.migration_form_submitted');
    }
}
