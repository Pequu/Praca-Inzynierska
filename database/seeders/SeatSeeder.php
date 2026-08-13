<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;
use App\Models\Seat;

class SeatSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = Room::all();

        foreach ($rooms as $room) {

            // Liczba rzędów i miejsc w rzędzie
            switch ($room->name) {

                case 'IMAX':
                    $rows = 14;
                    $seatsPerRow = 16;
                    break;

                case 'Dream':
                    $rows = 6;
                    $seatsPerRow = 10;
                    break;

                default:
                    $rows = 10;
                    $seatsPerRow = 12;
                    break;
            }

            for ($row = 0; $row < $rows; $row++) {

                // A, B, C, D...
                $rowLetter = chr(65 + $row);

                for ($number = 1; $number <= $seatsPerRow; $number++) {

                    Seat::create([
                        'room_id' => $room->id,
                        'row' => $rowLetter,
                        'number' => $number,
                        'x' => $number,
                        'y' => $row,
                        'type' => 'standard',
                    ]);
                }
            }
        }
    }
}
