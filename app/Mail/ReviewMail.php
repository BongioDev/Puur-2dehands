<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\User;


class ReviewMail extends Mailable
{
    use Queueable, SerializesModels;

    public $toMail;
    public $guest_id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($toMail, $guest_id)
    {
        $this->toMail = $toMail;
        $this->guest_id = User::where('id', $guest_id)->first();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.reviewMail');
    }
}
