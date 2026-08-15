<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Screening;
use App\Models\Movie;
use App\Models\Room;

class AdminScreeningsController extends Controller
{
    public function index(Request $request)
{
    $query = Screening::with(['movie', 'room']);

    // Filtrowanie seansów: przyszłe / zakończone
    if ($request->get('status') === 'past') {

        $query->where('start_time', '<', now());

    } else {

        // Domyślnie pokazujemy przyszłe seanse
        $query->where('start_time', '>=', now());
    }

    if ($request->filled('search')) {

        $search = $request->search;

        $query->where(function ($query) use ($search) {

            $query->whereHas('movie', function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%");
            });

            $query->orWhereHas('room', function ($query) use ($search) {
                $query->where('room_name', 'like', "%{$search}%");
            });

            $query->orWhere('start_time', 'like', "%{$search}%");
        });
    }

    $screenings = $query
        ->orderBy('start_time')
        ->paginate(10)
        ->withQueryString();

    return view('admin.screenings.index', compact('screenings'));
}

    public function edit(Screening $screening)
    {
        $movies = Movie::orderBy('title','asc')->get();

        $rooms = Room::orderBy('room_name','asc')->get();

        return view('admin.screenings.edit', compact('screening', 'movies', 'rooms')
        );
    }

    public function update(Request $request, Screening $screening)
    {
        $validated = $request->validate([
            'movie_id' => [
                'required',
                'exists:movies,id',
            ],

            'room_id' => [
                'required',
                'exists:rooms,id',
            ],

            'start_time' => [
                    'required',
                    'date'
            ],

            'screening_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'status' => [
                'required',
                'in:scheduled,cancelled,finished',
            ],
        ]);

        $screening->movie_id = $validated['movie_id'];
        $screening->room_id = $validated['room_id'];
        $screening->start_time = $validated['start_time'];
        $screening->screening_price = $validated['screening_price'];
        $screening->status = $validated['status'];

        $screening->save();

        return redirect()
            ->route('admin.screenings.index')
            ->with('success', 'Seans został zaktualizowany.');
    }
}
