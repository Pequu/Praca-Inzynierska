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
                'name' => 'Sala 1',
                'description' => 'Sala kinowa nr 1',
                'capacity' => 120,
            ],
            [
                'name' => 'Sala 2',
                'description' => 'Sala kinowa nr 2',
                'capacity' => 80,
            ],
            [
                'name' => 'Sala 3',
                'description' => 'Sala kinowa nr 3',
                'capacity' => 180,
            ],
            [
                'name' => 'Sala 4',
                'description' => 'Sala kinowa nr 4',
                'capacity' => 180,
            ],
            [
                'name' => 'Sala Dream',
                'description' => 'Sala Dream',
                'capacity' => 40,
                'color' => '#ba09f0',
            ],
            [
                'name' => 'Sala IMAX',
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
