<?php

namespace Domain\Ticket\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketReplyMail extends Mailable
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
            subject: 'Reply Ticket',
        );
    }


    public function content(): Content
    {
        return new Content(
            view: 'emails.ticket-reply',
        );
    }


    public function attachments(): array
    {
        return [];
    }
}
