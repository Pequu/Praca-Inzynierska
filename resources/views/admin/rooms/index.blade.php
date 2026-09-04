<x-app-layout>

    <div class="min-h-screen bg-zinc-900 border-2 border-gray-200
                py-10 px-6 rounded-2xl">

        <div class="max-w-7xl mx-auto">

            {{-- Nagłówek --}}
            <div class="flex items-center justify-between mb-8">

                <div>
                    <h1 class="text-4xl font-bold text-gray-200">
                        Zarządzanie salami
                    </h1>

                    <p class="text-gray-400 mt-2">
                        Wybierz salę, której układ chcesz edytować.
                    </p>
                </div>

            </div>


            {{-- Lista sal --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3
                        gap-6">

                @forelse ($rooms as $room)

                    <div class="bg-zinc-800 border border-zinc-700
                                rounded-2xl p-6
                                hover:border-gray-500 transition">

                        <div class="flex items-start justify-between">

                            <div>
                                <h2 class="text-2xl font-bold text-gray-200">
                                    {{ $room->room_name }}
                                </h2>

                                <p class="text-gray-400 mt-2">
                                    Liczba miejsc:
                                    <span class="text-gray-200 font-semibold">
                                        {{ $room->seats_count }}
                                    </span>
                                </p>
                            </div>

                        </div>


                        {{-- Przycisk --}}
                        <div class="mt-6">

                            <a
                                href="{{ route('admin.rooms.edit', $room) }}"
                                class="block w-full text-center
                                       bg-indigo-600 hover:bg-indigo-500
                                       text-white font-semibold
                                       py-3 px-4 rounded-xl
                                       transition"
                            >
                                Edytuj układ
                            </a>

                        </div>

                    </div>

                @empty

                    <div class="col-span-full">

                        <div class="bg-zinc-800 border border-zinc-700
                                    rounded-2xl p-8 text-center">

                            <p class="text-gray-400">
                                Nie znaleziono żadnych sal.
                            </p>

                        </div>

                    </div>

                @endforelse

            </div>

        </div>

    </div>

</x-app-layout>
