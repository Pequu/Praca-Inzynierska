<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Płatność - {{ $reservation->screening->movie->title }} - Peqursor
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-900">

    <div class="max-w-6xl mx-auto px-6 py-10">

        <h1 class="text-3xl font-bold mb-8">
            Płatność
        </h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm p-8">

                <h2 class="text-xl font-semibold mb-6">
                    Metoda płatności
                </h2>

                @if ($reservation->payment_method === 'blik')

                    <div>
                        <h3 class="text-lg font-semibold">
                            Płatność BLIK
                        </h3>

                        <p class="text-gray-600 mt-2">
                            Wprowadź kod BLIK, aby kontynuować.
                        </p>

                        <div class="mt-6">
                            <label
                                for="blik_code"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Kod BLIK
                            </label>

                            <input
                                type="text"
                                id="blik_code"
                                name="blik_code"
                                maxlength="6"
                                inputmode="numeric"
                                placeholder="000000"
                                class="w-full max-w-xs rounded-lg border border-gray-300 px-4 py-2.5 outline-none transition focus:border-red-600"
                            >
                        </div>
                    </div>

                @elseif ($reservation->payment_method === 'card')

                    <div>
                        <h3 class="text-lg font-semibold">
                            Płatność kartą
                        </h3>

                        <p class="text-gray-600 mt-2">
                            Wprowadź dane swojej karty.
                        </p>
                    </div>

                @elseif ($reservation->payment_method === 'cash')

                    <div>
                        <h3 class="text-lg font-semibold">
                            Płatność gotówką
                        </h3>

                        <p class="text-gray-600 mt-2">
                            Płatność zostanie wykonana w kasie kina.
                        </p>
                    </div>

                @endif

            </div>


            <div class="bg-white rounded-2xl shadow-sm p-8 h-fit">

                <h2 class="text-xl font-semibold mb-6">
                    Podsumowanie
                </h2>

                <div class="space-y-3 text-sm">

                    <div class="flex justify-between">
                        <span class="text-gray-600">
                            Film
                        </span>

                        <span class="font-medium text-right">
                            {{ $reservation->screening->movie->title }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-600">
                            Sala
                        </span>

                        <span class="font-medium">
                            {{ $reservation->screening->room->room_name }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-600">
                            Liczba miejsc
                        </span>

                        <span class="font-medium">
                            {{ $reservation->reservationSeats->count() }}
                        </span>
                    </div>

                </div>

                <div class="border-t border-gray-200 mt-6 pt-6">

                    <div class="flex justify-between items-center">

                        <span class="text-lg font-semibold">
                            Do zapłaty
                        </span>

                        <span class="text-2xl font-bold text-red-600">
                            {{ number_format($reservation->total_price, 2, ',', ' ') }} zł
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>
