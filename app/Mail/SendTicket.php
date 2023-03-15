<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class SendTicket extends Mailable
{
    use Queueable, SerializesModels;

    protected $ticket;
    protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($ticket,$user)
    {
        $this->ticket = $ticket;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Ticket Join Event')
            ->view('mails.send_ticket', [
                'ticket' => $this->ticket,
                'user' => $this->user,
            ]);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
