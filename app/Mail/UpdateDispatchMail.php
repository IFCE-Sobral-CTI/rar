<?php

namespace App\Mail;

use App\Models\Dispatch;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UpdateDispatchMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        private Dispatch $dispatch
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
            subject: 'Atualização do requerimento de Acesso ao Restaurante Acadêmico',
            from: new Address($this->dispatch->requirement->enrollment->student->personal_email, $this->dispatch->requirement->enrollment->student->name),
            replyTo: [
                new Address($this->dispatch->requirement->enrollment->student->institutional_email),
            ],
            tags: ['IFCE'],
            metadata: [
                'dispatch_id' => $this->dispatch->id,
            ]
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.updateDispatch',
            with: [
                'dispatch' => $this->dispatch
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
