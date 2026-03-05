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
        $student = $this->dispatch->requirement->enrollment->student;

        $personal = $student->personal_email ?? null;
        $institutional = $student->institutional_email ?? null;

        // From: prefer personal, fallback to institutional
        $from = null;
        if ($personal) {
            $from = new Address($personal, $student->name);
        } elseif ($institutional) {
            $from = new Address($institutional, $student->name);
        }

        // Reply-To: prefer institutional, fallback to personal
        $replyTo = null;
        if ($institutional) {
            $replyTo = new Address($institutional, $student->name);
        } elseif ($personal) {
            $replyTo = new Address($personal, $student->name);
        }

        return new Envelope(
            subject: 'Atualização do requerimento de Acesso ao Restaurante Acadêmico',
            from: $from,
            replyTo: $replyTo ? [$replyTo] : null,
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
