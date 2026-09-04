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
            switch ($room->room_name) {

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

            $couch_id = 0;

            for ($row = 0; $row < $rows; $row++) {

                // A, B, C, D...
                $rowLetter = chr(65 + $row);

                for ($number = 1; $number <= $seatsPerRow; $number++) {

                    if($number <= 2 && $rowLetter == 'A' ||
                        $number >= $seatsPerRow - 1 && $rowLetter == 'A'
                    ){
                        Seat::create([
                            'room_id' => $room->id,
                        'row' => $rowLetter,
                        'number' => $number,
                        'x' => $number,
                        'y' => $row + 1,
                        'type' => 'wheelchair',
                        ]);
                    }else if($row >= $rows - 2 && $number % 2 != 0){
                        Seat::create([
                            'room_id' => $room->id,
                            'row' => $rowLetter,
                            'number' => $number,
                            'x' => $number,
                            'y' => $row + 1,
                            'type' => 'couch',
                            'group_id' => $couch_id,
                        ]);
                    }else if($row >= $rows - 2 && $number % 2 == 0){
                        Seat::create([
                            'room_id' => $room->id,
                            'row' => $rowLetter,
                            'number' => $number,
                            'x' => $number,
                            'y' => $row + 1,
                            'type' => 'couch',
                            'group_id' => $couch_id,
                        ]);

                        $couch_id += 1;
                    }
                    else{
                        Seat::create([
                            'room_id' => $room->id,
                            'row' => $rowLetter,
                            'number' => $number,
                            'x' => $number,
                            'y' => $row + 1,
                            'type' => 'standard',
                        ]);
                    }
                }
            }
        }
    }
}
