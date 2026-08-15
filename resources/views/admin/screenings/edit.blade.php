<x-app-layout>

    <div class="min-h-screen bg-gray-100 py-10 px-6">

        <div class="max-w-4xl mx-auto">

            {{-- Nagłówek --}}
            <div class="mb-8">

                <a
                    href="{{ route('admin.screenings.index') }}"
                    class="inline-flex items-center text-sm text-gray-500
                        hover:text-gray-900 transition mb-4"
                >
                    ← Powrót do listy seansów
                </a>

                <h1 class="text-4xl font-bold text-gray-900">
                    Edycja seansu
                </h1>

                <p class="mt-2 text-gray-500">
                    Edytujesz seans filmu:
                    <span class="font-semibold text-gray-700">
                        {{ $screening->movie->title }}
                    </span>
                </p>

            </div>


            {{-- Formularz --}}
            <div class="bg-white rounded-2xl border border-gray-200
                        shadow-sm p-8">

                <form
                    method="POST"
                    action="{{ route('admin.screenings.update', $screening) }}"
                >

                    @csrf
                    @method('PUT')


                    {{-- FILM + SALA --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                        {{-- FILM --}}
                        <div>

                            <label
                                for="movie_id"
                                class="block text-sm font-semibold text-gray-700 mb-2">
                                Film
                            </label>

                            <select
                                id="movie_id"
                                name="movie_id"
                                required
                                class="w-full rounded-xl border-gray-300 focus:border-zinc-500 focus:ring-zinc-500">

                                @foreach($movies as $movie)

                                    <option
                                        value="{{ $movie->id }}"
                                        @selected(
                                            old(
                                                'movie_id',
                                                $screening->movie_id
                                            ) == $movie->id
                                        )
                                    >
                                        {{ $movie->title }}
                                    </option>

                                @endforeach

                            </select>

                            @error('movie_id')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- SALA --}}
                        <div>

                            <label
                                for="room_id"
                                class="block text-sm font-semibold text-gray-700 mb-2">
                                Sala
                            </label>

                            <select
                                id="room_id"
                                name="room_id"
                                required
                                class="w-full rounded-xl border-gray-300 focus:border-zinc-500 focus:ring-zinc-500">

                                @foreach($rooms as $room)

                                    <option
                                        value="{{ $room->id }}"
                                        @selected(
                                            old(
                                                'room_id',
                                                $screening->room_id
                                            ) == $room->id
                                        )
                                    >
                                        {{ $room->room_name }}
                                    </option>

                                @endforeach

                            </select>

                            @error('room_id')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>


                    {{-- DATA I CENA --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                        {{-- Data i czas --}}
                        <div>
                            <label
                                for="start_time"
                                class="block text-sm font-semibold text-gray-700 mb-2">
                                Godzina rozpoczęcia
                            </label>

                            <input
                                id="start_time"
                                type="datetime-local"
                                name="start_time"
                                value="{{ old(
                                    'start_time',
                                    $screening->start_time
                                        ? $screening->start_time
                                        : ''
                                ) }}"
                                required
                                class="w-full rounded-xl border-gray-300 focus:border-zinc-500 focus:ring-zinc-500">

                            @error('start_time')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        {{-- CENA --}}
                        <div>
                            <label
                                for="screening_price"
                                class="block text-sm font-semibold text-gray-700 mb-2">
                                Cena biletu
                            </label>

                            <div class="relative">

                                <input
                                    id="screening_price"
                                    type="number"
                                    name="screening_price"
                                    value="{{ old(
                                        'screening_price',
                                        $screening->screening_price
                                    ) }}"
                                    min="0"
                                    step="0.01"
                                    required
                                    class="w-full rounded-xl border-gray-300 pr-12 focus:border-zinc-500 focus:ring-zinc-500"
                                >

                                <span
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-sm text-gray-400">
                                    zł
                                </span>

                            </div>

                            @error('screening_price')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>


                    {{-- STATUS + TIMESTAMPS --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                        {{-- STATUS --}}
                        <div>

                            <label
                                for="status"
                                class="block text-sm font-semibold text-gray-700 mb-2">
                                Status seansu
                            </label>

                            <select
                                id="status"
                                name="status"
                                required
                                class="w-full rounded-xl border-gray-300 focus:border-zinc-500 focus:ring-zinc-500">

                                <option
                                    value="scheduled"
                                    class="bg-yellow-200 text-yellow-600 font-semibold"
                                    @selected(
                                        old(
                                            'status',
                                            $screening->status
                                        ) === 'scheduled'
                                    )
                                >
                                    Zaplanowany
                                </option>

                                <option
                                    value="cancelled"
                                    class="bg-red-200 text-red-600 font-semibold"
                                    @selected(
                                        old(
                                            'status',
                                            $screening->status
                                        ) === 'cancelled'
                                    )
                                >
                                    Odwołany
                                </option>

                                <option
                                    value="finished"
                                    class="bg-green-200 text-green-600 font-semibold"
                                    @selected(
                                        old(
                                            'status',
                                            $screening->status
                                        ) === 'finished'
                                    )
                                >
                                    Zakończony
                                </option>

                            </select>

                            @error('status')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        <div>

                            <label
                                for="created_at"
                                class="block text-sm font-semibold text-gray-700">
                                Utworzono
                            </label>

                            <p
                                id="created_at"
                                class="block text-xs font-semibold text-gray-500 mb-1">{{ $screening->created_at->format('d-m-Y | H:i') }}</p>





                            <label
                                for="updated_at"
                                class="block text-sm font-semibold text-gray-700">
                                Aktualizacja
                            </label>

                            <p
                                id="updated_at"
                                class="block text-xs font-semibold text-gray-500">{{ $screening->updated_at->format('d-m-Y | H:i') }}</p>

                        </div>

                    </div>


                    {{-- PRZYCISKI --}}
                    <div class="flex justify-end gap-3 pt-4
                                border-t border-gray-200">

                        <a
                            href="{{ route('admin.screenings.index') }}"
                            class="px-6 py-3 rounded-xl
                                bg-gray-100 text-gray-700
                                hover:bg-gray-200 transition"
                        >
                            Anuluj
                        </a>

                        <button
                            type="submit"
                            class="px-6 py-3 rounded-xl
                                bg-zinc-900 text-white
                                hover:bg-zinc-800 transition"
                        >
                            Zapisz zmiany
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>
