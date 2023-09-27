<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistroNutricionista extends Mailable
{
    use Queueable, SerializesModels;

    public $nutricionista;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nutricionista)
    {
        $this->nutricionista = $nutricionista;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Registro Nutricionista',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return view('emails.registro-nutricionista');
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }

    public function build(){
        return $this->view('emails.registro-nutricionista')
        ->with(['nutricionista' => $this->nutricionista])
        ->subject('Finalice con el proceso de registro');
    }
}