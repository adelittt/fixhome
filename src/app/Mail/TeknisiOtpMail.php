<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TeknisiOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $otpCode,
        public string $recipientName = 'Calon Mitra Teknisi',
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Kode Verifikasi Pendaftaran Mitra Teknisi FixHome: {$this->otpCode}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.teknisi-otp',
            with: [
                'otpCode' => $this->otpCode,
                'recipientName' => $this->recipientName,
            ],
        );
    }
}
