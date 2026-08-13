<?php

namespace App\Http\Controllers;

use App\Models\Screening;
use App\Models\ReservationSeat;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ScreeningsController extends Controller
{
    // Obsluga wyswietlania seansow na stronie glowniej
    public function index(Request $request){
        // Jeżeli nie podano daty, wybierz dzisiaj
        $selectedDate = $request->get('date', today()->format('Y-m-d'));

        $screenings = Screening::with(['movie.genres', 'room'])
            ->whereDate('start_time', $selectedDate)
            ->orderBy('start_time')
            ->get();

        // 7 najbliższych dni
        $dates = collect();

        for ($i = 0; $i < 7; $i++) {
            $date = today()->addDays($i);

            $dates->push([
                'date' => $date->format('Y-m-d'),
                'label' => match ($i) {
                    0 => 'Dzisiaj',
                    1 => 'Jutro',
                    default => $date->format('d.m'),
                },
            ]);
        }

        // Grupujemy seanse po filmach, żeby wyświetlić je w widoku
        $groupedScreenings = $screenings->groupBy('movie_id');

        return view('welcome', [
            'screenings' => $groupedScreenings,
            'dates' => $dates,
            'selectedDate' => $selectedDate,
        ]);
    }

    // Wyświetla szczegóły seansu
    public function show(Screening $screening)
    {
        $screening->load([
            'movie',
            'room.seats'
        ]);

        return view(
            'screenings.show',
            compact('screening')
        );
    }

    // Obsluga rezerwacji miejsc na seans
    public function seats($id){
        $screening = Screening::with('movie', 'room')
            ->findOrFail($id);

        // Wszystkie miejsca należące do sali tego seansu
        $seats = $screening->room->seats()
            ->orderBy('row')
            ->orderBy('number')
            ->get();

        // ID miejsc zajętych w tym konkretnym seansie
        $reservedSeats = ReservationSeat::whereHas('reservation', function ($query) use ($screening) {
            $query->where('screening_id', $screening->id)
                ->whereIn('status', ['pending', 'confirmed']);
        })
        ->pluck('seat_id');

        return view('screenings.seats', compact(
            'screening',
            'seats',
            'reservedSeats'
        ));
    }
}
