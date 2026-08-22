<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [
            [
                'room_name' => 'Sala 1',
                'description' => 'Sala kinowa nr 1',
                'capacity' => 120,
            ],
            [
                'room_name' => 'Sala 2',
                'description' => 'Sala kinowa nr 2',
                'capacity' => 80,
            ],
            [
                'room_name' => 'Sala 3',
                'description' => 'Sala kinowa nr 3',
                'capacity' => 180,
            ],
            [
                'room_name' => 'Sala 4',
                'description' => 'Sala kinowa nr 4',
                'capacity' => 180,
            ],
            [
                'room_name' => 'Dream',
                'description' => 'Sala Dream',
                'capacity' => 40,
                'color' => '#ba09f0',
            ],
            [
                'room_name' => 'IMAX',
                'description' => 'Sala IMAX',
                'capacity' => 300,
                'color' => '#09baf0',
            ],
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
}
