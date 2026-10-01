<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Podsumowanie rezerwacji - {{ $screening->movie->title }} - Peqursor
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

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">

                <!-- Informacje -->
                <div class="flex items-center gap-5">

                    @if($screening->movie->poster)

                        <img
                            src="{{ asset('storage/' . $screening->movie->poster) }}"
                            alt="{{ $screening->movie->title }}"
                            class="w-20 h-28 object-cover rounded-lg shadow-sm"
                        >

                    @endif


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

                </div>


                <!-- Sala -->
                <span
                    class="inline-block text-white px-5 py-2 rounded-lg font-semibold self-start md:self-auto"
                    style="background-color: {{ $screening->room->color }}"
                >

                    {{ $screening->room->room_name }}

                </span>

            </div>

        </div>


        <!-- Formularz całego checkoutu -->
        <form
            method="POST"
            action="{{ route('screenings.reserve', $screening->id) }}"
        >

            @csrf


            <!-- Układ główny -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">


                <!-- LEWA CZĘŚĆ -->
                <div class="lg:col-span-2">


                    <!-- Informacje o seansie -->
                    <div class="bg-white rounded-xl shadow-md p-6">

                        <h2 class="text-xl font-bold mb-5">
                            Informacje o seansie
                        </h2>


                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">


                            <!-- Film -->
                            <div>

                                <p class="text-sm text-gray-500">
                                    Film
                                </p>

                                <p class="font-semibold mt-1">
                                    {{ $screening->movie->title }}
                                </p>

                            </div>


                            <!-- Sala -->
                            <div>

                                <p class="text-sm text-gray-500">
                                    Sala
                                </p>

                                <p class="font-semibold mt-1">
                                    {{ $screening->room->room_name }}
                                </p>

                            </div>


                            <!-- Data -->
                            <div>

                                <p class="text-sm text-gray-500">
                                    Data
                                </p>

                                <p class="font-semibold mt-1">
                                    {{ $screening->start_time->format('d.m.Y') }}
                                </p>

                            </div>


                            <!-- Godzina -->
                            <div>

                                <p class="text-sm text-gray-500">
                                    Godzina
                                </p>

                                <p class="font-semibold mt-1">
                                    {{ $screening->start_time->format('H:i') }}
                                </p>

                            </div>


                            @if($screening->movie->duration)

                                <div>

                                    <p class="text-sm text-gray-500">
                                        Czas trwania
                                    </p>

                                    <p class="font-semibold mt-1">
                                        {{ $screening->movie->duration }} min
                                    </p>

                                </div>

                            @endif


                        </div>

                    </div>


                    <!-- Dane rezerwującego -->
                    <div class="bg-white rounded-xl shadow-lg p-8 mt-6">

                        <h2 class="text-2xl font-bold mb-6">
                            Dane rezerwującego
                        </h2>


                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">


                            <!-- Imię -->
                            <div>

                                <label
                                    for="customer_name"
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                >
                                    Imię
                                </label>

                                <input
                                    type="text"
                                    id="customer_name"
                                    name="customer_name"
                                    value="{{ old('customer_name') }}"
                                    required
                                    autocomplete="given-name"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-500"
                                >

                                @error('customer_name')

                                    <p class="text-red-600 text-sm mt-1">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>


                            <!-- Nazwisko -->
                            <div>

                                <label
                                    for="customer_surname"
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                >
                                    Nazwisko
                                </label>

                                <input
                                    type="text"
                                    id="customer_surname"
                                    name="customer_surname"
                                    value="{{ old('customer_surname') }}"
                                    required
                                    autocomplete="family-name"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-500"
                                >

                                @error('customer_surname')

                                    <p class="text-red-600 text-sm mt-1">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>


                            <!-- E-mail -->
                            <div>

                                <label
                                    for="customer_email"
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                >
                                    Adres e-mail
                                </label>

                                <input
                                    type="email"
                                    id="customer_email"
                                    name="customer_email"
                                    value="{{ old('customer_email', auth()->user()->email ?? '') }}"
                                    required
                                    autocomplete="email"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-500"
                                >

                                <p class="text-sm text-gray-500 mt-2">
                                    Na ten adres otrzymasz potwierdzenie rezerwacji.
                                </p>

                                @error('customer_email')

                                    <p class="text-red-600 text-sm mt-1">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>

                            <div>
                                <label
                                    for="customer_phone"
                                    class="block text-sm font-medium text-gray-700 mb-1"
                                >
                                    Numer telefonu
                                </label>

                                <input
                                    type="tel"
                                    id="customer_phone"
                                    name="customer_phone"
                                    value="{{ old('customer_phone') }}"
                                    required
                                    autocomplete="tel"
                                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 outline-none transition focus:border-red-600"
                                >

                                @error('customer_phone')
                                    <p class="mt-1 text-sm text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                        </div>

                        @guest
                            <div class="mb-6 rounded-lg border border-gray-200 bg-gray-50 px-5 py-4">
                                <p class="text-sm text-gray-700">
                                    Nie jesteś zalogowany?
                                    <a
                                        href="{{ route('login') }}?reservation_return=1"
                                        class="font-semibold text-red-600 hover:underline"
                                    >
                                        Zaloguj się
                                    </a>
                                    lub kontynuuj jako gość.
                                </p>
                            </div>
                        @endguest

                    </div>


                    <!-- Metoda płatności -->
                    <div class="bg-white rounded-xl shadow-lg p-8 mt-6">

                        <h2 class="text-2xl font-bold mb-6">
                            Metoda płatności
                        </h2>


                        <div class="space-y-3">


                            <label class="flex items-center gap-4 border border-gray-300 rounded-xl p-4 cursor-pointer hover:border-red-500 transition">
                                <!-- BLIK -->
                                <x-radio-button
                                    name="payment_method"
                                    value="blik"
                                    label="BLIK"
                                    id="payment-blik"
                                    :required="true"
                                />
                                <p class="text-sm text-gray-500 font-sm">
                                    Płatność kodem BLIK
                                </p>
                            </label>

                            <!-- Karta -->
                            <label class="flex items-center gap-4 border border-gray-300 rounded-xl p-4 cursor-pointer hover:border-red-500 transition">
                                <x-radio-button
                                    name="payment_method"
                                    value="card"
                                    label="Karta płatnicza"
                                    id="payment-card"
                                    :required="true"
                                />
                                <p class="text-sm text-gray-500 font-sm">
                                    Płatność kartą płatniczą
                                </p>
                            </label>


                            <!-- Płatność przy kasie -->
                            <label class="flex items-center gap-4 border border-gray-300 rounded-xl p-4 cursor-pointer hover:border-red-500 transition">
                                <x-radio-button
                                    name="payment_method"
                                    value="cash"
                                    label="Płatność przy kasie"
                                    id="payment-cash"
                                    :required="true"
                                />
                                <p class="text-sm text-gray-500 font-sm">
                                    Zapłać przed seansem w kasie kina
                                </p>
                            </label>


                        </div>


                        @error('payment_method')

                            <p class="text-red-600 text-sm mt-3">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>

                    {{-- Terms and Privacy Policy --}}
                    <div class="mt-6 space-y-3 bg-white rounded-xl shadow-lg p-8">

                        <label class="flex items-start gap-3 cursor-pointer">
                            <input
                                type="checkbox"
                                name="terms_accepted"
                                value="1"
                                required
                                {{ old('terms_accepted') ? 'checked' : '' }}
                                class="mt-1 w-4 h-4 rounded border-gray-300 text-yellow-500 focus:text-red-600 focus:ring-red-600"
                            >

                            <span class="text-sm text-gray-700">
                                Akceptuję
                                <a href="{{ route('regulations') }}" target="_blank" class="text-red-600 hover:underline">
                                    regulamin
                                </a>
                                kina.
                            </span>
                        </label>

                        @error('terms_accepted')
                            <p class="text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror


                        <label class="flex items-start gap-3 cursor-pointer">
                            <input
                                type="checkbox"
                                name="privacy_policy_accepted"
                                value="1"
                                required
                                {{ old('privacy_policy_accepted') ? 'checked' : '' }}
                                class="mt-1 w-4 h-4 rounded border-gray-300 text-yellow-500 focus:text-red-600 focus:ring-red-600"
                            >

                            <span class="text-sm text-gray-700">
                                Akceptuję
                                <a href="{{ route('privacy_policy') }}" target="_blank" class="text-red-600 hover:underline">
                                    politykę prywatności.
                                </a>
                            </span>
                        </label>

                        @error('privacy_policy_accepted')
                            <p class="text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror


                        <label class="flex items-start gap-3 cursor-pointer">
                            <input
                                type="checkbox"
                                name="marketing_accepted"
                                value="1"
                                {{ old('marketing_accepted') ? 'checked' : '' }}
                                class="mt-1 w-4 h-4 rounded border-gray-300 text-yellow-500 focus:text-red-600 focus:ring-red-600"
                            >

                            <span class="text-sm text-gray-700">
                                Chcę otrzymywać informacje o promocjach, nowych filmach
                                i ofertach specjalnych Peqursor na podany adres e-mail.
                            </span>
                        </label>

                        @error('marketing_accepted')
                            <p class="text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </div>


                <!-- PRAWA CZĘŚĆ -->
                <div>


                    <!-- Podsumowanie ceny -->
                    <div class="bg-white rounded-xl shadow-lg p-6 sticky top-6">

                        <h2 class="text-xl font-bold mb-6">
                            Podsumowanie
                        </h2>


                        <!-- Cena biletu -->
                        <div class="flex justify-between items-center mb-4">

                            <span class="text-gray-500">
                                Cena biletu
                            </span>

                            <span class="font-semibold">
                                {{ number_format($screening->screening_price, 2, ',', ' ') }} zł
                            </span>

                        </div>


                        <!-- Liczba miejsc -->
                        <div class="flex justify-between items-center mb-4">

                            <span class="text-gray-500">
                                Liczba miejsc
                            </span>

                            <span class="font-semibold">
                                {{ $seats->count() }}
                            </span>

                        </div>


                        <!-- Wybrane miejsca -->
                        <div class="mb-6">

                            <p class="text-gray-500 mb-2">
                                Miejsca
                            </p>

                            <div class="flex flex-wrap gap-2">

                                @foreach($seats as $seat)

                                    <span
                                        class="
                                            px-3
                                            py-1
                                            bg-gray-100
                                            rounded-lg
                                            text-sm
                                            font-semibold
                                        "
                                    >
                                        {{ $seat->row }}{{ $seat->number }}
                                    </span>


                                    <!-- ID miejsca -->
                                    <input
                                        type="hidden"
                                        name="seat_ids[]"
                                        value="{{ $seat->id }}"
                                    >

                                @endforeach

                            </div>

                        </div>


                        <!-- Linia -->
                        <div class="border-t border-gray-200 pt-5">


                            <!-- Łącznie -->
                            <div class="flex justify-between items-center mb-6">

                                <span class="text-lg font-bold">
                                    Łącznie
                                </span>

                                <span class="text-2xl font-bold text-red-600">

                                    {{ number_format(
                                        $screening->screening_price * $seats->count(),
                                        2,
                                        ',',
                                        ' '
                                    ) }}

                                    zł

                                </span>

                            </div>


                            <!-- Przycisk -->
                            <button
                                type="submit"
                                class="
                                    w-full
                                    bg-red-600
                                    hover:bg-red-700
                                    text-white
                                    font-semibold
                                    py-3
                                    rounded-lg
                                    transition
                                    duration-200
                                "
                            >
                                Przejdź do płatności →
                            </button>


                            <!-- Powrót -->
                            <a
                                href="{{ route('screenings.seats', $screening->id) }}"
                                class="
                                    block
                                    text-center
                                    mt-4
                                    text-gray-500
                                    hover:text-gray-900
                                    transition
                                "
                            >
                                ← Wróć do wyboru miejsc
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </form>

    </main>

</body>

</html>
