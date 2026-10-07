<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">

    <title>
        Potwierdzenie zakupu - Peqursor
    </title>
</head>

<body
    style="
        margin: 0;
        padding: 30px;
        background: #f4f4f5;
        font-family: Arial, sans-serif;
        color: #18181b;
    "
>

    <div
        style="
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
        "
    >

        {{-- Logo / nagłówek --}}
        <h1
            style="
                margin: 0 0 10px;
                font-size: 28px;
                color: #18181b;
            "
        >
            PEQURSOR
        </h1>

        <div
            style="
                height: 3px;
                background: #dc2626;
                margin-bottom: 25px;
            "
        ></div>


        {{-- Tytuł --}}
        <h2
            style="
                margin: 0 0 20px;
                font-size: 22px;
                color: #18181b;
            "
        >
            Zakup biletów został potwierdzony
        </h2>


        {{-- Powitanie --}}
        <p>
            Cześć {{ $reservation->customer_name }},
        </p>

        <p>
            Twoja płatność została potwierdzona, a rezerwacja
            <strong>#{{ $reservation->id }}</strong>
            została zrealizowana.
        </p>


        {{-- Informacje o filmie --}}
        <h3
            style="
                margin-top: 30px;
                margin-bottom: 15px;
                font-size: 20px;
                color: #18181b;
            "
        >
            {{ $reservation->screening->movie->title }}
        </h3>


        <p style="margin: 8px 0;">
            <strong>Data:</strong>
            {{ $reservation->screening->start_time->format('d.m.Y') }}
        </p>

        <p style="margin: 8px 0;">
            <strong>Godzina:</strong>
            {{ $reservation->screening->start_time->format('H:i') }}
        </p>

        <p style="margin: 8px 0;">
            <strong>Sala:</strong>
            {{ $reservation->screening->room->room_name }}
        </p>

        <p style="margin: 8px 0;">
            <strong>Liczba biletów:</strong>
            {{ $reservation->tickets->count() }}
        </p>

        <p style="margin: 8px 0;">
            <strong>Łącznie:</strong>
            {{ number_format($reservation->total_price, 2, ',', ' ') }} zł
        </p>


        {{-- Przycisk do strony potwierdzenia --}}
        <div
            style="
                margin: 35px 0;
                text-align: center;
            "
        >

            <a
                href="{{ route('reservations.confirmation', [
                    'reservation' => $reservation,
                    'access_token' => $reservation->access_token,
                ]) }}"
                style="
                    display: inline-block;
                    padding: 13px 25px;
                    background: #dc2626;
                    color: #ffffff;
                    text-decoration: none;
                    border-radius: 7px;
                    font-size: 15px;
                    font-weight: bold;
                "
            >
                Zobacz szczegóły zakupu
            </a>

        </div>


        {{-- Informacja o PDF --}}
        <div
            style="
                padding: 18px;
                background: #f4f4f5;
                border-radius: 8px;
                margin-top: 25px;
            "
        >

            <p style="margin: 0 0 10px;">
                <strong>Twoje bilety</strong>
            </p>

            <p style="margin: 0; color: #52525b;">
                W załączniku znajdziesz swoje bilety w formacie PDF.
                Każdy bilet zawiera indywidualny kod QR.
            </p>

        </div>


        {{-- Informacja przy wejściu --}}
        <p style="margin-top: 25px;">
            Zachowaj ten e-mail i przedstaw kod QR przy wejściu do kina.
        </p>


        {{-- Zakończenie --}}
        <p style="margin-top: 30px;">
            Do zobaczenia w Peqursor!
        </p>


        {{-- Stopka --}}
        <div
            style="
                margin-top: 35px;
                padding-top: 20px;
                border-top: 1px solid #e4e4e7;
                color: #71717a;
                font-size: 12px;
                text-align: center;
            "
        >
            <p style="margin: 0;">
                Peqursor Cinema
            </p>
        </div>

    </div>
</body>
