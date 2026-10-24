<x-app-layout>

    {{-- Główny kontener --}}
    <div class="min-h-screen px-4 py-10 sm:px-6">

        <div class="mx-auto max-w-4xl">

            {{-- Główna karta --}}
            <div
                class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-xl"
            >

                {{-- Sukces --}}
                <div
                    class="border-b border-zinc-200 bg-zinc-50 px-6 py-10 text-center sm:px-10"
                >

                    {{-- Ikona --}}
                    <div
                        class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-green-100"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-10 w-10 text-green-600"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M5 13l4 4L19 7"
                            />
                        </svg>
                    </div>

                    <h2
                        class="mt-5 text-3xl font-bold text-zinc-900"
                    >
                        Zakup zakończony pomyślnie
                    </h2>

                    <p
                        class="mx-auto mt-3 max-w-xl text-zinc-600"
                    >
                        Dziękujemy za zakup biletów.
                        Potwierdzenie zakupu zostało wysłane na adres:
                    </p>

                    <p
                        class="mt-2 font-semibold text-zinc-900"
                    >
                        {{ $reservation->customer_email }}
                    </p>

                </div>


                {{-- Informacje o rezerwacji --}}
                <div class="px-6 py-8 sm:px-10">
                    
                    <div class="mb-8 flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
                        
                        <div>
                            <p class="text-sm font-medium uppercase tracking-wider text-zinc-500">
                                Numer rezerwacji
                            </p>

                            <p class="mt-1 text-2xl font-bold text-zinc-900">
                                #{{ $reservation->id }}
                            </p>

                        </div>

                        <div class="rounded-full bg-green-100 px-4 py-2 text-sm font-semibold text-green-700">
                            Płatność potwierdzona
                        </div>

                    </div>


                    {{-- Informacje o filmie --}}
                    <div class="rounded-xl border border-zinc-200 bg-zinc-50 p-6">

                        <h3 class="text-2xl font-bold text-zinc-900">
                            {{ $reservation->screening->movie->title }}
                        </h3>

                        <div class="mt-5 grid gap-5 sm:grid-cols-2">
                            {{-- Data --}}
                            <div>
                                <p class="text-sm text-zinc-500">
                                    Data
                                </p>

                                <p class="mt-1 font-semibold text-zinc-900">
                                    {{ $reservation->screening->start_time->format('d.m.Y') }}
                                </p>
                            </div>


                            {{-- Godzina --}}
                            <div>
                                <p class="text-sm text-zinc-500">
                                    Godzina
                                </p>

                                <p class="mt-1 font-semibold text-zinc-900">
                                    {{ $reservation->screening->start_time->format('H:i') }}
                                </p>
                            </div>

                            {{-- Sala --}}
                            <div>
                                <p class="text-sm text-zinc-500">
                                    Sala
                                </p>

                                <p class="mt-1 font-semibold text-zinc-900">
                                    {{ $reservation->screening->room->room_name }}
                                </p>

                            </div>

                            {{-- Liczba biletów --}}
                            <div>
                                <p class="text-sm text-zinc-500">
                                    Liczba biletów
                                </p>

                                <p class="mt-1 font-semibold text-zinc-900">
                                    {{ $reservation->tickets->count() }}
                                </p>
                            </div>

                        </div>

                    </div>


                    {{-- Miejsca --}}
                    <div class="mt-8">

                        <h3 class="text-lg font-bold text-zinc-900">
                            Wybrane miejsca
                        </h3>

                        <div class="mt-4 flex flex-wrap gap-3">

                            @foreach ($reservation->reservationSeats as $reservationSeat)

                                <div class="rounded-lg border border-zinc-300 bg-white px-4 py-3 shadow-sm">

                                    <span class="text-sm text-zinc-500">
                                        Miejsce
                                    </span>

                                    <span class="ml-1 font-bold text-zinc-900">
                                        {{ $reservationSeat->seat->row }}
                                        {{ $reservationSeat->seat->number }}
                                    </span>

                                </div>

                            @endforeach

                        </div>

                    </div>


                    {{-- Podsumowanie ceny --}}
                    <div class="mt-8 flex items-center justify-between border-t border-zinc-200 pt-6">

                        <span class="text-lg font-semibold text-zinc-600">
                            Łącznie
                        </span>

                        <span class="text-3xl font-black text-red-600">
                            {{ number_format($reservation->total_price, 2, ',', ' ') }} zł
                        </span>

                    </div>

                    {{-- Informacja o biletach --}}
                    <div class="mt-8 rounded-xl border border-red-100 bg-red-50 p-5">

                        <div class="flex gap-4">

                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-red-100">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 text-red-600"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M3 10h18M7 15h1m4 0h1m4 0h1M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                    />
                                </svg>

                            </div>

                            <div>

                                <p class="font-semibold text-zinc-900">
                                    Twoje bilety są gotowe
                                </p>

                                <p class="mt-1 text-sm leading-6 text-zinc-600">
                                    Możesz pobrać bilety w formacie PDF. Każdy bilet zawiera indywidualny kod QR, który należy okazać przy wejściu do kina.
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- Przyciski --}}
                    <div class="mt-8 flex flex-col gap-3 sm:flex-row">

                        {{-- Przycisk pobierania biletów PDF --}}
                        <a href="{{ route('reservations.tickets.pdf', [
                                'reservation' => $reservation,
                                'access_token' => $reservation->access_token,
                            ]) }}"
                            id="download-tickets"
                            class="group relative flex flex-1 items-center justify-center gap-3 overflow-hidden rounded-xl bg-red-600 px-6 py-3 font-semibold text-white transition-all duration-300 hover:bg-red-700 hover:shadow-lg hover:shadow-red-600/20 active:scale-[0.98]"
                        >
                            <svg
                                id="download-icon"
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 transition-transform duration-300 group-hover:translate-y-0.5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                            {{-- Ścieżka rysująca strzałkę i podstawę pobierania --}}
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 3v12m0 0l-4-4m4 4l4-4M5 17v3h14v-3"
                                />
                            </svg>

                            <span id="download-text">Pobierz bilety PDF</span>

                            {{-- Animowany wskaźnik ładowania --}}
                            <span
                                id="download-spinner"
                                class="hidden h-5 w-5 animate-spin rounded-full border-2 border-white/30 border-t-white"
                            ></span>
                        </a>


                        <a href="{{ route('screenings.index') }}"
                            class="flex-1 rounded-xl border border-zinc-300 bg-white px-6 py-3 text-center font-semibold text-zinc-900 transition hover:bg-zinc-100"
                        >
                            Wróć do repertuaru
                        </a>

                    </div>

                </div>

            </div>


            {{-- Stopka --}}
            <div class="mt-6 text-center text-sm text-zinc-500">
                <p>
                    Peqursor Cinema
                </p>

                <p class="mt-1">
                    Dziękujemy za skorzystanie z naszego kina.
                </p>
            </div>

        </div>

    </div>

</x-app-layout>


{{-- Skrypt obsługujący animację przycisku pobierania --}}
<script>
    // Uruchom kod dopiero po zbudowaniu struktury HTML strony
    document.addEventListener('DOMContentLoaded', () => {

        const button = document.getElementById('download-tickets');
        const text = document.getElementById('download-text');
        const icon = document.getElementById('download-icon');
        const spinner = document.getElementById('download-spinner');

        if (!button || !text || !icon || !spinner) {
            return;
        }

        button.addEventListener('click', () => {

            text.textContent = 'Przygotowuję bilety...';

            icon.classList.add('hidden');
            spinner.classList.remove('hidden');

            // Zmień kursor na oczekiwania i oznacz element jako zajęty
            button.classList.add('cursor-wait');
            button.setAttribute('aria-busy', 'true');

            window.setTimeout(() => {

                text.textContent = 'Pobierz bilety PDF';

                icon.classList.remove('hidden');
                spinner.classList.add('hidden');

                // Przywróć standardowy kursor i usuń oznaczenie zajętości
                button.classList.remove('cursor-wait');
                button.removeAttribute('aria-busy');

            }, 2500); // Czas wyświetlania animacji: 2500 ms 
        });
    });
</script>
