<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminMoviesController extends Controller
{
    public function index(Request $request)
    {
        $query = Movie::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where('title', 'like', "%{$search}%");
        }

        $movies = $query
            ->orderBy('title', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.movies.index', compact('movies'));
    }

    public function create()
    {
        $genres = Genre::orderBy('genre_name', 'asc')->get();

        return view('admin.movies.create', compact('genres'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required','string','max:255',],
            'description' => ['required','string',],
            'duration' => ['required','integer','min:1','max:999',],
            'release_date' => ['required','date',],
            'age_rating' => ['required','in:3+,7+,12+,16+,18+',],
            'poster' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:5120',],
            'genres' => ['nullable','array',],
            'genres.*' => ['integer','exists:genres,id',],
        ]);

        if ($request->hasFile('poster')) {
            $validated['poster'] = $request
                ->file('poster')
                ->store('posters', 'public'); //zapisuje w katalogu posters
        }

        $movie = Movie::create($validated);

        $movie->genres()->sync($validated['genres'] ?? []);

        return redirect()
            ->route('admin.movies.index')
            ->with('success', 'Film został dodany.');
    }

    public function edit(Movie $movie)
    {
        $genres = Genre::orderBy('genre_name', 'asc')->get();

        $movie->load('genres');

        return view('admin.movies.edit', compact('movie', 'genres'));
    }

    public function update(Request $request, Movie $movie)
    {
        $validated = $request->validate([
            'title' => ['required','string','max:255',],
            'description' => ['required','string',],
            'duration' => ['required','integer','min:1','max:999',],
            'release_date' => ['required','date',],
            'age_rating' => ['required','in:3+,7+,12+,16+,18+',],
            'poster' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:5120',],
            'genres' => ['nullable','array',],
            'genres.*' => ['integer','exists:genres,id',],
        ]);

        $movie->title = $validated['title'];
        $movie->description = $validated['description'];
        $movie->duration = $validated['duration'];
        $movie->release_date = $validated['release_date'];
        $movie->age_rating = $validated['age_rating'];

        // Usunięcie starego psotera z plików
        if ($request->hasFile('poster')) {
            if ($movie->poster) {
                Storage::disk('public')->delete($movie->poster);
            }

            $movie->poster = $request
                ->file('poster')
                ->store('posters', 'public');
        }

        $movie->touch(); //wymusza zmiane timestampu updated_at na aktualny czas
        $movie->save();

        $movie->genres()->sync($validated['genres'] ?? []);

        return redirect()
            ->route('admin.movies.index')
            ->with('success', 'Dane filmu zostały zaktualizowane.');
    }

    public function destroy(Movie $movie)
    {
        //usunięcie starego postera z plików
        if ($movie->poster) {
            Storage::disk('public')->delete($movie->poster);
        }

        $movie->delete();

        return redirect()
            ->route('admin.movies.index')
            ->with('success', 'Film został usunięty.');
    }
}
