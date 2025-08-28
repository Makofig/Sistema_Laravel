<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Quota;

class QuotaGeneratedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $quota;
    public $status;
    public $errorMessage;

    /**
     * Create a new message instance.
     */
    public function __construct(Quota $quota = null, string $status = 'success', string $errorMessage = null)
    {
        $this->quota = $quota;
        $this->status = $status;
        $this->errorMessage = $errorMessage;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->status === 'success'
            ? "✅ Nueva cuota generada - {$this->quota?->created_at->format('Y-m-d')}"
            : "⚠️ Error al generar cuota";

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.quota-generated',
            with: [
                'quota' => $this->quota,
                'status' => $this->status,
                'errorMessage' => $this->errorMessage,
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
