<x-app-layout>
    <div class="min-h-screen bg-zinc-900 border-2 border-gray-200 py-10 px-6 rounded-2xl">

        <div class="max-w-7xl mx-auto">

            {{-- Nagłówek --}}
            <div class="flex items-center justify-between mb-8">

                <div>
                    <h1 class="text-4xl font-bold text-gray-200">
                        Zarządzanie Gatunkami
                    </h1>

                    <p class="mt-2 text-gray-300">
                        Przeglądaj i edytuj gatunki filmów.
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
                    action="{{ route('admin.genres.index') }}"
                    class="flex gap-3">

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Szukaj gatunku po nazwie..."
                        class="flex-1 rounded-xl border-gray-300
                            focus:border-zinc-500
                            focus:ring-zinc-500">

                    <x-primary-button>
                        Szukaj
                    </x-primary-button>

                </form>

            </div>


            {{-- Lista Gatunków --}}
            <div class="bg-white rounded-2xl border border-gray-200
                        shadow-sm overflow-hidden">

                <table class="w-full">

                    <thead class="bg-zinc-900 text-white">

                        <tr>

                            <th class="text-left px-6 py-4">
                                Nazwa
                            </th>

                            <th class="text-left px-6 py-4">
                                Kolor
                            </th>

                            <th class="text-right px-6 py-4">
                                Akcje
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-200">

                        @forelse($genres as $genre)

                            <tr class="hover:bg-gray-50 transition">

                                {{-- Nazwa --}}
                                <td class="px-6 py-4">

                                    <div class="flex items-center gap-4">

                                            <span class="font-semibold text-gray-900">
                                                {{ $genre->genre_name }}
                                            </span>


                                    </div>

                                </td>


                                {{-- Kolor --}}
                                <td class="px-6 py-4 text-gray-600">
                                    <span style="background-color:{{ $genre->color }}" class="px-3 rounded-full text-gray-100">{{ $genre->color }}</span>
                                </td>

                                {{-- Akcje --}}
                                <td class="px-6 py-4">

                                    <div class="flex justify-end gap-2">

                                        <a
                                            href="{{ route('admin.genres.edit', $genre) }}"
                                            class="px-4 py-2 rounded-lg
                                                bg-blue-100 text-blue-700
                                                hover:bg-blue-200 transition"
                                        >
                                            Edytuj
                                        </a>


                                        <form
                                            method="POST"
                                            action="{{ route('admin.genres.destroy', $genre) }}"
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
                                    Nie znaleziono gatunków.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- Paginacja --}}
            <div class="mt-6">
                {{ $genres->links() }}
            </div>

        </div>

    </div>

</x-app-layout>
