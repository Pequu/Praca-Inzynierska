<x-app-layout>

    <div class="min-h-screen bg-gray-100 py-10 px-6">

        <div class="max-w-4xl mx-auto">

            {{-- Nagłówek --}}
            <div class="mb-8">

                <a
                    href="{{ route('admin.movies.index') }}"
                    class="inline-flex items-center text-sm text-gray-500
                        hover:text-gray-900 transition mb-4"
                >
                    ← Powrót do listy filmów
                </a>

                <h1 class="text-4xl font-bold text-gray-900">
                    Edycja filmu
                </h1>

                <p class="mt-2 text-gray-500">
                    Edytujesz:
                    <span class="font-semibold text-gray-700">
                        {{ $movie->title }}
                    </span>
                </p>

            </div>


            {{-- Formularz --}}
            <div class="bg-white rounded-2xl border border-gray-200
                        shadow-sm p-8">

                <form
                    method="POST"
                    action="{{ route('admin.movies.update', $movie) }}"
                >

                    @csrf
                    @method('PUT')

                    {{-- TYTUŁ +  CZAS + KATEGORIA --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

                        {{-- TYTUŁ --}}
                        <div>
                            <label
                                for="title"
                                class="block text-sm font-semibold
                                    text-gray-700 mb-2">
                                Tytuł filmu
                            </label>

                            <input
                                id="title"
                                type="text"
                                name="title"
                                value="{{ old('title', $movie->title) }}"
                                required
                                class="w-full rounded-xl border-gray-300
                                    focus:border-zinc-500
                                    focus:ring-zinc-500">
                            @error('title')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        {{-- Czas trwania --}}
                        <div>
                            <label
                                for="duration"
                                class="block text-sm font-semibold
                                    text-gray-700 mb-2">
                                Czas trwania
                            </label>

                            <div class="relative">

                                <input
                                    id="duration"
                                    type="number"
                                    name="duration"
                                    value="{{ old('duration', $movie->duration) }}"
                                    min="1"
                                    max="999"
                                    required
                                    class="w-full rounded-xl border-gray-300
                                        pr-16
                                        focus:border-zinc-500
                                        focus:ring-zinc-500">
                                <span
                                    class="absolute right-4 top-1/2
                                        -translate-y-1/2
                                        text-sm text-gray-400">
                                    min
                                </span>
                            </div>
                            @error('duration')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        {{-- Kategoria wiekowa --}}
                        <div>
                                @php
                                    $ageRatings = ['0+', '7+', '12+', '16+', '18+'];
                                @endphp

                                <x-select name="age_rating" label="Kategoria wiekowa" required>

                                    @foreach($ageRatings as $rating)
                                        <option class="rounded-md"
                                            value="{{ $rating }}"
                                            @selected(old('age_rating', $movie->age_rating) === $rating)
                                        >
                                            {{ $rating }}
                                        </option>
                                    @endforeach
                                </x-select>

                        </div>
                    </div>

                    {{-- OPIS --}}
                    <div class="mb-6">

                        <label
                            for="description"
                            class="block text-sm font-semibold
                                text-gray-700 mb-2"
                        >
                            Opis
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            rows="7"
                            required
                            class="w-full rounded-xl border-gray-300
                                resize-y
                                focus:border-zinc-500
                                focus:ring-zinc-500"
                        >{{ old('description', $movie->description) }}</textarea>

                        @error('description')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- DATA PREMIERY --}}
                    <div class="mb-6">
                        <label
                            for="release_date"
                            class="block text-sm font-semibold
                                text-gray-700 mb-2">
                            Data premiery
                        </label>

                        <input
                            id="release_date"
                            type="date"
                            name="release_date"
                            value="{{ old('release_date', $movie->release_date) }}"
                            required
                            class="w-full rounded-xl border-gray-300
                                focus:border-zinc-500
                                focus:ring-zinc-500">
                        @error('release_date')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- PLAKAT --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 mb-6">
                        <div class="mb-6">
                            <label
                                class="block text-sm font-semibold
                                    text-gray-700 mb-2">
                                Plakat
                            </label>

                            @if($movie->poster)
                                <div class="mb-4">
                                    <img
                                        src="{{ asset('storage/' . $movie->poster) }}"
                                        alt="{{ $movie->title }}"
                                        class="w-48 h-72 object-cover
                                            rounded-xl shadow-md">
                                </div>

                            @else
                                <div
                                    class="w-48 h-72 rounded-xl bg-gray-100
                                        border border-gray-200
                                        flex items-center justify-center
                                        text-gray-400 mb-4">
                                    Brak plakatu
                                </div>
                            @endif

                        </div>

                        {{-- URL PLAKATU --}}
                        <div class="mb-8">
                            <label
                                for="poster"
                                class="block text-sm font-semibold
                                    text-gray-700 mb-2">
                                URL plakatu
                            </label>

                            <input
                                id="poster"
                                type="text"
                                name="poster"
                                value="{{ old('poster', $movie->poster) }}"
                                placeholder="posters/..."
                                class="w-full rounded-xl border-gray-300
                                    focus:border-zinc-500
                                    focus:ring-zinc-500">

                            @error('poster')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        {{-- utworzony / aktualizowany --}}
                        <div class="mb-8 px-4">

                            {{-- utworzony --}}
                            <label
                                for="created_at"
                                class="block text-sm font-semibold
                                    text-gray-700 mb-2">
                                Utworzony
                            </label>

                            <p id="created_at" class="text-gray-400 mb-6">
                                {{ $movie->created_at->format('d-m-Y | H:i') }}
                            </p>

                            {{-- aktualizowany --}}
                            <label
                                for="updated_at"
                                class="block text-sm font-semibold
                                    text-gray-700 mb-2">
                                Ostatnia aktualizacja
                            </label>

                            <p id="updated_at" class="text-gray-400">
                                {{ $movie->updated_at->format('d-m-Y | H:i') }}
                            </p>

                        </div>
                    </div>

                    {{-- PRZYCISKI --}}
                    <div class="flex justify-end gap-3 pt-4
                                border-t border-gray-200">

                        <a
                            href="{{ route('admin.movies.index') }}"
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
