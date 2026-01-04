<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    // Constructor - Recibe el código de recuperación y el email del usuario
    public function __construct(public string $resetCode, public string $userEmail)
    {
    }

    // envelope - Define el asunto del email y el destinatario
    public function envelope(): Envelope
    {
        return new Envelope(
            to: $this->userEmail,
            subject: 'Código de recuperación - Cinema UAS',
        );
    }

    // content - Define la vista y variables que se usan en el email
    public function content(): Content
    {
        return new Content(
            view: 'emails.reset-password',
            with: [
                'resetLink' => $this->resetCode,
            ]
        );
    }

    // attachments - Define los archivos adjuntos (actualmente vacío)
    public function attachments(): array
    {
        return [];
    }
}
