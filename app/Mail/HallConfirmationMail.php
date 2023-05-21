<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class HallConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    private $hall;
    private $user;
    private $start_time;
    private $end_time;
    private $link;

    /**
     * Create a new message instance.
     */
    public function __construct($hall, $user, $start_time, $end_time, $link)
    {
        $this->hall = $hall;
        $this->user = $user;
        $this->start_time = $start_time;
        $this->end_time = $end_time;
        $this->link = $link;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Youth Center | Hall Booking Confirmation Mail',
            from: 'info@yc.om'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.hall-confirmation',
            with: [
                'hall' => $this->hall,
                'user' => $this->user,
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
                'link' => $this->link,
            ]
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
