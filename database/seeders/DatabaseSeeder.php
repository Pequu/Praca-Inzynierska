<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Screening;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        User::factory()->create([
            'name' => 'Mateusz',
            'email' => 'rzymekrz@gmail.com',
        ]);

        $this->call([
            GenreSeeder::class,
            MovieSeeder::class,
            RoomSeeder::class,
            ScreeningSeeder::class,
            GenreMovieSeeder::class,
            SeatSeeder::class,
        ]);
    }
}
