<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class JemputPesanan extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $kurirName;
    public $kurirPhone;

    /**
     * Create a new message instance.
     */
    public function __construct($name, $kurirName, $kurirPhone)
    {
        $this->name = $name;
        $this->kurirName = $kurirName;
        $this->kurirPhone = $kurirPhone;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tia Laundry - Kurir Sedang Menuju Lokasi untuk Penjemputan Pakaian',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.jemputpesanan',
            with: [
                'name' => $this->name,
                'kurirName' => $this->kurirName,
                'kurirPhone' => $this->kurirPhone
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
