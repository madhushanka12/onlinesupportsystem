<?php

namespace Domain\Ticket\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public function __construct($ticket)
    {
        $this->ticket = $ticket;
    }


    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Success Ticket Store',
        );
    }


    public function content(): Content
    {
        return new Content(
            view: 'emails.ticket',
        );
    }


    public function attachments(): array
    {
        return [];
    }
}
