<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
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
        $this->call([
            GenreSeeder::class,
            MovieSeeder::class,
            RoomSeeder::class,
            ScreeningSeeder::class,
            GenreMovieSeeder::class,
            RoleSeeder::class,
            SeatSeeder::class,
        ]);

         User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'role_id' => '1',
        ]);

        User::factory()->create([
            'name' => 'Mateusz',
            'email' => 'rzymekrz@gmail.com',
            'role_id' => '2',
        ]);

        User::factory(10)->create();
    }
}
