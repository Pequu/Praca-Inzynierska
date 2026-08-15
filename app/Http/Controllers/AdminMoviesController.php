<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

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
            ->orderBy('title','asc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.movies.index', compact('movies'));
    }

    public function edit(Movie $movie)
    {
        $movies = Movie::query();

        return view('admin.movies.edit', compact('movie','movies'));
    }

    public function update(Request $request, Movie $movie)
    {
        $validated = $request->validate([
            'title' => ['required','string','max:255',],
            'description' => ['required','string',],
            'duration' => ['required','integer','min:1','max:999',],
            'release_date' => ['required','date',],
            'age_rating' => ['required','string','max:4',],
            'poster' => ['nullable','string','max:255',],
        ]);

        $movie->title = $validated['title'];
        $movie->description = $validated['description'];
        $movie->duration = $validated['duration'];
        $movie->release_date = $validated['release_date'];
        $movie->age_rating = $validated['age_rating'];
        $movie->poster = $validated['poster'] ?? null;

        $movie->save();

        return redirect()
            ->route('admin.movies.index')
            ->with('success', 'Dane filmu zostały zaktualizowane.');
    }

    public function destroy(Movie $movie)
    {
        $movie->delete();

        return redirect()
            ->route('admin.movies.index')
            ->with('success', 'Film został usunięty.');
    }
}
