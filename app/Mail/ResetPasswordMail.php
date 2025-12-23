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

    // Constructor - Recibe el enlace de recuperación
    public function __construct(public string $resetLink)
    {
    }

    // envelope - Define el asunto del email
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Recupera tu contraseña - Netflix',
        );
    }

    // content - Define la vista y variables que se usan en el email
    public function content(): Content
    {
        return new Content(
            view: 'emails.reset-password',
            with: [
                'resetLink' => $this->resetLink,
            ]
        );
    }

    // attachments - Define los archivos adjuntos (actualmente vacío)
    public function attachments(): array
    {
        return [];
    }
}
