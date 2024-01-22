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

class CreateDispatchMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public Dispatch $dispatch
    )
    {
        $this->afterCommit();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        if ($this->dispatch->requirement->enrollment->student->institutional_email) {
            $replyTo = new Address($this->dispatch->requirement->enrollment->student->personal_email, $this->dispatch->requirement->enrollment->student->name);
        } else {
            $replyTo = new Address($this->dispatch->requirement->enrollment->student->institutional_email, $this->dispatch->requirement->enrollment->student->name);
        }

        return new Envelope(
            subject: 'Atualização do requerimento de Acesso ao Restaurante Acadêmico',
            from: new Address($this->dispatch->requirement->enrollment->student->personal_email, $this->dispatch->requirement->enrollment->student->name),
            replyTo: [
                $replyTo,
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
            markdown: 'mail.createDispatch',
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
