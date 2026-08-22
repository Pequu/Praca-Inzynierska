<x-app-layout>
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
                        <p class="flex items-center gap-2">
                            <strong>Sala:</strong>

                            <span
                                class="inline-block text-white px-2 rounded-lg font-semibold"
                                style="background-color: {{ $screening->room->color }}"
                            >
                                {{ $screening->room->room_name }}
                            </span>
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
                            {{ $screening->screening_price }} zł
                        </p>
                    </div>
                    <a
                        href="{{ route('screenings.seats', $screening->id) }}"
                        class="inline-block mt-8 bg-red-600 text-white px-8 py-3 rounded-lg text-lg hover:bg-red-700 transition"
                    >
                        Wybierz miejsca
                    </a>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>
