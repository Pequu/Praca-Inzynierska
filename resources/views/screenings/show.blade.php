<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        {{ $screening->movie->title }} - Peqursor
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900">
    <!-- Navbar -->
    <header class="bg-black text-white h-16 flex items-center px-10">
        <a href="/" class="text-2xl font-bold">
            Peqursor
        </a>
        <nav class="ml-auto flex gap-8">
            <a href="/" class="hover:text-red-400">
                Repertuar
            </a>
            <a href="#" class="hover:text-red-400">
                Kina
            </a>
            <a href="#" class="hover:text-red-400">
                Kontakt
            </a>
        </nav>
    </header>
    <!-- Szczegóły filmu -->
    <main class="max-w-5xl mx-auto py-10">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="flex p-8 gap-8">
                <!-- Plakat -->
                <div class="w-64 h-96 flex-shrink-0">
                    <img
                        src="{{ asset('storage/' . $screening->movie->poster) }}"
                        alt="{{ $screening->movie->title }}"
                        class="w-full h-full object-cover rounded-lg"
                    >
                </div>
                <!-- Informacje -->
                <div class="flex-1">
                    <h1 class="text-4xl font-bold mb-4">
                        {{ $screening->movie->title }}
                    </h1>
                    <p class="text-gray-600 text-lg mb-6">
                        {{ $screening->movie->description }}
                    </p>
                    <div class="space-y-3 text-lg">
                        <p>
                            <strong>Czas trwania:</strong>
                            {{ $screening->movie->duration }} min
                        </p>
                        <p>
                            <strong>Wiek:</strong>
                            {{ $screening->movie->age_rating }}
                        </p>
                        <p>
                            <strong>Sala:</strong>
                            {{ $screening->room->name }}
                        </p>
                        <p>
                            <strong>Data:</strong>
                            {{ $screening->start_time->format('d.m.Y') }}
                        </p>
                        <p>
                            <strong>Godzina:</strong>
                            <span class="text-red-600 font-bold text-2xl">
                                {{ $screening->start_time->format('H:i') }}
                            </span>
                        </p>
                        <p>
                            <strong>Cena:</strong>
                            {{ $screening->price }} zł
                        </p>
                    </div>
                    <a href="#seats"
                       class="inline-block mt-8 bg-red-600 text-white px-8 py-3 rounded-lg text-lg hover:bg-red-700">
                        Wybierz miejsca
                    </a>
                </div>
            </div>
        </div>
    </main>
</body>

</html>
