<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TolakPesanan extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $pemesanan;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $pemesanan)
    {
        $this->user = $user;
        $this->pemesanan = $pemesanan;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tia Laundry - Tolak Pesanan',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.tolakpesanan',
            with: [
                'user' => $this->user,
                'pemesanan' => $this->pemesanan,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
