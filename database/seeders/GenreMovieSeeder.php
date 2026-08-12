<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Movie;
use App\Models\Genre;

class GenreMovieSeeder extends Seeder
{
    public function run(): void
    {
        $movieGenres = [
            'Diuna: Część druga' => [
                'Sci-Fi',
                'Akcja',
                'Przygodowy',
                'Dramat',
            ],

            'Oppenheimer' => [
                'Dramat',
                'Historyczny',
            ],

            'Avatar: Istota wody' => [
                'Sci-Fi',
                'Akcja',
                'Przygodowy',
                'Fantasy',
            ],

            'Top Gun: Maverick' => [
                'Akcja',
                'Dramat',
                'Przygodowy',
            ],

            'Minecraft: Film' => [
                'Fantasy',
                'Przygodowy',
                'Familijny',
                'Komedia',
            ],

            'Interstellar' => [
                'Sci-Fi',
                'Dramat',
                'Przygodowy',
            ],

            'Kraina Lodu 2' => [
                'Animacja',
                'Fantasy',
                'Familijny',
                'Przygodowy',
                'Muzyczny',
            ],

            'Joker' => [
                'Dramat',
                'Thriller',
                'Kryminał',
            ],
        ];

        foreach ($movieGenres as $movieTitle => $genres) {

            $movie = Movie::query()
                ->where('title', '=', $movieTitle)
                ->first();

            if (!$movie) {
                continue;
            }

            foreach ($genres as $genreName) {

                $genre = Genre::query()
                    ->where('name', '=', $genreName)
                    ->first();

                if (!$genre) {
                    continue;
                }

                $movie->genres()->syncWithoutDetaching($genre->id);
            }
        }
    }
}
