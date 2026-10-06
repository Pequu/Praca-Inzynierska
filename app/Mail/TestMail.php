<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    public function build()
    {
        return $this
            ->subject('Test wiadomości - Peqursor')
            ->html('
                <h1>Test Peqursor</h1>
                <p>Jeżeli widzisz tę wiadomość w Mailtrap, konfiguracja SMTP działa poprawnie.</p>
            ');
    }
}
