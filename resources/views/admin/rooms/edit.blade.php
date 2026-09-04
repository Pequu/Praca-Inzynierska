<!DOCTYPE html>
<html lang="pl">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Edycja sali - {{ $room->room_name }} - Peqursor
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>


<body class="bg-gray-100 text-gray-900">


<!-- NAVBAR -->

<header class="bg-black text-white h-16 flex items-center px-10">

    <a
        href="/"
        class="text-2xl font-bold"
    >
        Peqursor
    </a>


    <nav class="ml-auto flex gap-8">

        <a
            href="/"
            class="hover:text-red-400"
        >
            Repertuar
        </a>

        <a
            href="#"
            class="hover:text-red-400"
        >
            Kina
        </a>

        <a
            href="#"
            class="hover:text-red-400"
        >
            Kontakt
        </a>

    </nav>

</header>



<main class="max-w-[1600px] mx-auto py-10 px-6">


    <!-- INFORMACJE O SALI -->

    <div class="bg-white rounded-xl shadow-md p-6 mb-8">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>

                <a
                    href="{{ route('admin.rooms.index') }}"
                    class="text-sm text-gray-500 hover:text-gray-900"
                >
                    ← Powrót do sal
                </a>


                <h1 class="text-3xl font-bold mt-3">
                    {{ $room->room_name }}
                </h1>


                <p class="text-gray-500 mt-2">
                    Edycja układu miejsc
                </p>

            </div>


            <span
                class="text-white px-5 py-2 rounded-lg font-semibold"
                style="background-color: {{ $room->color }}"
            >
                {{ $room->room_name }}
            </span>

        </div>

    </div>



    <!-- EDYTOR -->

    <div class="grid grid-cols-1 xl:grid-cols-[1fr_340px] gap-6">


        <!-- MAPA -->

        <div class="bg-white rounded-xl shadow-lg p-8">


            <div class="flex items-center justify-between mb-8">

                <div>

                    <h2 class="text-2xl font-bold">
                        Układ sali
                    </h2>

                    <p class="text-gray-500 text-sm mt-1">
                        Kliknij puste pole, aby je zaznaczyć.
                        Typ miejsca wybierzesz w panelu po prawej.
                    </p>

                </div>


                <div class="text-sm text-gray-500">

                    Miejsc:

                    <span
                        id="seatCounter"
                        class="font-bold text-gray-900"
                    >
                        {{ $seats->count() }}
                    </span>

                </div>

            </div>



            <!-- EKRAN -->

            <div class="flex justify-center mb-14">

                <div class="w-full max-w-4xl">

                    <div
                        class="h-3 bg-gray-800 rounded-full shadow-lg"
                    ></div>

                    <p class="text-center text-gray-500 text-sm mt-3">
                        EKRAN
                    </p>

                </div>

            </div>



            <!-- SIATKA -->

            <div class="overflow-auto pb-8">

                <div
                    id="seatMap"
                    class="relative mx-auto"
                    style="
                        width: 1120px;
                        height: 700px;
                    "
                >

                    @for($y = 1; $y < 10; $y++)

                        <!-- RZĄD -->

                        <div
                            class="absolute flex items-center"
                            style="
                                left: 0;
                                top: {{ $y * 64 }}px;
                                width: 100%;
                                height: 60px;
                            "
                        >

                            <!-- NUMER RZĘDU -->

                            <div
                                class="
                                    w-10
                                    flex-shrink-0
                                    text-center
                                    font-bold
                                    text-gray-500
                                "
                            >
                                {{ chr(64 + $y) }}
                            </div>


                            <!-- OBSZAR RZĘDU -->

                            <div
                                id="row-{{ $y }}"
                                class="
                                    relative
                                    flex-1
                                    h-full
                                    seat-row
                                "
                                data-row="{{ $y }}"
                            >

                                <!-- LINIA -->

                                <div
                                    class="
                                        absolute
                                        left-0
                                        right-0
                                        top-[29px]
                                        h-px
                                        bg-gray-300
                                        pointer-events-none
                                    "
                                ></div>


                                <!-- PUSTE POLA -->

                                @for($x = 1; $x < 16; $x++)

                                    <div
                                        class="
                                            grid-cell
                                            absolute
                                            w-12
                                            h-12
                                            rounded-lg
                                            border-2
                                            border-dashed
                                            border-gray-200
                                            hover:border-gray-400
                                            hover:bg-gray-100
                                            cursor-pointer
                                            transition
                                        "
                                        style="
                                            left: {{ ($x -1)* 64 }}px;
                                            top: 4px;
                                        "
                                        data-x="{{ $x }}"
                                        data-y="{{ $y }}"
                                    ></div>

                                @endfor

                            </div>


                            <!-- NUMER RZĘDU -->

                            <div
                                class="
                                    w-10
                                    flex-shrink-0
                                    text-center
                                    font-bold
                                    text-gray-500
                                "
                            >
                                {{ chr(65 + $y) }}
                            </div>

                        </div>

                    @endfor

                </div>

            </div>



            <!-- LEGENDA -->

            <div class="flex justify-center flex-wrap gap-8 mt-8">

                <div class="flex items-center gap-2">

                    <span
                        class="w-5 h-5 bg-gray-200 rounded-md"
                    ></span>

                    <span class="text-sm">
                        Standard
                    </span>

                </div>


                <div class="flex items-center gap-2">

                    <span
                        class="
                            w-5
                            h-5
                            bg-blue-200
                            border-2
                            border-blue-500
                            rounded-md
                        "
                    ></span>

                    <span class="text-sm">
                        Wheelchair
                    </span>

                </div>


                <div class="flex items-center gap-2">

                    <span
                        class="
                            w-10
                            h-5
                            bg-gray-200
                            rounded-md
                        "
                    ></span>

                    <span class="text-sm">
                        Kanapa
                    </span>

                </div>

            </div>

        </div>



        <!-- PANEL PRAWA -->

        <div
            class="
                bg-white
                rounded-xl
                shadow-lg
                p-6
                h-fit
                sticky
                top-6
            "
        >

            <h2 class="text-xl font-bold mb-6">
                Edycja miejsca
            </h2>


            <!-- BRAK WYBORU -->

            <div id="noSeatSelected">

                <p class="text-gray-500 text-sm">

                    Kliknij istniejące miejsce albo puste pole.

                </p>

            </div>



            <!-- PANEL MIEJSCA -->

            <div
                id="seatEditor"
                class="hidden"
            >


                <!-- TYP -->

                <div class="mb-5">

                    <label
                        for="seatType"
                        class="
                            block
                            text-sm
                            font-medium
                            text-gray-700
                            mb-2
                        "
                    >
                        Typ miejsca
                    </label>


                    <select
                        id="seatType"
                        class="
                            w-full
                            border
                            border-gray-300
                            rounded-lg
                            px-3
                            py-2
                            focus:ring-2
                            focus:ring-red-500
                            focus:border-red-500
                        "
                    >

                        <option value="">
                            Puste
                        </option>

                        <option value="standard">
                            Standard
                        </option>

                        <option value="wheelchair">
                            Wheelchair
                        </option>

                        <option value="couch">
                            Kanapa
                        </option>

                    </select>

                </div>



                <!-- NUMER -->

                <div class="mb-5">

                    <label
                        for="seatNumber"
                        class="block text-sm font-medium text-gray-700 mb-1">
                        Numer fotela
                    </label>


                    <input
                        id="seatNumber"
                        type="number"
                        readonly
                        class="
                            w-full
                            bg-gray-100
                            border
                            border-gray-300
                            rounded-lg
                            px-3
                            py-2
                            cursor-not-allowed
                        "
                    >

                </div>



                <!-- RZĄD -->

                <div class="mb-5">

                    <label
                        for="seatRow"
                        class="block text-sm font-medium text-gray-700 mb-1">
                        Rząd
                    </label>


                    <input
                        id="seatRow"
                        type="text"
                        readonly
                        class="
                            w-full
                            bg-gray-100
                            border
                            border-gray-300
                            rounded-lg
                            px-3
                            py-2
                            cursor-not-allowed
                        "
                    >

                </div>



                <!-- POZYCJA -->

                <div class="grid grid-cols-2 gap-3 mb-6">

                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Kolumna
                        </label>

                        <input
                            id="seatX"
                            type="number"
                            readonly
                            class="
                                w-full
                                bg-gray-100
                                border
                                rounded-lg
                                px-3
                                py-2
                                cursor-not-allowed
                            "
                        >

                    </div>


                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Wiersz
                        </label>

                        <input
                            id="seatY"
                            type="number"
                            readonly
                            class="
                                w-full
                                bg-gray-100
                                border
                                rounded-lg
                                px-3
                                py-2
                                cursor-not-allowed
                            "
                        >

                    </div>

                </div>



                <!-- PRZYCISKI -->

                <div class="space-y-3">

                    <button
                        type="button"
                        id="deleteSeat"
                        class="
                            w-full
                            px-4
                            py-3
                            rounded-lg
                            bg-red-100
                            text-red-700
                            font-semibold
                            hover:bg-red-200
                            transition
                        "
                    >
                        Usuń miejsce
                    </button>


                    <button
                        type="button"
                        id="saveSeat"
                        class="
                            w-full
                            px-4
                            py-3
                            rounded-lg
                            bg-red-600
                            text-white
                            font-semibold
                            hover:bg-red-700
                            transition
                        "
                    >
                        Zastosuj zmiany
                    </button>

                </div>

            </div>

        </div>

    </div>



    <!-- ZAPIS -->

    <div
        class="
            bg-white
            rounded-xl
            shadow-md
            p-6
            mt-6
            flex
            items-center
            justify-between
        "
    >

        <div>

            <h2 class="font-bold text-lg">
                Zapis układu
            </h2>

            <p
                id="saveStatus"
                class="text-sm text-gray-500 mt-1"
            >
                Niezapisane zmiany
            </p>

        </div>


        <button
            type="button"
            id="saveRoom"
            class="
                px-8
                py-3
                rounded-lg
                bg-red-600
                text-white
                font-semibold
                hover:bg-red-700
                transition
            "
        >
            Zapisz układ sali
        </button>

    </div>

