<x-app-layout>
    <div class="min-h-screen bg-zinc-900 border-2 border-gray-200 py-10 px-6 rounded-2xl">

        <div class="max-w-7xl mx-auto">

            {{-- Nagłówek --}}
            <div class="flex items-center justify-between mb-8">

                <div>
                    <h1 class="text-4xl font-bold text-gray-200">
                        Zarządzanie filmami
                    </h1>

                    <p class="mt-2 text-gray-300">
                        Przeglądaj i edytuj filmy dostępne w repertuarze.
                    </p>
                </div>

                <x-a-secondary href="{{ route('admin') }}">
                    Powrót
                </x-a-secondary>

            </div>


            {{-- Komunikaty --}}
            @if(session('success'))
                <div class="mb-6 p-4 rounded-xl bg-green-100 text-green-800">
                    {{ session('success') }}
                </div>
            @endif


            {{-- Wyszukiwarka --}}
            <div class="bg-white rounded-2xl border border-gray-200
                        p-5 mb-6">

                <form
                    method="GET"
                    action="{{ route('admin.movies.index') }}"
                    class="flex gap-3">

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Szukaj filmu po tytule..."
                        class="flex-1 rounded-xl border-gray-300
                            focus:border-zinc-500
                            focus:ring-zinc-500">

                    <x-primary-button>
                        Szukaj
                    </x-primary-button>

                </form>

            </div>


            {{-- Lista filmów --}}
            <div class="bg-white rounded-2xl border border-gray-200
                        shadow-sm overflow-hidden">

                <table class="w-full">

                    <thead class="bg-zinc-900 text-white">

                        <tr>

                            <th class="text-left px-6 py-4">
                                Film
                            </th>

                            <th class="text-left px-6 py-4">
                                Czas trwania
                            </th>

                            <th class="text-left px-6 py-4">
                                Premiera
                            </th>

                            <th class="text-left px-6 py-4">
                                Wiek
                            </th>

                            <th class="text-right px-6 py-4">
                                Akcje
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-200">

                        @forelse($movies as $movie)

                            <tr class="hover:bg-gray-50 transition">

                                {{-- Film --}}
                                <td class="px-6 py-4">

                                    <div class="flex items-center gap-4">

                                        @if($movie->poster)

                                            <img
                                                src="{{ asset('storage/' . $movie->poster) }}"
                                                alt="{{ $movie->title }}"
                                                class="w-16 h-20 object-cover
                                                    rounded-lg"
                                            >

                                        @else

                                            <div
                                                class="w-16 h-20 rounded-lg
                                                    bg-gray-200
                                                    flex items-center
                                                    justify-center
                                                    text-gray-400 text-xs"
                                            >
                                                Brak plakatu
                                            </div>

                                        @endif

                                        <div>

                                            <div class="font-semibold text-gray-900">
                                                {{ $movie->title }}
                                            </div>

                                        </div>

                                    </div>

                                </td>


                                {{-- Czas --}}
                                <td class="px-6 py-4 text-gray-600">
                                    {{ $movie->duration }} min
                                </td>


                                {{-- Premiera --}}
                                <td class="px-6 py-4 text-gray-600">
                                    {{ \Carbon\Carbon::parse($movie->release_date)->format('d.m.Y') }}
                                </td>


                                {{-- Wiek --}}
                                <td class="px-6 py-4">

                                    <span
                                        class="px-3 py-1 rounded-full
                                            bg-gray-100 text-gray-700
                                            text-xs font-semibold"
                                    >
                                        {{ $movie->age_rating }}
                                    </span>

                                </td>


                                {{-- Akcje --}}
                                <td class="px-6 py-4">

                                    <div class="flex justify-end gap-2">

                                        <a
                                            href="{{ route('admin.movies.edit', $movie) }}"
                                            class="px-4 py-2 rounded-lg
                                                bg-blue-100 text-blue-700
                                                hover:bg-blue-200 transition"
                                        >
                                            Edytuj
                                        </a>


                                        <form
                                            method="POST"
                                            action="{{ route('admin.movies.destroy', $movie) }}"
                                            onsubmit="return confirm('Czy na pewno chcesz usunąć ten film?');"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="px-4 py-2 rounded-lg
                                                    bg-red-100 text-red-700
                                                    hover:bg-red-200 transition"
                                            >
                                                Usuń
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="5"
                                    class="px-6 py-10 text-center
                                        text-gray-500"
                                >
                                    Nie znaleziono filmów.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- Paginacja --}}
            <div class="mt-6">
                {{ $movies->links() }}
            </div>

        </div>

    </div>

</x-app-layout>
