<?php

namespace App\Http\Controllers;

use App\Models\Screening;
use App\Models\Seat;
use App\Models\Reservation;
use App\Models\ReservationSeat;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\ReservationTicketMail;
use Illuminate\Support\Facades\Mail;

class ReservationController extends Controller
{
    // Obsługa wyświetlania strony checkout dla rezerwacji
    public function checkout(Request $request, Screening $screening)
    {
        $validated = $request->validate([
            'seat_ids' => ['required', 'array', 'min:1'],
            'seat_ids.*' => ['integer', 'exists:seats,id'],
        ]);


        $seats = Seat::whereIn('id', $validated['seat_ids'])
        ->where('room_id', $screening->room_id)
        ->get();


        if ($seats->count() !== count($validated['seat_ids'])) {
            return back()->withErrors([
                'seat_ids' => 'Wybrano nieprawidłowe miejsca.'
            ]);
        }


        $reservedSeatIds = ReservationSeat::whereHas(
            'reservation',
            function ($query) use ($screening) {
                $query->where('screening_id', $screening->id)
                    ->whereIn('status', [
                        'pending',
                        'confirmed',
                    ]);
            }
        )
        ->whereIn('seat_id', $validated['seat_ids'])
        ->pluck('seat_id');


        if ($reservedSeatIds->isNotEmpty()) {
            return back()->withErrors([
                'seat_ids' => 'Jedno z wybranych miejsc zostało właśnie zajęte.'
            ]);
        }


        $totalPrice = $seats->count() * $screening->screening_price;


        return view('screenings.checkout', [
            'screening' => $screening->load([
                'movie',
                'room',
            ]),
            'seats' => $seats,
            'totalPrice' => $totalPrice,
        ]);
    }


    // Obsługa tworzenia rezerwacji
    public function store(Request $request, Screening $screening)
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:100'],
            'customer_surname' => ['required', 'string', 'max:100'],
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:30'],

            'payment_method' => [
                'required',
                'in:blik,card,cash',
            ],

            'terms_accepted' => ['accepted'],
            'privacy_policy_accepted' => ['accepted'],
            'marketing_accepted' => ['nullable', 'boolean'],

            'seat_ids' => ['required', 'array', 'min:1'],
            'seat_ids.*' => ['integer', 'exists:seats,id'],
        ]);


        $seats = Seat::whereIn('id', $validated['seat_ids'])
            ->where('room_id', $screening->room_id)
            ->get();


        if ($seats->count() !== count($validated['seat_ids'])) {
            return back()->withErrors([
                'seat_ids' => 'Wybrano nieprawidłowe miejsca.'
            ])->withInput();
        }


        $reservedSeatIds = ReservationSeat::whereHas(
            'reservation',
            function ($query) use ($screening) {
                $query->where('screening_id', $screening->id)
                    ->whereIn('status', [
                        'pending',
                        'confirmed',
                    ]);
            }
        )
        ->whereIn('seat_id', $validated['seat_ids'])
        ->pluck('seat_id');


        if ($reservedSeatIds->isNotEmpty()) {
            return back()->withErrors([
                'seat_ids' => 'Jedno z wybranych miejsc zostało właśnie zajęte.'
            ])->withInput();
        }


        $totalPrice = $seats->count() * $screening->screening_price;


        $reservation = DB::transaction(function () use (
            $validated,
            $screening,
            $seats,
            $totalPrice
        ) {
            $reservation = Reservation::create([
                'user_id' => Auth::id(),
                'access_token' => Str::random(64),
                'screening_id' => $screening->id,
                'status' => 'pending',
                'total_price' => $totalPrice,

                'customer_name' => $validated['customer_name'],
                'customer_surname' => $validated['customer_surname'],
                'customer_phone' => $validated['customer_phone'],
                'customer_email' => $validated['customer_email'],

                'payment_method' => $validated['payment_method'],

                'terms_accepted' => true,
                'privacy_policy_accepted' => true,
                'marketing_accepted' => $validated['marketing_accepted'] ?? false,
            ]);


            foreach ($seats as $seat) {
                ReservationSeat::create([
                    'reservation_id' => $reservation->id,
                    'seat_id' => $seat->id,
                ]);
            }


            return $reservation;
        });


        return redirect()->route(
            'reservations.payment',
            $reservation
        );
    }

    // Wyświetlanie strony płatności dla rezerwacji
    public function payment(Reservation $reservation)
    {
        $reservation->load([
            'screening.movie',
            'screening.room',
            'reservationSeats.seat',
        ]);

        return view('reservations.payment', [
            'reservation' => $reservation,
        ]);
    }

    // Potwierdzenie płatności dla rezerwacji
   public function confirmPayment(Reservation $reservation)
    {
        if ($reservation->status !== 'pending') {
            return redirect()
                ->route('reservations.payment', $reservation)
                ->with('error', 'Ta rezerwacja nie wymaga już płatności.');
        }

        DB::transaction(function () use ($reservation) {
            $reservation->load([
                'screening',
                'reservationSeats.seat',
            ]);

            $reservation->update([
                'status' => 'confirmed',
            ]);

            foreach ($reservation->reservationSeats as $reservationSeat) {
                Ticket::create([
                    'reservation_id' => $reservation->id,
                    'user_id' => $reservation->user_id,
                    'screening_id' => $reservation->screening_id,
                    'seat_id' => $reservationSeat->seat_id,
                    'qr_code' => (string) Str::uuid(),
                    'status' => 'valid',
                    'ticket_price' => $reservation->screening->screening_price,
                ]);
            }
        });

        Mail::to($reservation->customer_email)
            ->send(new ReservationTicketMail($reservation));

        return redirect()->route('reservations.confirmation', [
            'reservation' => $reservation,
            'access_token' => $reservation->access_token,
        ]);
    }

    // Strona potwierdzenia zakupu
    public function confirmation(Reservation $reservation, string $access_token) {
        if (!hash_equals($reservation->access_token, $access_token)) {
            abort(404);
        }

        if ($reservation->status !== 'confirmed') {
            return redirect()
                ->route('reservations.payment', $reservation)
                ->with(
                    'error',
                    'Ta rezerwacja nie została jeszcze opłacona.'
                );
        }

        $reservation->load([
            'screening.movie',
            'screening.room',
            'reservationSeats.seat',
            'tickets',
        ]);

        return view('reservations.confirmation', [
            'reservation' => $reservation,
        ]);
    }

    // Generowanie pliku PDF z biletami dla rezerwacji
    public function ticketsPdf(Reservation $reservation, string $access_token)
    {
        if (!hash_equals($reservation->access_token, $access_token)) {
            abort(404);
        }

        if ($reservation->status !== 'confirmed') {
            abort(404);
        }

        $reservation->load([
            'tickets.screening.movie',
            'tickets.screening.room',
            'tickets.seat',
        ]);

        $pdf = Pdf::loadView('tickets.pdf', ['tickets' => $reservation->tickets]);

        return $pdf->download('bilety-' . $reservation->id . '.pdf');
    }
}
