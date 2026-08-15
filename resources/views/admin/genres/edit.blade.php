<x-app-layout>

    <div class="min-h-screen bg-gray-100 py-10 px-6">

        <div class="max-w-4xl mx-auto">

            {{-- Nagłówek --}}
            <div class="mb-8">

                <a
                    href="{{ route('admin.genres.index') }}"
                    class="inline-flex items-center text-sm text-gray-500
                        hover:text-gray-900 transition mb-4"
                >
                    ← Powrót do listy gatunków
                </a>

                <h1 class="text-4xl font-bold text-gray-900">
                    Edycja Gatunku
                </h1>

                <p class="mt-2 text-gray-500">
                    Edytujesz:
                    <span class="font-semibold text-gray-700">
                        {{ $genre->ganre_name }}
                    </span>
                </p>

            </div>


            {{-- Formularz --}}
            <div class="bg-white rounded-2xl border border-gray-200
                        shadow-sm p-8">

                <form
                    method="POST"
                    action="{{ route('admin.genres.update', $genre) }}">

                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                        {{-- Nazwa --}}
                        <div>
                            <label
                                for="genre_name"
                                class="block text-sm font-semibold
                                    text-gray-700 mb-2">
                                Nawa Gatunku
                            </label>

                            <input
                                id="genre_name"
                                type="text"
                                name="genre_name"
                                value="{{ old('ganre_name', $genre->genre_name) }}"
                                required
                                class="w-full rounded-xl border-gray-300 focus:border-zinc-500 focus:ring-zinc-500">
                            @error('genre_name')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        {{-- Kolor --}}
                        <div>
                            <label
                                for="color"
                                class="block text-sm font-semibold
                                    text-gray-700 mb-2">
                                Kolor
                            </label>

                            <div class="relative">

                                <input
                                    id="color"
                                    type="text"
                                    name="color"
                                    value="{{ old('color', $genre->color) }}"
                                    placeholder="#FF00FF"
                                    required
                                    class="w-full rounded-xl border-gray-300
                                        pr-16
                                        focus:border-zinc-500
                                        focus:ring-zinc-500">

                            </div>
                            @error('color')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        {{-- utworzony --}}
                        <div class="px-4">
                            <label
                                for="created_at"
                                class="block text-sm font-semibold
                                    text-gray-700 mb-2">
                                Utworzony
                            </label>

                            <p id="created_at" class="text-gray-400 mb-6">
                                {{ $genre->created_at->format('d-m-Y | H:i') }}
                            </p>

                        </div>

                        {{-- aktualizowany --}}
                        <div class="px-4">
                            <label
                                for="updated_at"
                                class="block text-sm font-semibold
                                    text-gray-700 mb-2">
                                Ostatnia aktualizacja
                            </label>

                            <p id="updated_at" class="text-gray-400">
                                {{ $genre->updated_at->format('d-m-Y | H:i') }}
                            </p>

                        </div>
                    </div>

                    {{-- PRZYCISKI --}}
                    <div class="flex justify-end gap-3 pt-4
                                border-t border-gray-200">

                        <a
                            href="{{ route('admin.genres.index') }}"
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
