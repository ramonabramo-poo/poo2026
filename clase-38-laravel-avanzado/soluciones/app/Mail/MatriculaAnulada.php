<?php

namespace App\Mail;

use App\Models\Alumno;
use App\Models\Curso;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

// Ejercicio 05
class MatriculaAnulada extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Alumno $alumno,
        public Curso $curso,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Matrícula anulada: {$this->curso->titulo}",
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.matricula-anulada',
        );
    }
}
