<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Appointment $appointment,
        public string $confirmUrl
    ) {}

    public function build()
    {
        return $this->subject('Confirmez votre rendez-vous – Fedumcia')
    ->view('emails.appointments.confirm', [
        'appointment' => $this->appointment,
        'confirmUrl' => $this->confirmUrl,
    ]);

    }
}
