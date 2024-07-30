<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProsesPesanan extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $total_berat;
    public $jumlah;
    public $total_bayar;
    public $status_pembayaran;

    /**
     * Create a new message instance.
     */
    public function __construct($name, $total_berat, $jumlah, $total_bayar, $status_pembayaran)
    {
        $this->name = $name;
        $this->total_berat = $total_berat;
        $this->jumlah = $jumlah;
        $this->total_bayar = $total_bayar;
        $this->status_pembayaran = $status_pembayaran;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tia Laundry - Proses Pesanan',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.prosespesanan',
            with: [
                'name' => $this->name,
                'total_berat' => $this->total_berat,
                'jumlah' => $this->jumlah,
                'total_bayar' => $this->total_bayar,
                'status_pembayaran' => $this->status_pembayaran,
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
