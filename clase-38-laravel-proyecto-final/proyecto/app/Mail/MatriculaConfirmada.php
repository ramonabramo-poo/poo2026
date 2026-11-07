<?php

namespace App\Mail;

use App\Models\Alumno;
use App\Models\Curso;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

// Un correo: el asunto, la vista y los datos que necesita
class MatriculaConfirmada extends Mailable
{
    use Queueable, SerializesModels;

    // Las propiedades públicas llegan solas a la vista del correo
    public function __construct(
        public Alumno $alumno,
        public Curso $curso,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Matrícula confirmada: {$this->curso->titulo}",
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.matricula-confirmada',
        );
    }
}
