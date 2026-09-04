<x-app-layout>

    <div class="min-h-screen bg-zinc-900 border-2 border-gray-200 py-6 px-6 rounded-2xl">

        <div class="max-w-7xl">

            {{-- Nagłówek --}}
            <div class="mb-10">
                <h1 class="text-4xl font-bold text-gray-200">
                    Panel administratora
                </h1>

                <p class="mt-2 text-gray-300">
                    Zarządzaj systemem kina Peqursor
                </p>
            </div>


            {{-- Kafelki --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">


                {{-- Konta --}}
                <a href="{{ Route('admin.users.index') }}"
                class="group admin-panel ">

                    <div class="flex items-start justify-between">

                        <div class="w-14 h-14 rounded-xl bg-blue-200
                                    flex items-center justify-center
                                    text-blue-600 text-2xl">

                            👤

                        </div>

                        <span class="text-gray-300 group-hover:text-blue-500
                                    transition text-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" width="2rem" height="2rem" fill="currentColor" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8"/>
                            </svg>
                        </span>

                    </div>

                    <h2 class="mt-6 text-xl font-bold text-gray-200">
                        Zarządzanie kontami
                    </h2>

                    <p class="mt-2 text-sm text-gray-300">
                        Zarządzaj użytkownikami, pracownikami
                        oraz uprawnieniami.
                    </p>

                </a>


                {{-- Sale --}}
                <a href="{{ route('admin.rooms.index') }}"
                class="group admin-panel">

                    <div class="flex items-start justify-between">

                        <div class="w-14 h-14 rounded-xl bg-purple-100
                                    flex items-center justify-center
                                    text-purple-600 text-2xl">

                            🏢

                        </div>

                        <span class="text-gray-300 group-hover:text-purple-500
                                    transition text-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" width="2rem" height="2rem" fill="currentColor" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8"/>
                            </svg>
                        </span>

                    </div>

                    <h2 class="mt-6 text-xl font-bold text-gray-200">
                        Zarządzanie salami
                    </h2>

                    <p class="mt-2 text-sm text-gray-300">
                        Dodawaj, edytuj i usuwaj sale kinowe
                        oraz ich miejsca.
                    </p>

                </a>


                {{-- Seanse --}}
                <a href="{{ route('admin.screenings.index') }}"
                class="group admin-panel">

                    <div class="flex items-start justify-between">

                        <div class="w-14 h-14 rounded-xl bg-red-100
                                    flex items-center justify-center
                                    text-red-600 text-2xl">

                            🎬

                        </div>

                        <span class="text-gray-300 group-hover:text-red-500
                                    transition text-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" width="2rem" height="2rem" fill="currentColor" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8"/>
                            </svg>
                        </span>

                    </div>

                    <h2 class="mt-6 text-xl font-bold text-gray-200">
                        Zarządzanie seansami
                    </h2>

                    <p class="mt-2 text-sm text-gray-300">
                        Planuj seanse, przypisuj filmy i sale
                        oraz zmieniaj godziny.
                    </p>

                </a>


                {{-- Rezerwacje --}}
                <a href="#"
                class="group admin-panel">

                    <div class="flex items-start justify-between">

                        <div class="w-14 h-14 rounded-xl bg-green-100
                                    flex items-center justify-center
                                    text-green-600 text-2xl">

                            🎟️

                        </div>

                        <span class="text-gray-300 group-hover:text-green-500
                                    transition text-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" width="2rem" height="2rem" fill="currentColor" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8"/>
                            </svg>
                        </span>

                    </div>

                    <h2 class="mt-6 text-xl font-bold text-gray-200">
                        Rezerwacje
                    </h2>

                    <p class="mt-2 text-sm text-gray-300">
                        Przeglądaj i zarządzaj rezerwacjami
                        oraz biletami.
                    </p>

                </a>


                {{-- Filmy --}}
                <a href="{{ route('admin.movies.index') }}"
                class="group admin-panel">
                    <div class="flex items-start justify-between">
                        <div class="w-14 h-14 rounded-xl bg-yellow-100
                                    flex items-center justify-center
                                    text-yellow-600 text-2xl">
                            🎞️
                        </div>

                        <span class="text-gray-300 group-hover:text-yellow-500
                                    transition text-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" width="2rem" height="2rem" fill="currentColor" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8"/>
                            </svg>
                        </span>

                    </div>

                    <h2 class="mt-6 text-xl font-bold text-gray-200">
                        Zarządzanie filmami
                    </h2>

                    <p class="mt-2 text-sm text-gray-300">
                        Dodawaj filmy, opisy, plakaty, gatunki
                        oraz informacje o produkcjach.
                    </p>

                </a>


                {{-- Gatunki --}}
                <a href="{{ route('admin.genres.index') }}"
                class="group admin-panel">

                    <div class="flex items-start justify-between">

                        <div class="w-14 h-14 rounded-xl bg-pink-100
                                    flex items-center justify-center
                                    text-pink-600 text-2xl">

                            🏷️

                        </div>

                        <span class="text-gray-300 group-hover:text-pink-500
                                    transition text-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" width="2rem" height="2rem" fill="currentColor" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8"/>
                            </svg>
                        </span>

                    </div>

                    <h2 class="mt-6 text-xl font-bold text-gray-200">
                        Zarządzanie gatunkami
                    </h2>

                    <p class="mt-2 text-sm text-gray-300">
                        Dodawaj i edytuj gatunki filmowe
                        dostępne w systemie.
                    </p>

                </a>

            </div>

        </div>

    </div>
</x-app-layout>
