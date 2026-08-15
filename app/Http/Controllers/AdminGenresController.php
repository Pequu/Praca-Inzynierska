<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;

class AdminGenresController extends Controller
{
    public function index(Request $request){
        $query = Genre::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where('genre_name', 'like', "%{$search}%");
        }

        $genres = $query
            ->orderBy('genre_name','asc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.genres.index', compact('genres'));
    }

     public function edit(Genre $genre)
    {
        $genres = Genre::query();

        return view('admin.genres.edit', compact('genre','genres'));
    }

    public function update(Request $request, Genre $genre)
    {
        $validated = $request->validate([
            'genre_name' => ['required','string','max:255',],
            'color' => ['required','string','max:7',],
        ]);

        $genre->genre_name = $validated['genre_name'];
        $genre->color = $validated['color'];


        $genre->save();

        return redirect()
            ->route('admin.genres.index')
            ->with('success', 'Dane gatunku zostały zaktualizowane.');
    }

    public function destroy(Genre $genre)
    {
        $genre->delete();

        return redirect()
            ->route('admin.movies.index')
            ->with('success', 'Film został usunięty.');
    }
}
