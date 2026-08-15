<x-app-layout>

    <div class="min-h-screen bg-zinc-900 border-2 border-gray-200
                py-10 px-6 rounded-2xl" id="header">

        <div class="max-w-7xl mx-auto">


            {{-- Nagłówek --}}
            <div class="flex items-center justify-between mb-8">
                <div>

                    <h1 class="text-4xl font-bold text-gray-200">
                        Zarządzanie seansami
                    </h1>

                    <p class="mt-2 text-gray-300">
                        Przeglądaj, edytuj i usuwaj seanse filmowe.
                    </p>

                </div>


                <div class="flex items-center gap-3 ">

                    @if(request('status') === 'past')

                        <x-a-secondary class="bg-red-950" href="{{ route('admin.screenings.index#header', [
                            'status' => 'upcoming',
                            'search' => request('search')]) }}">
                            Zakończone seanse
                        </x-a-secondary>

                    @else

                        <x-a-secondary href="{{ route('admin.screenings.index#header', [
                        'status' => 'past',
                        'search' => request('search')]) }}">
                            Przyszłe seanse
                        </x-a-secondary>

                    @endif


                    <x-a-secondary href="{{ route('admin') }}">
                        Powrót
                    </x-a-secondary>

                </div>

            </div>


            {{-- Komunikaty --}}
            @if(session('success'))

                <div class="mb-6 p-4 rounded-xl bg-green-100 text-green-800">
                    {{ session('success') }}
                </div>

            @endif


            @if(session('error'))

                <div class="mb-6 p-4 rounded-xl bg-red-100 text-red-800">
                    {{ session('error') }}
                </div>

            @endif


            {{-- Wyszukiwarka --}}
            <div class="bg-white rounded-2xl border border-gray-200
                        p-5 mb-6">

                <form
                    method="GET"
                    action="{{ route('admin.screenings.index') }}"
                    class="flex gap-3">

                    <input
                        type="hidden"
                        name="status"
                        value="{{ request('status', 'upcoming') }}">

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Szukaj.."
                        class="flex-1 rounded-xl border-gray-300
                               focus:border-zinc-500
                               focus:ring-zinc-500">

                    <x-primary-button>
                        Szukaj
                    </x-primary-button>

                </form>

            </div>


            {{-- Lista seansów --}}
            @php
                $currentSort = request('sort');
                $currentDirection = request('direction', 'asc');
            @endphp

            <div class="bg-white rounded-2xl border border-gray-200
                        shadow-sm overflow-hidden">

                <table class="w-full">

                    <thead class="bg-zinc-900 text-white">

                        <tr>

                            <th class="text-left px-6 py-4">
                                Film
                            </th>

                            <th class="text-left px-6 py-4">
                                Sala
                            </th>

                            <th class="text-left px-6 py-4">
                                Data
                            </th>

                            <th class="text-left px-6 py-4">
                                Godzina
                            </th>

                            <th class="text-left px-6 py-4">
                                Status
                            </th>

                            <th class="text-right px-6 py-4">
                                Akcje
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-gray-200">

                        @forelse($screenings as $screening)

                            <tr class="hover:bg-gray-50 transition">


                                {{-- Film --}}
                                <td class="px-6 py-4">

                                    <div class="flex items-center gap-4">

                                        @if($screening->movie?->poster)

                                            <img
                                                src="{{ asset('storage/' . $screening->movie->poster) }}"
                                                alt="{{ $screening->movie->title }}"
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
                                                {{ $screening->movie?->title ?? 'Brak filmu' }}
                                            </div>

                                        </div>

                                    </div>

                                </td>


                                {{-- Sala --}}
                                <td class="px-6 py-4 text-gray-600">

                                    {{ $screening->room?->room_name ?? 'Brak sali' }}

                                </td>


                                {{-- Data --}}
                                <td class="px-6 py-4 text-gray-600">

                                    {{ \Carbon\Carbon::parse($screening->start_time)->format('d.m.Y') }}

                                </td>


                                {{-- Godzina --}}
                                <td class="px-6 py-4 text-gray-600">

                                    {{ \Carbon\Carbon::parse($screening->start_time)->format('H:i') }}

                                </td>

                                {{-- Status --}}
                                <td>
                                    @if( $screening->status === 'scheduled')
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-600">Zaplanowany</span>
                                    @elseif( $screening->status === 'finished')
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-600">Zakończony</span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-600">Anulowany</span>
                                    @endif

                                </td>


                                {{-- Akcje --}}
                                <td class="px-6 py-4">

                                    <div class="flex justify-end gap-2">


                                        {{-- Edytuj --}}
                                        <a
                                            href="{{ route('admin.screenings.edit', $screening) }}"
                                            class="px-4 py-2 rounded-lg
                                                   bg-blue-100 text-blue-700
                                                   hover:bg-blue-200 transition"
                                        >
                                            Edytuj
                                        </a>


                                        {{-- Usuń --}}
                                        <form
                                            method="POST"
                                            action="{{ route('admin.screenings.destroy', $screening) }}"
                                            onsubmit="return confirm('Czy na pewno chcesz usunąć ten seans?');"
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
                                    Nie znaleziono seansów.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- Paginacja --}}
            <div class="mt-6">

                {{ $screenings->links() }}

            </div>

        </div>

    </div>

</x-app-layout>
