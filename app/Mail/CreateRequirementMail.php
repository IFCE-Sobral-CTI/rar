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
        $student = $this->requirement->enrollment->student;

        $personal = $student->personal_email ?? null;
        $institutional = $student->institutional_email ?? null;

        $from = null;
        if ($personal) {
            $from = new Address($personal, $student->name);
        } elseif ($institutional) {
            $from = new Address($institutional, $student->name);
        }

        $replyTo = null;
        if ($institutional) {
            $replyTo = new Address($institutional, $student->name);
        } elseif ($personal) {
            $replyTo = new Address($personal, $student->name);
        }

        return new Envelope(
            subject: 'Requerimento de Acesso ao Restaurante Acadêmico',
            from: $from,
            replyTo: $replyTo ? [$replyTo] : null,
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
