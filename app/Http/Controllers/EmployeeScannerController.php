<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmployeeScannerController extends Controller
{
    public function index(): View
    {
        return view('employee.scanner');
    }
    public function verify(Request $request): JsonResponse
    {
        $request->validate([
            'qr_code' => ['required', 'string'],
        ]);

        $ticket = Ticket::with([
            'reservation',
            'screening.movie',
            'screening.room',
            'seat',
        ])->where('qr_code', $request->qr_code)->first();

        if (!$ticket) {
            return response()->json([
                'success' => false,
                'status' => 'invalid',
                'message' => 'Nie znaleziono takiego biletu.',
            ], 404);
        }

        if ($ticket->status === 'cancelled') {
            return response()->json([
                'success' => false,
                'status' => 'cancelled',
                'message' => 'Ten bilet został anulowany.',
            ]);
        }

        if ($ticket->status === 'used') {
            return response()->json([
                'success' => false,
                'status' => 'used',
                'message' => 'Ten bilet został już wykorzystany.',
                'used_at' => $ticket->used_at?->format('d.m.Y H:i:s'),
            ]);
        }

        if ($ticket->reservation->status !== 'confirmed') {
            return response()->json([
                'success' => false,
                'status' => 'unconfirmed',
                'message' => 'Rezerwacja tego biletu nie jest potwierdzona.',
            ]);
        }

        $screeningStart = $ticket->screening->start_time->copy();

        $screeningEnd = $screeningStart->copy()
            ->addMinutes($ticket->screening->movie->duration);

        $entryStart = $screeningStart->copy()
            ->subHour();

        $now = now();

        /*
        * Za wcześnie na wejście.
        * Można sprawdzać bilet dopiero godzinę przed seansem.
        */
        if ($now->lt($entryStart)) {
            return response()->json([
                'success' => false,
                'status' => 'too_early',
                'message' => 'Seans jeszcze się nie odbył.',
                'screening' => $screeningStart->format('d.m.Y H:i'),
                'entry_from' => $entryStart->format('d.m.Y H:i'),
            ]);
        }

        /*
        * Seans już się zakończył.
        */
        if ($now->gt($screeningEnd)) {
            return response()->json([
                'success' => false,
                'status' => 'expired',
                'message' => 'Termin seansu minął.',
                'screening' => $screeningStart->format('d.m.Y H:i'),
                'screening_end' => $screeningEnd->format('d.m.Y H:i'),
            ]);
        }

        /*
        * Bilet jest w prawidłowym czasie.
        */
        $ticket->update([
            'status' => 'used',
            'used_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'status' => 'valid',
            'message' => 'Bilet został pomyślnie wykorzystany.',
            'ticket' => [
                'id' => $ticket->id,
                'movie' => $ticket->screening->movie->title,
                'room' => $ticket->screening->room->room_name,
                'seat' => $ticket->seat->row . $ticket->seat->number,
                'screening_date' => $screeningStart->format('d.m.Y'),
                'screening_time' => $screeningStart->format('H:i'),
                'price' => $ticket->ticket_price,
            ],
        ]);
    }
}
