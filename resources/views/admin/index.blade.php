<x-app-layout>

    <div class="min-h-screen bg-gray-100 py-10 px-6 rounded-2xl">

        <div class="max-w-7xl mx-auto">

            {{-- Nagłówek --}}
            <div class="mb-10">
                <h1 class="text-4xl font-bold text-gray-900">
                    Panel administratora
                </h1>

                <p class="mt-2 text-gray-500">
                    Zarządzaj systemem kina Peqursor
                </p>
            </div>


            {{-- Kafelki --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">


                {{-- Konta --}}
                <a href="#"
                class="group bg-white rounded-2xl border border-gray-200 p-6
                        shadow-sm hover:shadow-xl hover:-translate-y-1
                        transition-all duration-300">

                    <div class="flex items-start justify-between">

                        <div class="w-14 h-14 rounded-xl bg-blue-100
                                    flex items-center justify-center
                                    text-blue-600 text-2xl">

                            👤

                        </div>

                        <span class="text-gray-300 group-hover:text-blue-500
                                    transition text-xl">
                            →
                        </span>

                    </div>

                    <h2 class="mt-6 text-xl font-bold text-gray-900">
                        Zarządzanie kontami
                    </h2>

                    <p class="mt-2 text-sm text-gray-500">
                        Zarządzaj użytkownikami, pracownikami
                        oraz uprawnieniami.
                    </p>

                </a>


                {{-- Sale --}}
                <a href="#"
                class="group bg-white rounded-2xl border border-gray-200 p-6
                        shadow-sm hover:shadow-xl hover:-translate-y-1
                        transition-all duration-300">

                    <div class="flex items-start justify-between">

                        <div class="w-14 h-14 rounded-xl bg-purple-100
                                    flex items-center justify-center
                                    text-purple-600 text-2xl">

                            🏢

                        </div>

                        <span class="text-gray-300 group-hover:text-purple-500
                                    transition text-xl">
                            →
                        </span>

                    </div>

                    <h2 class="mt-6 text-xl font-bold text-gray-900">
                        Zarządzanie salami
                    </h2>

                    <p class="mt-2 text-sm text-gray-500">
                        Dodawaj, edytuj i usuwaj sale kinowe
                        oraz ich miejsca.
                    </p>

                </a>


                {{-- Seanse --}}
                <a href="#"
                class="group bg-white rounded-2xl border border-gray-200 p-6
                        shadow-sm hover:shadow-xl hover:-translate-y-1
                        transition-all duration-300">

                    <div class="flex items-start justify-between">

                        <div class="w-14 h-14 rounded-xl bg-red-100
                                    flex items-center justify-center
                                    text-red-600 text-2xl">

                            🎬

                        </div>

                        <span class="text-gray-300 group-hover:text-red-500
                                    transition text-xl">
                            →
                        </span>

                    </div>

                    <h2 class="mt-6 text-xl font-bold text-gray-900">
                        Zarządzanie seansami
                    </h2>

                    <p class="mt-2 text-sm text-gray-500">
                        Planuj seanse, przypisuj filmy i sale
                        oraz zmieniaj godziny.
                    </p>

                </a>


                {{-- Rezerwacje --}}
                <a href="#"
                class="group bg-white rounded-2xl border border-gray-200 p-6
                        shadow-sm hover:shadow-xl hover:-translate-y-1
                        transition-all duration-300">

                    <div class="flex items-start justify-between">

                        <div class="w-14 h-14 rounded-xl bg-green-100
                                    flex items-center justify-center
                                    text-green-600 text-2xl">

                            🎟️

                        </div>

                        <span class="text-gray-300 group-hover:text-green-500
                                    transition text-xl">
                            →
                        </span>

                    </div>

                    <h2 class="mt-6 text-xl font-bold text-gray-900">
                        Rezerwacje
                    </h2>

                    <p class="mt-2 text-sm text-gray-500">
                        Przeglądaj i zarządzaj rezerwacjami
                        oraz biletami.
                    </p>

                </a>


                {{-- Filmy --}}
                <a href="#"
                class="group bg-white rounded-2xl border border-gray-200 p-6
                        shadow-sm hover:shadow-xl hover:-translate-y-1
                        transition-all duration-300">

                    <div class="flex items-start justify-between">

                        <div class="w-14 h-14 rounded-xl bg-yellow-100
                                    flex items-center justify-center
                                    text-yellow-600 text-2xl">

                            🎞️

                        </div>

                        <span class="text-gray-300 group-hover:text-yellow-500
                                    transition text-xl">
                            →
                        </span>

                    </div>

                    <h2 class="mt-6 text-xl font-bold text-gray-900">
                        Zarządzanie filmami
                    </h2>

                    <p class="mt-2 text-sm text-gray-500">
                        Dodawaj filmy, opisy, plakaty, gatunki
                        oraz informacje o produkcjach.
                    </p>

                </a>


                {{-- Gatunki --}}
                <a href="#"
                class="group bg-white rounded-2xl border border-gray-200 p-6
                        shadow-sm hover:shadow-xl hover:-translate-y-1
                        transition-all duration-300">

                    <div class="flex items-start justify-between">

                        <div class="w-14 h-14 rounded-xl bg-pink-100
                                    flex items-center justify-center
                                    text-pink-600 text-2xl">

                            🏷️

                        </div>

                        <span class="text-gray-300 group-hover:text-pink-500
                                    transition text-xl">
                            →
                        </span>

                    </div>

                    <h2 class="mt-6 text-xl font-bold text-gray-900">
                        Zarządzanie gatunkami
                    </h2>

                    <p class="mt-2 text-sm text-gray-500">
                        Dodawaj i edytuj gatunki filmowe
                        dostępne w systemie.
                    </p>

                </a>

            </div>

        </div>

    </div>
</x-app-layout>
