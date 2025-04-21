<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactoMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $contacto;
    public $subject;
    
    public function __construct($contacto)
    {
        $this->from($contacto['correo_remitente']);
        $this->contacto = $contacto;
        $this->subject = $contacto['asunto'];

    }
    public function build(){
        return $this->view('emails.email_reporte');
    }
}

/*
class ContactoMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $contacto;

    public function __construct($contacto)
    {
        $this->contacto = $contacto;
        $this->subject = $contacto['asunto'];
    }

    public function build()
    {
        return $this->from($this->contacto['correo_remitente'])
                    ->subject($this->subject)
                    ->view('emails.email')
                    ->with('contacto', $this->contacto);
    }
}
 */
