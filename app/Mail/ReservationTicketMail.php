<?php

namespace App\Mail;

use App\Models\Reservation;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationTicketMail extends Mailable
{
    use Queueable, SerializesModels;

    public Reservation $reservation;

    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    public function build()
    {
        $this->reservation->load([
            'tickets.screening.movie',
            'tickets.screening.room',
            'tickets.seat',
        ]);

        $pdf = Pdf::loadView(
            'tickets.pdf',
            [
                'tickets' => $this->reservation->tickets,
            ]
        );

        return $this
            ->subject('Potwierdzenie zakupu biletów - Peqursor')
            ->view('emails.reservation-confirmed')
            ->with([
                'reservation' => $this->reservation,
            ])
            ->attachData(
                $pdf->output(),
                'bilety-' . $this->reservation->id . '.pdf',
                [
                    'mime' => 'application/pdf',
                ]
            );
    }
}
