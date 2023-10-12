<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConfirmarAdelantamientoTurno extends Mailable
{
    use Queueable, SerializesModels;

    public $turnoTemporalId;
    public $fechaAdelantado;
    public $horaAdelantado;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($turnoTemporalId, $fechaAdelantado, $horaAdelantado)
    {
        $this->turnoTemporalId = $turnoTemporalId;
        $this->fechaAdelantado = $fechaAdelantado;
        $this->horaAdelantado = $horaAdelantado;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Confirmar Adelantamiento de Turno',
        );
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
        return $this->view('emails.confirmar-adelantamiento')
        ->with(['turnoTemporalId' => $this->turnoTemporalId, 'fechaAdelantado' => $this->fechaAdelantado, 'horaAdelantado' => $this->horaAdelantado])
        ->subject('Confirmar Adelantamiento de Turno');
    }
}
