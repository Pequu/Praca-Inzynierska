<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Wybór miejsc - {{ $screening->movie->title }} - Peqursor
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-900">

    <!-- Navbar -->
    <header class="bg-black text-white h-16 flex items-center px-10">
        <a href="/" class="text-2xl font-bold">
            Peqursor
        </a>

        <nav class="ml-auto flex gap-8">
            <a href="/" class="hover:text-red-400">
                Repertuar
            </a>

            <a href="#" class="hover:text-red-400">
                Kina
            </a>

            <a href="#" class="hover:text-red-400">
                Kontakt
            </a>
        </nav>
    </header>


    <main class="max-w-7xl mx-auto py-10 px-4">

        <!-- Informacje o seansie -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                <div>

                    <h1 class="text-3xl font-bold">
                        {{ $screening->movie->title }}
                    </h1>

                    <p class="text-gray-500 mt-2">
                        {{ $screening->start_time->format('d.m.Y') }}
                        |
                        {{ $screening->start_time->format('H:i') }}
                    </p>

                </div>


                <span
                    class="inline-block text-white px-4 py-2 rounded-lg font-semibold"
                    style="background-color: {{ $screening->room->color }}">
                    {{ $screening->room->room_name }}
                </span>
            </div>
        </div>

        <!-- Wybór miejsc -->
        <div class="bg-white rounded-xl shadow-lg p-8">

            <h2 class="text-2xl font-bold text-center mb-10">
                Wybierz miejsca
            </h2>

            <!-- EKRAN -->
            <div class="flex justify-center mb-14">

                <div class="w-full max-w-4xl">
                    <div class="h-3 bg-gray-800 rounded-full shadow-lg"></div>
                    <p class="text-center text-gray-500 text-sm mt-3">
                        EKRAN
                    </p>
                </div>

            </div>

            <!-- MAPA SALI -->
            <div class="overflow-auto pb-8">

                <div
                    id="seatMap"
                    class="relative mx-auto"
                    style="
                        width: {{ ($seats->max('x') + 1) * 64 + 120 }}px;
                        height: {{ ($seats->max('y') + 1) * 64 }}px;
                    ">

                    @foreach($seats->groupBy('row') as $row => $rowSeats)

                        @php
                            $y = $rowSeats->first()->y;
                        @endphp


                        <!-- Cały rząd -->
                        <div
                            class="absolute flex items-center"
                            style="
                                left: 0;
                                top: {{ $y * 64 }}px;
                                width: 100%;
                                height: 60px;
                            ">

                            <!-- Numer rzędu - lewa strona -->
                            <div
                                class="
                                    w-10
                                    flex-shrink-0
                                    text-center
                                    font-bold
                                    text-gray-500
                                ">
                                {{ $row }}
                            </div>

                            <!-- Miejsca -->
                            <div class="relative flex-1 h-full">

                                @foreach($rowSeats as $seat)

                                    <!-- KANAPA -->
                                    @if($seat->type === 'couch')

                                        @php

                                            $couchSeats = $rowSeats
                                                ->where('type', 'couch')
                                                ->where('group_id', $seat->group_id)
                                                ->sortBy('number')
                                                ->values();

                                            $firstCouchSeat = $couchSeats->first();

                                            // Kanapę renderujemy tylko raz
                                            if ($seat->id !== $firstCouchSeat->id) {
                                                continue;
                                            }

                                            $couchSeatIds = $couchSeats
                                                ->pluck('id')
                                                ->values()
                                                ->toArray();

                                            $couchSeatNumbers = $couchSeats
                                                ->pluck('number')
                                                ->values()
                                                ->toArray();

                                            $isReserved = $couchSeats->contains(
                                                fn ($couchSeat) =>
                                                    $reservedSeats->contains($couchSeat->id)
                                            );

                                        @endphp


                                        <button
                                            type="button"
                                            data-seat-type="couch"
                                            data-seat-ids="{{ implode(',', $couchSeatIds) }}"
                                            data-seat-row="{{ $seat->row }}"
                                            data-seat-numbers="{{ implode(',', $couchSeatNumbers) }}"

                                            style="
                                                position: absolute;
                                                left: {{ $seat->x * 64 }}px;
                                                top: 4px;
                                                width: 112px;
                                            "

                                            @disabled($isReserved)

                                            class="
                                                seat
                                                h-12
                                                rounded-xl
                                                text-sm
                                                font-semibold
                                                transition
                                                duration-200
                                                z-10

                                                {{ $isReserved
                                                    ? 'bg-gray-400 text-gray-600 cursor-not-allowed'
                                                    : 'bg-gray-200 text-gray-700 hover:bg-red-500 hover:text-white'
                                                }}
                                            ">

                                            <span class="relative z-10">
                                                {{ implode(' ', $couchSeatNumbers) }}
                                            </span>

                                        </button>

                                    @else

                                        @php
                                            $isReserved = $reservedSeats->contains($seat->id);
                                        @endphp

                                        <!-- Zwykłe miejsce lub miejsce dla osoby na wózku -->
                                        <button
                                            type="button"
                                            data-seat-id="{{ $seat->id }}"
                                            data-seat-row="{{ $seat->row }}"
                                            data-seat-number="{{ $seat->number }}"
                                            data-seat-type="{{ $seat->type }}"
                                            data-seat-group="{{ $seat->group_id }}"

                                            style="
                                                position: absolute;
                                                left: {{ $seat->x * 64 }}px;
                                                top: 4px;
                                            "

                                            @disabled($isReserved)

                                            class="
                                                seat
                                                w-12
                                                h-12
                                                rounded-lg
                                                text-sm
                                                font-semibold
                                                transition
                                                duration-200
                                                z-10

                                                {{ $isReserved
                                                    ? 'bg-gray-400 text-gray-600 cursor-not-allowed'
                                                    : ($seat->type === 'wheelchair'
                                                        ? 'bg-blue-200 text-blue-800 border-2 border-blue-500 hover:bg-blue-500 hover:text-white'
                                                        : 'bg-gray-200 text-gray-700 hover:bg-red-500 hover:text-white'
                                                    )
                                                }}
                                            ">

                                            @if($seat->type === 'wheelchair')

                                                <span
                                                    class="
                                                        wheelchair-icon
                                                        absolute
                                                        inset-0
                                                        bottom-1
                                                        flex
                                                        items-center
                                                        justify-center
                                                        text-blue-600
                                                        text-4xl
                                                        opacity-25
                                                    ">
                                                    ♿
                                                </span>

                                                <span class="relative z-10">
                                                    {{ $seat->number }}
                                                </span>

                                            @else

                                                {{ $seat->number }}

                                            @endif

                                        </button>
                                    @endif

                                @endforeach

                                <!-- Kreska pod fotelami -->
                                <div
                                    class="
                                        absolute
                                        left-0
                                        right-0
                                        top-[29px]
                                        h-px
                                        bg-gray-300
                                    ">
                                </div>
                            </div>

                            <!-- Numer rzędu - prawa strona -->
                            <div class="w-10 flex-shrink-0 text-center font-bold text-gray-500">
                                {{ $row }}
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

            <!-- Legenda -->
            <div class="flex justify-center flex-wrap gap-8 mt-8">

                <!-- Wolne -->
                <div class="flex items-center gap-2">
                    <span class="w-5 h-5 bg-gray-200 rounded-md"></span>

                    <span class="text-sm">
                        Wolne
                    </span>
                </div>

                <!-- Wybrane -->
                <div class="flex items-center gap-2">
                    <span class="w-5 h-5 bg-red-600 rounded-md"></span>

                    <span class="text-sm">
                        Wybrane
                    </span>
                </div>

                <!-- Zajęte -->
                <div class="flex items-center gap-2">
                    <span class="w-5 h-5 bg-gray-400 rounded-md"></span>

                    <span class="text-sm">
                        Zajęte
                    </span>
                </div>

                <!-- Kanapa -->
                <div class="flex items-center gap-2">
                    <span
                        class="
                            w-10
                            h-5
                            bg-gray-200
                            rounded-md
                            flex
                            items-center
                            justify-center
                            text-gray-700
                            text-[9px]
                            font-bold
                        ">
                        1 2
                    </span>

                    <span class="text-sm">
                        Kanapa
                    </span>
                </div>

                <!-- Miejsce dla niepełnosprawnych -->
                <div class="flex items-center gap-2">
                    <span
                        class="
                            w-5
                            h-5
                            bg-blue-200
                            border-2
                            border-blue-500
                            rounded-md
                            flex
                            items-center
                            justify-center
                            text-blue-600
                            text-xs
                        ">
                        ♿
                    </span>
                    <span class="text-sm">
                        Miejsce dla niepełnosprawnych
                    </span>
                </div>
            </div>
        </div>

        <!-- PODSUMOWANIE -->
        <div class="bg-white rounded-xl shadow-md p-6 mt-6">

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

                <!-- Wybrane miejsca -->
                <div>

                    <h2 class="text-xl font-bold">
                        Wybrane miejsca
                    </h2>

                    <p
                        id="selectedSeats"
                        class="text-gray-500 mt-2">
                        Nie wybrano żadnych miejsc.
                    </p>

                </div>


                <!-- Liczba miejsc -->
                <div>

                    <p class="text-gray-500">
                        Liczba miejsc
                    </p>
                    <p
                        id="seatCount"
                        class="text-2xl font-bold">
                        0
                    </p>
                </div>

                <!-- Cena -->
                <div>
                    <p class="text-gray-500">
                        Cena
                    </p>
                    <p class="text-2xl font-bold">
                        <span id="totalPrice">
                            0.00
                        </span>
                        zł
                    </p>
                </div>

                <!-- Przycisk -->
                <button
                    type="button"
                    id="continueButton"
                    disabled

                    class="
                        px-8
                        py-3
                        rounded-lg
                        font-semibold
                        text-white
                        bg-gray-400
                        cursor-not-allowed
                        transition
                    ">
                    Dalej
                </button>
            </div>
        </div>
    </main>


    <script>
        const seats = document.querySelectorAll('.seat');
        const selectedSeatsElement = document.getElementById('selectedSeats');
        const seatCountElement = document.getElementById('seatCount');
        const totalPriceElement = document.getElementById('totalPrice');
        const continueButton = document.getElementById('continueButton');
        const ticketPrice = {{ $screening->screening_price }};

        let selectedSeats = [];


        /*
        * Kliknięcie miejsca
        */
        seats.forEach(seat => {
            seat.addEventListener('click', () => {

                const seatType = seat.dataset.seatType;
                const seatRow = seat.dataset.seatRow;

                /*
                * KANAPA
                */
                if (seatType === 'couch') {

                    const couchSeatIds = seat.dataset.seatIds
                        .split(',')
                        .filter(id => id !== '');

                    const couchSeatNumbers = seat.dataset.seatNumbers
                        .split(',')
                        .filter(number => number !== '');

                    /*
                    * Kanapa musi posiadać dokładnie dwa miejsca.
                    */
                    if (couchSeatIds.length !== 2) {

                        console.error(
                            'Kanapa nie posiada dokładnie dwóch ID:',
                            couchSeatIds
                        );
                        return;
                    }

                    const couchSeat1 = couchSeatIds[0];
                    const couchSeat2 = couchSeatIds[1];

                    /*
                    * Sprawdzamy, czy oba miejsca
                    * kanapy są już zaznaczone.
                    */
                    const couchAlreadySelected =
                        selectedSeats.some(
                            selected => selected.id === couchSeat1
                        ) &&
                        selectedSeats.some(
                            selected => selected.id === couchSeat2
                        );

                    /*
                    * ODZNACZENIE KANAPY
                    */
                    if (couchAlreadySelected) {

                        selectedSeats = selectedSeats.filter(
                            selected =>
                                selected.id !== couchSeat1 &&
                                selected.id !== couchSeat2
                        );

                        seat.classList.remove('bg-red-600', 'text-white');
                        seat.classList.add('bg-gray-200', 'text-gray-700');
                    }

                    /*
                    * ZAZNACZENIE KANAPY
                    */
                    else {
                        selectedSeats.push({
                            id: couchSeat1,
                            row: seatRow,
                            number: couchSeatNumbers[0],
                            type: 'couch'
                        });

                        selectedSeats.push({
                            id: couchSeat2,
                            row: seatRow,
                            number: couchSeatNumbers[1],
                            type: 'couch'
                        });

                        seat.classList.remove('bg-gray-200', 'text-gray-700');
                        seat.classList.add('bg-red-600', 'text-white');
                    }

                    updateSummary();
                    return;
                }

                /*
                * ZWYKŁE MIEJSCE / WHEELCHAIR
                */
                const seatId = seat.dataset.seatId;
                const seatNumber = seat.dataset.seatNumber;
                const alreadySelected = selectedSeats.some(
                    selected => selected.id === seatId
                );

                /*
                * ODZNACZENIE
                */
                if (alreadySelected) {
                    selectedSeats = selectedSeats.filter(
                        selected => selected.id !== seatId
                    );

                    // Wheelchair
                    if (seat.dataset.seatType === 'wheelchair') {
                        seat.classList.add('bg-blue-200', 'text-blue-800');
                        seat.classList.remove('bg-blue-600', 'text-white');
                    }

                    // Zwykłe miejsce
                    else {
                        seat.classList.remove('bg-red-600', 'text-white');
                        seat.classList.add('bg-gray-200', 'text-gray-700');
                    }
                }


                /*
                * ZAZNACZENIE
                */
                else {
                    selectedSeats.push({
                        id: seatId,
                        row: seatRow,
                        number: seatNumber,
                        type: seat.dataset.seatType
                    });

                    // Wheelchair
                    if (seat.dataset.seatType === 'wheelchair') {
                        seat.classList.add('bg-blue-600', 'text-white');
                        seat.classList.remove('bg-blue-200', 'text-blue-800');
                    }

                    // Zwykłe miejsce
                    else {
                        seat.classList.remove('bg-gray-200', 'text-gray-700');
                        seat.classList.add('bg-red-600', 'text-white');
                    }
                }

                updateSummary();
            });
        });

        /*
        * Aktualizacja podsumowania
        */
        function updateSummary(){
            // Lista miejsc
            if (selectedSeats.length === 0) {
                selectedSeatsElement.textContent =
                    'Nie wybrano żadnych miejsc.';

            } else {
                const seatNames = selectedSeats.map(
                    seat => `${seat.row}${seat.number}`
                );
                selectedSeatsElement.textContent = seatNames.join(', ');
            }

            // Liczba miejsc
            const count = selectedSeats.length;
            seatCountElement.textContent = count;

            // Cena
            const total = count * ticketPrice;
            totalPriceElement.textContent = total.toFixed(2);

            // Przycisk Dalej
            if (count > 0) {

                continueButton.disabled = false;

                continueButton.classList.remove(
                    'bg-gray-400',
                    'cursor-not-allowed'
                );

                continueButton.classList.add(
                    'bg-red-600',
                    'hover:bg-red-700'
                );

            } else {

                continueButton.disabled = true;

                continueButton.classList.remove(
                    'bg-red-600',
                    'hover:bg-red-700'
                );

                continueButton.classList.add(
                    'bg-gray-400',
                    'cursor-not-allowed'
                );
            }
        }

    </script>

</body>

</html>
