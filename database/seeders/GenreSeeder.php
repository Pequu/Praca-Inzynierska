<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        $genres = [
            'Animacja' => '#10B981',
            'Fantasy' => '#8B5CF6',
            'Dramat' => '#3B82F6',
            'Komedia' => '#F59E0B',
            'Horror' => '#7C3AED',
            'Sci-Fi' => '#06B6D4',
            'Akcja' => '#EF4444',
            'Familijny' => '#22C55E',
            'Thriller' => '#1F2937',
            'Przygodowy' => '#F97316',
            'Kryminał' => '#374151',
            'Romans' => '#EC4899',
            'Dokumentalny' => '#64748B',
            'Muzyczny' => '#D946EF',
            'Historyczny' => '#92400E',
        ];

        foreach ($genres as $name => $color) {
            Genre::create([
                'name' => $name,
                'color' => $color,
            ]);
        }
    }
}
