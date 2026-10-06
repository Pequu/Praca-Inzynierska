<x-app-layout>

    <div class="min-h-screen bg-zinc-900 border-2 border-gray-200
                py-10 px-6 rounded-2xl">

        <div class="max-w-4xl mx-auto">

            {{-- Nagłówek --}}
            <div class="mb-8">

                <h1 class="text-4xl font-bold text-gray-200">
                    Dodaj seans
                </h1>

                <p class="mt-2 text-gray-300">
                    Wybierz film, salę oraz godzinę seansu.
                </p>

            </div>


            {{-- Formularz --}}
            <div class="bg-white rounded-2xl border border-gray-200
                        shadow-sm p-8">

                <form
                    method="POST"
                    action="{{ route('admin.screenings.store') }}"
                >

                    @csrf


                    {{-- Film --}}
                    <div class="mb-6">

                        <label
                            for="movie_id"
                            class="block text-sm font-semibold text-gray-700 mb-2"
                        >
                            Film
                        </label>

                        <select
                            id="movie_id"
                            name="movie_id"
                            required
                            class="w-full rounded-xl border-gray-300
                                   focus:border-zinc-500
                                   focus:ring-zinc-500"
                        >

                            <option value="">
                                -- Wybierz film --
                            </option>

                            @foreach($movies as $movie)

                                <option
                                    value="{{ $movie->id }}"
                                    {{ old('movie_id') == $movie->id ? 'selected' : '' }}
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


                    {{-- Sala --}}
                    <div class="mb-6">

                        <label
                            for="room_id"
                            class="block text-sm font-semibold text-gray-700 mb-2"
                        >
                            Sala
                        </label>

                        <select
                            id="room_id"
                            name="room_id"
                            required
                            class="w-full rounded-xl border-gray-300
                                   focus:border-zinc-500
                                   focus:ring-zinc-500"
                        >

                            <option value="">
                                -- Wybierz salę --
                            </option>

                            @foreach($rooms as $room)

                                <option
                                    value="{{ $room->id }}"
                                    {{ old('room_id') == $room->id ? 'selected' : '' }}
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


                    {{-- Data i godzina --}}
                    <div class="mb-6">

                        <label
                            for="start_time"
                            class="block text-sm font-semibold text-gray-700 mb-2"
                        >
                            Data i godzina
                        </label>

                        <input
                            type="datetime-local"
                            id="start_time"
                            name="start_time"
                            value="{{ old('start_time') }}"
                            min="{{ now()->format('Y-m-d\TH:i') }}"
                            required
                            class="w-full rounded-xl border-gray-300
                                focus:border-zinc-500
                                focus:ring-zinc-500"
                        >

                        @error('start_time')

                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- Cena --}}
                    <div class="mb-8">

                        <label
                            for="screening_price"
                            class="block text-sm font-semibold text-gray-700 mb-2"
                        >
                            Cena biletu
                        </label>

                        <div class="relative">

                            <input
                                type="number"
                                id="screening_price"
                                name="screening_price"
                                value="{{ old('screening_price') }}"
                                min="0"
                                step="0.01"
                                required
                                class="w-full rounded-xl border-gray-300
                                       focus:border-zinc-500
                                       focus:ring-zinc-500
                                       pr-16"
                            >

                            <span
                                class="absolute right-4 top-1/2
                                       -translate-y-1/2
                                       text-gray-500"
                            >
                                zł
                            </span>

                        </div>

                        @error('screening_price')

                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- Przyciski --}}
                    <div class="flex justify-between items-center">

                        <a
                            href="{{ route('admin.screenings.index') }}"
                            class="px-5 py-2 rounded-xl
                                   bg-gray-200 text-gray-700
                                   hover:bg-gray-300 transition">
                            Anuluj
                        </a>

                        <x-secondary-button
                            type="submit"
                            class="px-6 py-3 rounded-xl">
                            Dodaj seans
                        </x-secondary-button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>
