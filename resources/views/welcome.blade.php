<x-app-layout>
    <!-- Main content -->
    <main class="flex justify-center min-h-[calc(100vh-4rem)] py-10">
        <!-- Screenings list -->
        <section class="w-full max-w-3xl space-y-5">
            <!-- Screenings -->
            @foreach($screenings as $screening)
                <a href="{{ route('screenings.show', $screening->id) }}"
                class="block bg-gray-100 rounded-xl shadow-md overflow-hidden mb-5 hover:shadow-xl transition duration-300">

                    <!-- Gatunki -->
                    <div class="flex flex-row justify-end mt-4">
                        @foreach($screening->movie->genres as $genre)
                            <span
                                class="inline-block text-white text-xs font-semibold mr-4 px-2.5 py-0.5 rounded"
                                style="background-color: {{ $genre->color }}"
                            >
                                {{ $genre->name }}
                            </span>
                        @endforeach
                    </div>
                    <div class="flex p-5 gap-6">

                        <!-- Plakat -->
                        <div class="w-32 h-44 flex-shrink-0">
                            <img
                                src="{{ asset('storage/' . $screening->movie->poster) }}"
                                alt="{{ $screening->movie->title }}"
                                class="w-full h-full object-cover rounded-lg"
                            >
                        </div>
                        <!-- Informacje o filmie -->
                        <div class="flex-1">
                            <h2 class="text-2xl font-bold mb-2">
                                {{ $screening->movie->title }}
                            </h2>

                            <p class="text-gray-600 mb-1">
                                {{ $screening->movie->duration }} min
                                |
                                {{ $screening->movie->age_rating }}
                            </p>
                            <p class="text-gray-600">
                                Sala:
                                <span class="font-medium">
                                    {{ $screening->room->name }}
                                </span>
                            </p>
                            <p class="text-gray-600">
                                Cena:
                                <span class="font-medium">
                                    {{ $screening->price }} zł
                                </span>
                            </p>
                        </div>
                        <!-- Godzina -->
                        <div class="flex flex-col justify-center items-end">

                            <span class="text-gray-500 text-sm">
                                Seans
                            </span>

                            <span class="text-3xl font-bold text-red-600">
                                {{ $screening->start_time->format('H:i') }}
                            </span>

                            <span class="mt-4 bg-red-600 text-white px-6 py-2 rounded-lg">
                                Wybierz
                            </span>
                        </div>

                    </div>
                </a>
            @endforeach
        </section>
</x-app-layout>
