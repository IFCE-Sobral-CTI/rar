<?php

namespace App\Mail;

use App\Models\Requirement;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CreateRequirementMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public Requirement $requirement
    )
    {
        $this->afterCommit();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        if ($this->requirement->enrollment->student->institutional_email) {
            $replyTo = new Address($this->requirement->enrollment->student->personal_email, $this->requirement->enrollment->student->name);
        } else {
            $replyTo = new Address($this->requirement->enrollment->student->institutional_email, $this->requirement->enrollment->student->name);
        }

        return new Envelope(
            subject: 'Requerimento de Acesso ao Restaurante Acadêmico',
            from: new Address($this->requirement->enrollment->student->personal_email, $this->requirement->enrollment->student->name),
            replyTo: [
                $replyTo,
            ],
            tags: ['IFCE'],
            metadata: [
                'requirement_id' => $this->requirement->id,
            ]
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.createRequirement',
            with: [
                'requirement' => $this->requirement
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
