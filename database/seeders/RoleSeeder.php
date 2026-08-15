<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            [
                'role_name' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'role_name' => 'worker',
                'created_at' => now(),
                'updated_at' => now(),
            ],


            [
                'role_name' => 'customer',
                'created_at' => now(),
                'updated_at' => now(),
            ]

        ]);
    }
}

