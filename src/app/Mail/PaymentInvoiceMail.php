<?php

namespace App\Mail;

use App\Models\Booking;
use App\Models\Transaksi;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $invoiceNumber;

    public function __construct(
        public Booking $booking,
        public Transaksi $transaksi,
    ) {
        $this->invoiceNumber = 'INV-FH-' . str_pad((string) $booking->id, 5, '0', STR_PAD_LEFT);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Pembayaran Berhasil — Invoice {$this->invoiceNumber} (FixHome)",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.payment-invoice',
            with: [
                'booking' => $this->booking,
                'transaksi' => $this->transaksi,
                'invoiceNumber' => $this->invoiceNumber,
            ],
        );
    }
}
