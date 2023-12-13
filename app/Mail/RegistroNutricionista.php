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

    public $userId, $passwordTemporal, $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userId, $passwordTemporal, $email)
    {
        $this->userId = $userId;
        $this->passwordTemporal = $passwordTemporal;
        $this->email = $email;
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
        $logo = public_path('img/logo.jpeg');
        return $this->view('emails.registro-nutricionista')
        ->with(['userId' => $this->userId, 'passwordTemporal' => $this->passwordTemporal, 'email' => $this->email])
        ->subject('Finalice con el proceso de registro')
        ->attach($logo, [
            'as' => 'logo.jpeg',
            'mime' => 'image/jpeg',
        ]);
    }
}
