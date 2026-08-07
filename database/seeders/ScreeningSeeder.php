<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Screening;
use App\Models\Movie;
use App\Models\Room;
use Carbon\Carbon;

class ScreeningSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = Room::all();
        $movies = Movie::all();

        if ($rooms->isEmpty() || $movies->isEmpty()) {
            return;
        }

        $screenings = [

            [
                'movie' => 'Diuna: Część druga',
                'room' => 1,
                'time' => '14:30',
                'price' => 29.99,
            ],

            [
                'movie' => 'Diuna: Część druga',
                'room' => 2,
                'time' => '19:00',
                'price' => 34.99,
            ],

            [
                'movie' => 'Oppenheimer',
                'room' => 1,
                'time' => '17:15',
                'price' => 27.99,
            ],

            [
                'movie' => 'Avatar: Istota wody',
                'room' => 3,
                'time' => '16:00',
                'price' => 32.99,
            ],

            [
                'movie' => 'Top Gun: Maverick',
                'room' => 2,
                'time' => '20:30',
                'price' => 25.99,
            ],

            [
                'movie' => 'Minecraft: Film',
                'room' => 1,
                'time' => '12:00',
                'price' => 22.99,
            ],

            [
                'movie' => 'Kraina Lodu 2',
                'room' => 3,
                'time' => '10:30',
                'price' => 19.99,
            ],

            [
                'movie' => 'Joker',
                'room' => 2,
                'time' => '21:00',
                'price' => 26.99,
            ],

            [
                'movie' => 'Interstellar',
                'room' => 4,
                'time' => '18:45',
                'price' => 28.99,
            ],

        ];


        foreach ($screenings as $item) {

            $movie = Movie::query()
            ->where('title', $item['movie'])
            ->first();

            if ($movie) {

                Screening::create([
                    'movie_id' => $movie->id,
                    'room_id' => $item['room'],
                    'start_time' => Carbon::today()
                        ->setTimeFromTimeString($item['time']),
                    'price' => $item['price'],
                ]);

            }
        }
    }
}
