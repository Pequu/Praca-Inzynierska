<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Screening;
use App\Models\Movie;
use App\Models\Room;
use Carbon\Traits\Timestamp;

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
            'movie_id' => ['required', 'exists:movies,id',],
            'room_id' => ['required', 'exists:rooms,id',],
            'start_time' => ['required', 'date', 'after_or_equal:now'],
            'screening_price' => ['required', 'numeric', 'min:0',],
            'status' => ['required', 'in:scheduled,cancelled,finished',],
        ]);

        if (
            $this->hasConflict(
                $validated['room_id'],
                $validated['start_time'],
                $validated['movie_id'],
                $screening->id
            )
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'start_time' => 'W wybranej sali w tym czasie odbywa się już inny seans.',
                ]);
        }

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

    // Formularz dodawnia seansu
    public function create()
    {
        $movies = Movie::orderBy('title', 'asc')->get();

        $rooms = Room::orderBy('room_name', 'asc')->get();

        return view('admin.screenings.create', compact(
            'movies',
            'rooms'
        ));
    }

    //Zapisanie nowegu seansu
    public function store(Request $request)
    {
        $validated = $request->validate([
            'movie_id' => ['required','exists:movies,id',],
            'room_id' => ['required','exists:rooms,id',],
            'start_time' => ['required', 'date', 'after_or_equal:now'],
            'screening_price' => ['required','numeric','min:0',],
        ]);

        if (
            $this->hasConflict(
                $validated['room_id'],
                $validated['start_time'],
                $validated['movie_id']
            )
        ) {
            return back()
                ->withInput() //farmularz zachowa poprzednie wartości
                ->withErrors([
                    'start_time' => 'W wybranej sali w tym czasie odbywa się już inny seans.',
                ]);
        }

        Screening::create([
            'movie_id' => $validated['movie_id'],
            'room_id' => $validated['room_id'],
            'start_time' => $validated['start_time'],
            'screening_price' => $validated['screening_price'],
            'status' => 'scheduled',
        ]);

        return redirect()
            ->route('admin.screenings.index')
            ->with('success', 'Seans został dodany.');
    }

    private function hasConflict(int $roomId, $startTime, int $movieId, ?int $ignoreScreeningId = null): bool {
        $movie = Movie::findOrFail($movieId);

        $newStart = \Carbon\Carbon::parse($startTime);
        $newEnd = $newStart->copy()->addMinutes($movie->duration); //ustalenie czasu zakończenia

        $query = Screening::with('movie')
            ->where('room_id', $roomId)
            ->where('status', '!=', 'cancelled');

        if ($ignoreScreeningId !== null) {
            $query->where('id', '!=', $ignoreScreeningId);
        }

        $screenings = $query->get();

        foreach ($screenings as $screening) {

            $existingStart = \Carbon\Carbon::parse($screening->start_time);

            $existingEnd = $existingStart
                ->copy()
                ->addMinutes($screening->movie->duration);

            /*
            * Konflikt występuje, gdy przedziały czasowe
            * nakładają się na siebie.
            */
            if (
                $newStart < $existingEnd &&
                $newEnd > $existingStart
            ) {
                return true;
            }
        }

        return false;
    }
}
