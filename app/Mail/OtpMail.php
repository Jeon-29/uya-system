<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param  string  $otp  The plain 6-digit code to display in the email.
     * @param  string  $purpose  Either "verification" or "password reset" — used in the copy.
     */
    public function __construct(
        public string $otp,
        public string $purpose = 'verification',
    ) {}

    public function envelope(): Envelope
    {
        $subject = $this->purpose === 'password reset'
            ? 'Your UYA Connect password reset code'
            : 'Your UYA Connect verification code';

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.otp',
            with: [
                'otp' => $this->otp,
                'purpose' => $this->purpose,
            ],
        );
    }
}