</main>



<script>

    /*
     * DANE POCZĄTKOWE
     */

    let seats = @json($seats->values());


    let selectedSeat = null;

    let selectedPosition = null;

    let temporaryId = -1;

    let temporaryGroupId = -1;



    /*
     * ELEMENTY
     */

    const seatMap =
        document.getElementById('seatMap');

    const seatEditor =
        document.getElementById('seatEditor');

    const noSeatSelected =
        document.getElementById('noSeatSelected');

    const seatType =
        document.getElementById('seatType');

    const seatNumber =
        document.getElementById('seatNumber');

    const seatRow =
        document.getElementById('seatRow');

    const seatX =
        document.getElementById('seatX');

    const seatY =
        document.getElementById('seatY');

    const seatCounter =
        document.getElementById('seatCounter');

    const saveStatus =
        document.getElementById('saveStatus');



    /*
     * ZNAJDŹ NASTĘPNY NUMER W RZĘDZIE
     */

    function getNextNumber(y)
    {
        const numbers = seats
            .filter(seat => seat.y === y)
            .map(seat => Number(seat.number))
            .sort((a, b) => a - b);


        let number = 1;


        while (numbers.includes(number)) {
            number++;
        }


        return number;
    }



    /*
     * RENDEROWANIE MIEJSC
     */

    function renderSeats()
    {
        document
            .querySelectorAll('.seat')
            .forEach(element => element.remove());


        const renderedCouches = new Set();


        seats
            .sort((a, b) => {

                if (a.y !== b.y) {
                    return a.y - b.y;
                }

                return a.x - b.x;

            })
            .forEach(seat => {


                /*
                 * KANAPA
                 */

                if (seat.type === 'couch') {

                    if (renderedCouches.has(seat.group_id)) {
                        return;
                    }


                    const couchSeats =
                        seats
                            .filter(item =>
                                item.type === 'couch' &&
                                item.group_id === seat.group_id
                            )
                            .sort((a, b) =>
                                a.x - b.x
                            );


                    if (couchSeats.length !== 2) {
                        return;
                    }


                    renderedCouches.add(
                        seat.group_id
                    );


                    const row =
                        document.getElementById(
                            `row-${seat.y}`
                        );


                    if (!row) {
                        return;
                    }


                    const button =
                        document.createElement('button');


                    button.type = 'button';


                    button.className = `
                        seat
                        absolute
                        h-12
                        rounded-xl
                        text-sm
                        font-semibold
                        bg-gray-200
                        text-gray-700
                        hover:bg-red-500
                        hover:text-white
                        transition
                        z-20
                        border
                        border-transparent
                    `;


                    button.style.left =
                        `${(seat.x - 1) * 64}px`;


                    button.style.top =
                        '4px';


                    button.style.width =
                        '112px';


                    button.textContent =
                        couchSeats
                            .map(item => item.number)
                            .join(' ');


                    button.dataset.id =
                        seat.id;


                    button.addEventListener(
                        'click',
                        event => {

                            event.stopPropagation();


                            selectedPosition =
                                null;


                            selectedSeat =
                                seat;


                            openEditor(
                                seat
                            );

                        }
                    );


                    row.appendChild(
                        button
                    );


                    return;
                }



                /*
                 * STANDARD / WHEELCHAIR
                 */

                const row =
                    document.getElementById(
                        `row-${seat.y}`
                    );


                if (!row) {
                    return;
                }


                const button =
                    document.createElement('button');


                button.type = 'button';


                button.className = `
                    seat
                    absolute
                    w-12
                    h-12
                    rounded-lg
                    text-sm
                    font-semibold
                    transition
                    z-20
                `;


                button.style.left =
                    `${(seat.x - 1) * 64}px`;


                button.style.top =
                    '4px';



                /*
                 * WHEELCHAIR
                 */

                if (
                    seat.type === 'wheelchair'
                ) {

                    button.classList.add(
                        'bg-blue-200',
                        'text-blue-800',
                        'border-2',
                        'border-blue-500',
                        'hover:bg-blue-300',
                        'hover:border-blue-600',
                        'hover:text-blue-900'
                    );


                    button.innerHTML = `
                        <span
                            class="
                                absolute
                                inset-0
                                flex
                                items-center
                                justify-center
                                text-blue-600
                                text-4xl
                                opacity-25
                            "
                        >
                            ♿
                        </span>

                        <span class="relative z-10">
                            ${seat.number}
                        </span>
                    `;

                } else {

                    button.classList.add(
                        'bg-gray-200',
                        'text-gray-700',
                        'hover:bg-red-500',
                        'hover:text-white'
                    );


                    button.textContent =
                        seat.number;

                }


                button.addEventListener(
                    'click',
                    event => {

                        event.stopPropagation();


                        selectedPosition =
                            null;


                        selectedSeat =
                            seat;


                        openEditor(
                            seat
                        );

                    }
                );


                row.appendChild(
                    button
                );

            });


        /*
         * LICZNIK
         */

        seatCounter.textContent =
            seats.length;
    }



    /*
     * OTWARCIE EDYTORA DLA ISTNIEJĄCEGO MIEJSCA
     */

    function openEditor(seat)
    {
        noSeatSelected.classList.add(
            'hidden'
        );

        seatEditor.classList.remove(
            'hidden'
        );


        seatType.value =
            seat.type;


        seatNumber.value =
            seat.number;


        seatRow.value =
            seat.row;


        seatX.value =
            seat.x;


        seatY.value =
            seat.y;
    }



    /*
     * OTWARCIE EDYTORA DLA PUSTEGO POLA
     *
     * Tutaj NIE TWORZYMY jeszcze miejsca.
     */

    function openEmptyEditor(x, y)
    {
        noSeatSelected.classList.add(
            'hidden'
        );

        seatEditor.classList.remove(
            'hidden'
        );


        selectedSeat =
            null;


        selectedPosition = {
            x: x,
            y: y
        };


        seatType.value =
            '';


        seatNumber.value =
            getNextNumber(y);


        seatRow.value =
            String.fromCharCode(
                65 + y
            );


        seatX.value =
            x;


        seatY.value =
            y;
    }



    /*
     * KLIKNIĘCIE PUSTEGO POLA
     */

    document
        .querySelectorAll('.grid-cell')
        .forEach(cell => {

            cell.addEventListener(
                'click',
                event => {

                    event.stopPropagation();


                    const x =
                        Number(
                            cell.dataset.x
                        );


                    const y =
                        Number(
                            cell.dataset.y
                        );


                    const occupied =
                        seats.some(
                            seat =>
                                seat.x === x &&
                                seat.y === y
                        );


                    if (occupied) {
                        return;
                    }


                    openEmptyEditor(
                        x,
                        y
                    );

                }
            );

        });



    /*
     * ZASTOSUJ ZMIANY
     */

    document
        .getElementById('saveSeat')
        .addEventListener(
            'click',
            () => {


                /*
                 * ==================================
                 * PUSTE POLE -> NOWE MIEJSCE
                 * ==================================
                 */

                if (
                    !selectedSeat &&
                    selectedPosition
                ) {

                    const type =
                        seatType.value;


                    /*
                     * Nie wybrano typu.
                     */

                    if (!type) {

                        alert(
                            'Wybierz typ miejsca.'
                        );

                        return;
                    }


                    const x =
                        selectedPosition.x;


                    const y =
                        selectedPosition.y;


                    /*
                     * Sprawdzenie czy pole
                     * nadal jest wolne.
                     */

                    const occupied =
                        seats.some(
                            seat =>
                                seat.x === x &&
                                seat.y === y
                        );


                    if (occupied) {

                        alert(
                            'To miejsce jest już zajęte.'
                        );

                        return;
                    }


                    const row =
                        String.fromCharCode(
                            65 + y
                        );


                    const number =
                        Number(
                            seatNumber.value
                        ) ||
                        getNextNumber(y);


                    /*
                     * KANAPA
                     */

                    if (type === 'couch') {

                        const secondX =
                            x + 1;


                        /*
                         * Drugi segment musi
                         * mieścić się w gridzie.
                         */

                        if (secondX >= 16) {

                            alert(
                                'Kanapa nie może wychodzić poza grid.'
                            );

                            return;
                        }


                        /*
                         * Drugie miejsce musi
                         * być wolne.
                         */

                        const secondOccupied =
                            seats.some(
                                seat =>
                                    seat.x === secondX &&
                                    seat.y === y
                            );


                        if (secondOccupied) {

                            alert(
                                'Kanapa wymaga dwóch sąsiednich wolnych pól.'
                            );

                            return;
                        }


                        const groupId =
                            temporaryGroupId--;


                        const firstSeat = {

                            id: temporaryId--,

                            row: row,

                            number: number,

                            x: x,

                            y: y,

                            type: 'couch',

                            group_id: groupId

                        };


                        const secondSeat = {

                            id: temporaryId--,

                            row: row,

                            number: number + 1,

                            x: secondX,

                            y: y,

                            type: 'couch',

                            group_id: groupId

                        };


                        seats.push(
                            firstSeat,
                            secondSeat
                        );


                        selectedSeat =
                            firstSeat;


                        selectedPosition =
                            null;


                        renumberRow(
                            y
                        );


                        renderSeats();


                        selectSeatById(
                            firstSeat.id
                        );


                        saveStatus.textContent =
                            'Niezapisane zmiany';


                        return;
                    }



                    /*
                     * STANDARD / WHEELCHAIR
                     */

                    const newSeat = {

                        id: temporaryId--,

                        row: row,

                        number: number,

                        x: x,

                        y: y,

                        type: type,

                        group_id: null

                    };


                    seats.push(
                        newSeat
                    );


                    selectedSeat =
                        newSeat;


                    selectedPosition =
                        null;


                    renumberRow(
                        y
                    );


                    renderSeats();


                    selectSeatById(
                        newSeat.id
                    );


                    saveStatus.textContent =
                        'Niezapisane zmiany';


                    return;
                }



                /*
                 * Jeżeli nie ma wybranego
                 * miejsca, nic nie robimy.
                 */

                if (!selectedSeat) {
                    return;
                }


                const newType =
                    seatType.value;



                /*
                 * ==================================
                 * ISTNIEJĄCE MIEJSCE -> PUSTE
                 * ==================================
                 */

                if (!newType) {

                    const oldY =
                        selectedSeat.y;


                    /*
                     * Jeżeli to kanapa,
                     * usuwamy całą kanapę.
                     */

                    if (
                        selectedSeat.type === 'couch'
                    ) {

                        const groupId =
                            selectedSeat.group_id;


                        seats =
                            seats.filter(
                                seat =>
                                    seat.group_id !==
                                    groupId
                            );

                    } else {

                        seats =
                            seats.filter(
                                seat =>
                                    seat.id !==
                                    selectedSeat.id
                            );

                    }


                    renumberRow(
                        oldY
                    );


                    selectedSeat =
                        null;


                    selectedPosition =
                        null;


                    renderSeats();


                    seatEditor.classList.add(
                        'hidden'
                    );

                    noSeatSelected.classList.remove(
                        'hidden'
                    );


                    saveStatus.textContent =
                        'Niezapisane zmiany';


                    return;
                }



                /*
                 * ==================================
                 * ZMIANA ZWYKŁEGO MIEJSCA -> KANAPA
                 * ==================================
                 */

                if (
                    newType === 'couch' &&
                    selectedSeat.type !== 'couch'
                ) {

                    const x =
                        selectedSeat.x;


                    const y =
                        selectedSeat.y;


                    const secondX =
                        x + 1;


                    /*
                     * Sprawdzamy drugi segment.
                     */

                    if (secondX >= 16) {

                        alert(
                            'Kanapa nie może wychodzić poza grid.'
                        );

                        return;
                    }


                    const secondSeat =
                        seats.find(
                            seat =>
                                seat.x === secondX &&
                                seat.y === y
                        );


                    if (secondSeat) {

                        alert(
                            'Aby utworzyć kanapę, drugie pole musi być wolne.'
                        );

                        return;
                    }


                    const groupId =
                        temporaryGroupId--;


                    const firstNumber =
                        Number(
                            seatNumber.value
                        ) ||
                        getNextNumber(y);


                    selectedSeat.type =
                        'couch';


                    selectedSeat.group_id =
                        groupId;


                    selectedSeat.number =
                        firstNumber;


                    const secondSeatData = {

                        id: temporaryId--,

                        row: selectedSeat.row,

                        number: firstNumber + 1,

                        x: secondX,

                        y: y,

                        type: 'couch',

                        group_id: groupId

                    };


                    seats.push(
                        secondSeatData
                    );


                    renumberRow(
                        y
                    );


                    renderSeats();


                    selectSeatById(
                        selectedSeat.id
                    );


                    saveStatus.textContent =
                        'Niezapisane zmiany';


                    return;
                }



                /*
                 * ==================================
                 * KANAPA -> INNY TYP
                 * ==================================
                 */

                if (
                    selectedSeat.type === 'couch' &&
                    newType !== 'couch'
                ) {

                    const groupId =
                        selectedSeat.group_id;


                    const y =
                        selectedSeat.y;


                    const x =
                        selectedSeat.x;


                    const number =
                        Number(
                            seatNumber.value
                        );


                    /*
                     * Zapamiętujemy pierwszy
                     * segment kanapy.
                     */

                    const firstSeatId =
                        selectedSeat.id;


                    seats =
                        seats.filter(
                            seat =>
                                seat.group_id !==
                                groupId
                        );


                    const newSeat = {

                        id: firstSeatId,

                        row:
                            String.fromCharCode(
                                65 + y
                            ),

                        number:
                            number || 1,

                        x: x,

                        y: y,

                        type: newType,

                        group_id: null

                    };


                    seats.push(
                        newSeat
                    );


                    renumberRow(
                        y
                    );


                    selectedSeat =
                        newSeat;


                    renderSeats();


                    selectSeatById(
                        newSeat.id
                    );


                    saveStatus.textContent =
                        'Niezapisane zmiany';


                    return;
                }



                /*
                 * ==================================
                 * ZWYKŁA EDYCJA
                 * ==================================
                 */

                selectedSeat.type =
                    newType;


                selectedSeat.number =
                    Number(
                        seatNumber.value
                    );


                renumberRow(
                    selectedSeat.y
                );


                renderSeats();


                selectSeatById(
                    selectedSeat.id
                );


                saveStatus.textContent =
                    'Niezapisane zmiany';

            }
        );



    /*
     * USUWANIE
     */

    document
        .getElementById('deleteSeat')
        .addEventListener(
            'click',
            () => {

                if (!selectedSeat) {
                    return;
                }


                const y =
                    selectedSeat.y;


                /*
                 * KANAPA
                 */

                if (
                    selectedSeat.type === 'couch'
                ) {

                    const groupId =
                        selectedSeat.group_id;


                    seats =
                        seats.filter(
                            seat =>
                                seat.group_id !==
                                groupId
                        );

                } else {

                    seats =
                        seats.filter(
                            seat =>
                                seat.id !==
                                selectedSeat.id
                        );

                }


                /*
                 * Ponumeruj rząd
                 * od lewej strony.
                 */

                renumberRow(
                    y
                );


                selectedSeat =
                    null;


                selectedPosition =
                    null;


                renderSeats();


                seatEditor.classList.add(
                    'hidden'
                );

                noSeatSelected.classList.remove(
                    'hidden'
                );


                saveStatus.textContent =
                    'Niezapisane zmiany';

            }
        );



    /*
     * NUMEROWANIE JEDNEGO RZĘDU
     *
     * Numer zależy od pozycji X.
     *
     * Przykład:
     *
     * X=0 -> 1
     * X=1 -> 2
     * X=3 -> 3
     *
     * Jeżeli usuniemy X=1,
     * następne miejsca zostaną
     * automatycznie przesunięte
     * numeracją.
     */

    function renumberRow(y)
    {
        const rowSeats =
            seats
                .filter(
                    seat =>
                        seat.y === y
                )
                .sort(
                    (a, b) =>
                        a.x - b.x
                );


        let number = 1;

        const processedGroups =
            new Set();


        rowSeats.forEach(seat => {


            /*
             * KANAPA
             */

            if (
                seat.type === 'couch'
            ) {

                if (
                    processedGroups.has(
                        seat.group_id
                    )
                ) {
                    return;
                }


                const couch =
                    rowSeats
                        .filter(
                            item =>
                                item.type === 'couch' &&
                                item.group_id ===
                                    seat.group_id
                        )
                        .sort(
                            (a, b) =>
                                a.x - b.x
                        );


                couch.forEach(item => {

                    item.number =
                        number++;

                });


                processedGroups.add(
                    seat.group_id
                );


                return;
            }



            /*
             * ZWYKŁE MIEJSCE
             */

            seat.number =
                number++;

        });

    }



    /*
     * NUMEROWANIE WSZYSTKICH RZĘDÓW
     */

    function renumberAllRows()
    {
        for (
            let y = 0;
            y < 10;
            y++
        ) {

            renumberRow(
                y
            );

        }
    }



    /*
     * ZNAJDŹ MIEJSCE PO ID
     */

    function selectSeatById(id)
    {
        const seat =
            seats.find(
                item =>
                    item.id === id
            );


        if (!seat) {
            return;
        }


        selectedSeat =
            seat;


        selectedPosition =
            null;


        openEditor(
            seat
        );
    }



    /*
     * ZAPIS SALI
     */

    document
        .getElementById('saveRoom')
        .addEventListener(
            'click',
            async () => {

                const button =
                    document.getElementById(
                        'saveRoom'
                    );


                button.disabled =
                    true;


                button.textContent =
                    'Zapisywanie...';


                try {

                    const response =
                        await fetch(
                            '{{ route('admin.rooms.update', $room) }}',
                            {

                                method: 'PUT',

                                headers: {

                                    'Content-Type':
                                        'application/json',

                                    'Accept':
                                        'application/json',

                                    'X-CSRF-TOKEN':
                                        '{{ csrf_token() }}'

                                },

                                body:
                                    JSON.stringify({
                                        seats: seats
                                    })

                            }
                        );


                    const data =
                        await response.json();


                    if (!response.ok) {

                        throw new Error(
                            data.message ||
                            'Nie udało się zapisać.'
                        );

                    }


                    saveStatus.textContent =
                        'Układ został zapisany.';


                    saveStatus.classList.remove(
                        'text-gray-500'
                    );


                    saveStatus.classList.add(
                        'text-green-600'
                    );


                    button.textContent =
                        'Zapisano';


                    setTimeout(
                        () => {

                            window.location.reload();

                        },
                        700
                    );


                } catch (error) {

                    console.error(
                        error
                    );


                    alert(
                        'Nie udało się zapisać układu sali.'
                    );


                    button.disabled =
                        false;


                    button.textContent =
                        'Zapisz układ sali';

                }

            }
        );



    /*
     * POCZĄTKOWE RENDEROWANIE
     */

    renderSeats();

</script>


</body>

</html>
