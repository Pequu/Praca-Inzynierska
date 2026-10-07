<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            padding: 30px;
            background: #ffffff;
            color: #18181b;
        }

        .ticket {
            border: 2px solid #18181b;
            padding: 25px;
            margin-bottom: 30px;
        }

        .header {
            border-bottom: 2px solid #dc2626;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
            margin-top: 15px;
        }

        .info {
            margin-top: 20px;
        }

        .row {
            margin-bottom: 10px;
        }

        .label {
            font-weight: bold;
        }

        .qr {
            text-align: center;
            margin-top: 25px;
        }

        .qr img {
            width: 180px;
            height: 180px;
        }

        .code {
            text-align: center;
            font-size: 11px;
            color: #52525b;
            margin-top: 10px;
        }
    </style>
</head>

<body>

@foreach ($tickets as $ticket)

    <div class="ticket">

        <div class="header">
            <div class="logo">
                PEQURSOR
            </div>

            <div>
                Bilet kinowy
            </div>
        </div>

        <div class="title">
            {{ $ticket->screening->movie->title }}
        </div>

        <div class="info">

            <div class="row">
                <span class="label">Data:</span>
                {{ $ticket->screening->start_time->format('d.m.Y') }}
            </div>

            <div class="row">
                <span class="label">Godzina:</span>
                {{ $ticket->screening->start_time->format('H:i') }}
            </div>

            <div class="row">
                <span class="label">Sala:</span>
                {{ $ticket->screening->room->room_name }}
            </div>

            <div class="row">
                <span class="label">Miejsce:</span>
                rząd {{ $ticket->seat->row }},
                miejsce {{ $ticket->seat->number }}
            </div>

            <div class="row">
                <span class="label">Cena:</span>
                {{ number_format($ticket->ticket_price, 2, ',', ' ') }} zł
            </div>

        </div>

            <div class="qr">
                @php
                    $qrCode = QrCode::format('svg')
                        ->size(180)
                        ->margin(1)
                        ->generate($ticket->qr_code);

                    $qrCodeBase64 = base64_encode($qrCode);
                @endphp

                <img
                    src="data:image/svg+xml;base64,{{ $qrCodeBase64 }}"
                    width="180"
                    height="180"
                >
            </div>

        <div class="code">
            {{ $ticket->qr_code }}
        </div>

    </div>

@endforeach

</body>
</html>
