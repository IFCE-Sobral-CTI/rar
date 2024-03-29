<?php

namespace App\Mail;

use App\Models\AccessToken;
use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendToReprography extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        private Report $report,
        private AccessToken $token
    )
    {
        $this->afterCommit();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Cartões para impressão',
            to: new Address( 'reprografia.sobral@ifce.edu.br', 'reprografia.sobral@ifce.edu.br'),
            tags: ['IFCE'],
            metadata: [
                'report_id' => $this->report->id,
                'access_token' => $this->token->token
            ]
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.sendToReprography',
            with: [
                'report' => $this->report,
                'token' => $this->token->token
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
        return [
            Attachment::fromStorage($this->report->file)
                ->as('file.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
