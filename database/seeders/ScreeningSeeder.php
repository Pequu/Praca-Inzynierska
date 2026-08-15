<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\Room;
use App\Models\Screening;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ScreeningSeeder extends Seeder
{
    public function run(): void
    {
        $movies = Movie::all();
        $rooms = Room::all();

        if ($movies->isEmpty() || $rooms->isEmpty()) {
            return;
        }

        /*
         * Usuwamy stare seanse.
         * Dzięki temu każdy seed tworzy świeży repertuar.
         */
        Screening::query()->delete();

        /*
         * Godziny rozpoczęcia seansów.
         */
        $times = [
            '10:00',
            '12:15',
            '14:30',
            '16:45',
            '19:00',
            '21:15',
        ];

        /*
         * Generujemy repertuar na 7 dni.
         */
        for ($day = -1; $day < 7; $day++) {

            /*
             * Każdego dnia losujemy liczbę seansów.
             */
            $numberOfScreenings = rand(6, 8);

            /*
             * Zapamiętujemy zajęte sale i godziny,
             * żeby nie stworzyć dwóch seansów w tej samej sali.
             */
            $used = [];

            for ($i = 0; $i < $numberOfScreenings; $i++) {

                /*
                 * Szukamy wolnej kombinacji:
                 * sala + godzina.
                 */
                do {
                    $room = $rooms->random();
                    $time = $times[array_rand($times)];

                    $key = $room->id . '_' . $time;

                } while (in_array($key, $used));

                $used[] = $key;

                /*
                 * Losujemy film.
                 */
                $movie = $movies->random();

                /*
                 * Cena zależna od godziny.
                 */
                $hour = (int) substr($time, 0, 2);

                if ($hour < 12) {

                    $screening_price = rand(1999, 2299) / 100;

                } elseif ($hour < 17) {

                    $screening_screening_price = rand(2499, 2999) / 100;

                } else {

                    $screening_price = rand(2799, 3499) / 100;
                }

                /*
                 * Tworzymy seans.
                 */
                Screening::create([
                    'movie_id' => $movie->id,
                    'room_id' => $room->id,
                    'start_time' => Carbon::today()
                        ->addDays($day)
                        ->setTimeFromTimeString($time),
                    'screening_price' => $screening_price,
                ]);
            }
        }
    }
}
