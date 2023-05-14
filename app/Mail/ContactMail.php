<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    private string $fullname;
    private string $phone;
    private string $email;
    private string $subjects;
    private string $messages;

    /**
     * Create a new message instance.
     */
    public function __construct($fullname, $phone, $email, $subject, $message)
    {
        $this->fullname = $fullname;
        $this->phone = $phone;
        $this->email = $email;
        $this->subjects = $subject;
        $this->messages = $message;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Contact Mail | ' . $this->subjects,
            from: 'info@yc.om'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.contact',
            with: [
                'fullname' => $this->fullname,
                'phone' => $this->phone,
                'subject' => $this->subject,
                'email' => $this->email,
                'messages' => $this->messages,
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
