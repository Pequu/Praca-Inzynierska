<x-app-layout>
    <!-- Main content -->
    <main class="flex flex-col justify-center min-h-[calc(100vh-4rem)]">

         <!-- Pagination -->
        <div class="w-full max-w-3xl mb-6">
            <div class="flex gap-2 overflow-x-auto pb-2">
                @foreach($dates as $date)
                    <a href="{{ route('screenings.index', ['date' => $date['date']]) }}"
                        class="flex-shrink-0 px-5 py-3 rounded-xl font-semibold transition duration-200
                            {{ $selectedDate === $date['date']
                                ? 'bg-red-600 text-white shadow-md'
                                : 'bg-gray-100 text-gray-700 hover:bg-yellow-200'
                            }}">
                        {{ $date['label'] }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Screenings list -->
        <section class="w-full max-w-3xl space-y-5">
            <!-- Screenings -->
            @if($screenings->isEmpty())
                <div class="bg-gray-100 rounded-xl shadow-md p-8 text-center">
                    <h2 class="text-xl font-semibold text-gray-700">
                        Brak seansów
                    </h2>

                    <p class="text-gray-500 mt-2">
                        W wybranym dniu nie ma zaplanowanych seansów.
                    </p>
                </div>

            @else

                @foreach($screenings as $movieScreenings)

                    @php
                        $movie = $movieScreenings->first()->movie;
                    @endphp

                    <div class="block bg-gray-100 rounded-xl shadow-md overflow-hidden mb-5">

                        <div class="flex p-5 gap-6">

                            <!-- Plakat -->
                            <div class="w-32 h-44 flex-shrink-0">
                                <img
                                    src="{{ asset('storage/' . $movie->poster) }}"
                                    alt="{{ $movie->title }}"
                                    class="w-full h-full object-cover rounded-lg"
                                >
                            </div>


                            <!-- Informacje o filmie -->
                            <div class="flex-1">

                                <h2 class="text-2xl font-bold mb-2">
                                    {{ $movie->title }}
                                </h2>

                                <p class="text-gray-600 mb-1">
                                    {{ $movie->duration }} min
                                    |
                                    {{ $movie->age_rating }}
                                </p>


                                <!-- Godziny seansów -->
                                <div class="mt-5">

                                    <p class="text-sm text-gray-500 mb-2">
                                        Godziny seansów:
                                    </p>

                                    <div class="flex flex-wrap gap-2">

                                        @foreach($movieScreenings as $screening)

                                            <a
                                                href="{{ route('screenings.show', $screening->id) }}"
                                                class="text-white px-4 py-2 rounded-lg font-semibold transition"
                                                style="background-color: {{ $screening->room->color }}"
                                            >
                                                {{ $screening->start_time->format('H:i') }}
                                            </a>

                                        @endforeach

                                    </div>

                                </div>

                            </div>


                            <!-- Gatunki -->
                            <div class="w-28 flex flex-col items-end gap-2">

                                @foreach($movie->genres as $genre)

                                    <span
                                        class="text-white text-xs font-semibold px-3 py-1 rounded text-center"
                                        style="background-color: {{ $genre->color }}"
                                    >
                                        {{ $genre->name }}
                                    </span>

                                @endforeach

                            </div>

                        </div>

                    </div>

                @endforeach

            @endif
        </section>
</x-app-layout>
