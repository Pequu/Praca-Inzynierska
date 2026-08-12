<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Movie;

class MovieSeeder extends Seeder
{
    public function run(): void
    {
        Movie::insert([

            [
                'title' => 'Diuna: Część druga',
                'description' => 'Paul Atryda jednoczy się z Chani i ludem Fremenów, rozpoczynając drogę zemsty przeciwko spiskowcom odpowiedzialnym za upadek jego rodu. Epicka opowieść o polityce, przeznaczeniu i walce o przyszłość Arrakis.',
                'duration' => 166,
                'release_date' => '2024-02-29',
                'age_rating' => '12+',
                'poster' => 'posters/dune-part-two.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],


            [
                'title' => 'Oppenheimer',
                'description' => 'Historia J. Roberta Oppenheimera, naukowca kierującego zespołem pracującym nad stworzeniem pierwszej bomby atomowej podczas II wojny światowej. Film przedstawia zarówno przełom naukowy, jak i moralne konsekwencje jego odkrycia.',
                'duration' => 180,
                'release_date' => '2023-07-21',
                'age_rating' => '15+',
                'poster' => 'posters/oppenheimer.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],


            [
                'title' => 'Avatar: Istota wody',
                'description' => 'Jake Sully i Neytiri wraz z rodziną uciekają przed dawnym zagrożeniem i odkrywają nowe plemiona zamieszkujące oceany Pandory. Niezwykła podróż pełna przygód i zapierających dech w piersiach krajobrazów.',
                'duration' => 192,
                'release_date' => '2022-12-16',
                'age_rating' => '12+',
                'poster' => 'posters/avatar-way-of-water.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],


            [
                'title' => 'Top Gun: Maverick',
                'description' => 'Pete Maverick Mitchell powraca jako instruktor elitarnej szkoły lotniczej Top Gun. Przygotowuje młodych pilotów do niezwykle trudnej misji, jednocześnie mierząc się z własną przeszłością.',
                'duration' => 130,
                'release_date' => '2022-05-27',
                'age_rating' => '12+',
                'poster' => 'posters/top-gun-maverick.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],


            [
                'title' => 'Minecraft: Film',
                'description' => 'Grupa bohaterów trafia do niezwykłego świata stworzonego z klocków. Aby wrócić do domu, muszą wykorzystać swoją kreatywność, współpracę i odwagę, mierząc się z niebezpieczeństwami świata Minecraft.',
                'duration' => 101,
                'release_date' => '2025-04-04',
                'age_rating' => '7+',
                'poster' => 'posters/minecraft.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],


            [
                'title' => 'Interstellar',
                'description' => 'Grupa astronautów wyrusza w podróż przez tunel czasoprzestrzenny w poszukiwaniu nowego domu dla ludzkości. Film łączy naukę, emocje i pytania o przyszłość naszej cywilizacji.',
                'duration' => 169,
                'release_date' => '2014-11-07',
                'age_rating' => '12+',
                'poster' => 'posters/interstellar.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],


            [
                'title' => 'Kraina Lodu 2',
                'description' => 'Elsa, Anna, Kristoff, Olaf i Sven wyruszają poza granice swojego królestwa, aby odkryć tajemnicę przeszłości i źródło niezwykłych mocy Elsy.',
                'duration' => 103,
                'release_date' => '2019-11-22',
                'age_rating' => '0+',
                'poster' => 'posters/frozen-2.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],


            [
                'title' => 'Joker',
                'description' => 'Arthur Fleck, samotny mieszkaniec Gotham, stopniowo pogrąża się w świecie przemocy i chaosu. Historia ukazuje narodziny jednej z najbardziej znanych postaci świata komiksów.',
                'duration' => 122,
                'release_date' => '2019-10-04',
                'age_rating' => '15+',
                'poster' => 'posters/joker.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],


        ]);
    }
}
