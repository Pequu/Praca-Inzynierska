<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">

    <style>
        @page {
            size: A4 portrait;
            margin: 10mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: DejaVu Sans, sans-serif;
            color: #18181b;
            background: #e7e5e4;
        }

        .ticket {
            position: relative;
            width: 100%;
            height: 275mm;
            overflow: hidden;
            background-color: #e7e5e4;
            border: 1px solid #d4d4d8;
            /* unika rozjazdu biletów na kilka stron */
            page-break-inside: avoid; 
            page-break-after: always; 
        }

        .ticket:last-child {
            page-break-after: auto;
        }

        .header {
            position: relative;
            z-index: 2;
            height: 175px;
            text-align: center;
            padding-top: 12px;

            background-color: #09090b;
            background-image: url("{{ public_path('images/peqursor-header-gradient.png') }}");
            background-repeat: no-repeat;
            background-position: center;
            background-size: 100% 100%;

            border-bottom: 5px solid #dc2626;
            overflow: hidden;
        }

        .logo {
            display: block;
            width: auto;
            height: 200px;
            margin: 0 auto;
        }

        .pattern {
            position: absolute;
            top: 175px;
            left: 0;
            right: 0;
            bottom: 65px;
            z-index: 0;
            background-color: #e7e5e4;
            background-image: url("{{ public_path('images/peqursor_background.png') }}");
        }

        .content {
            position: relative;
            z-index: 1;
            padding: 25px 30px 75px;
        }

        .ticket-label {
            display: inline-block;
            padding: 7px 13px;
            background: #dc2626;
            color: #ffffff;
            font-size: 10px;
            font-weight: bold;
            border-radius: 6px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .movie-title {
            margin-top: 16px;
            margin-bottom: 23px;
            font-size: 25px;
            line-height: 1.3;
            font-weight: bold;
            color: #18181b;
        }

        .details {
            width: 100%;
            border-collapse: separate;
            border-spacing: 7px;
            margin: 0 -7px 18px;
        }

        .details td {
            width: 50%;
            padding: 14px;
            background: #f4f4f5;
            border: 1px solid #d4d4d8;
            border-radius: 12px;
            vertical-align: top;
        }

        .detail-label {
            margin-bottom: 8px;
            color: #71717a;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .detail-value {
            color: #18181b;
            font-size: 16px;
            font-weight: bold;
        }

        .seat-box {
            margin-top: 12px;
            margin-bottom: 22px;
            padding: 18px 20px;
            background: #18181b;
            border-left: 5px solid #dc2626;
            border-radius: 0 12px 12px 0;
            color: #ffffff;
        }

        .seat-label {
            color: #a1a1aa;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .seat-value {
            margin-top: 8px;
            font-size: 20px;
            font-weight: bold;
        }

        .price {
            color: #dc2626;
            font-size: 19px;
            font-weight: bold;
        }

        .qr-area {
            text-align: center;
            margin-top: 20px;
        }

        .qr-card {
            display: inline-block;
            padding: 18px 22px;
            background: #ffffff;
            border: 1px solid #d4d4d8;
            border-radius: 12px;
        }

        .qr-card img {
            display: block;
            width: 180px;
            height: 180px;
        }

        .qr-caption {
            margin-top: 12px;
            color: #18181b;
            font-size: 10px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .ticket-code {
            margin-top: 12px;
            color: #52525b;
            font-size: 9px;
            overflow-wrap: anywhere;
        }

        .footer {
            position: absolute;
            z-index: 2;
            left: 0;
            right: 0;
            bottom: 0;
            height: 65px;
            padding: 13px 20px;
            text-align: center;
            background: #18181b;
            border-top: 4px solid #dc2626;
        }

        .footer-title {
            color: #ffffff;
            font-size: 12px;
            font-weight: bold;
            letter-spacing: 2px;
        }

        .footer-subtitle {
            margin-top: 6px;
            color: #a1a1aa;
            font-size: 9px;
        }

        .footer-subtitle span {
            color: #f87171;
        }
    </style>
</head>

<body>

@foreach ($tickets as $ticket)

    <div class="ticket">

        <div class="header">
            <img
                class="logo"
                src="{{ public_path('images/logoPeqursorTransparent.png') }}"
                alt="Peqursor"
            >
        </div>

        <div class="pattern"></div>

        <div class="content">

            <span class="ticket-label">Bilet kinowy</span>

            <div class="movie-title">
                {{ $ticket->screening->movie->title }}
            </div>

            <table class="details">
                <tr>
                    <td>
                        <div class="detail-label">Data seansu</div>
                        <div class="detail-value">
                            {{ $ticket->screening->start_time->format('d.m.Y') }}
                        </div>
                    </td>

                    <td>
                        <div class="detail-label">Godzina</div>
                        <div class="detail-value">
                            {{ $ticket->screening->start_time->format('H:i') }}
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Sala</div>
                        <div class="detail-value">
                            {{ $ticket->screening->room->room_name }}
                        </div>
                    </td>

                    <td>
                        <div class="detail-label">Cena biletu</div>
                        <div class="price">
                            {{ number_format($ticket->ticket_price, 2, ',', ' ') }} zł
                        </div>
                    </td>
                </tr>
            </table>

            <div class="seat-box">
                <div class="seat-label">Twoje miejsce</div>

                <div class="seat-value">
                    Rząd {{ $ticket->seat->row }}
                    &nbsp; | &nbsp;
                    Miejsce {{ $ticket->seat->number }}
                </div>
            </div>

            <div class="qr-area">

                <div class="qr-card">

                    @php
                        $qrCode = QrCode::format('svg')
                            ->size(180)
                            ->margin(1)
                            ->generate($ticket->qr_code);

                        $qrCodeBase64 = base64_encode($qrCode);
                    @endphp

                    <img
                        src="data:image/svg+xml;base64,{{ $qrCodeBase64 }}"
                        alt="Kod QR biletu"
                    >

                    <div class="qr-caption">
                        ZESKANUJ PRZY WEJŚCIU
                    </div>

                </div>

                <div class="ticket-code">
                    ID biletu: {{ $ticket->qr_code }}
                </div>

            </div>

        </div>

        <div class="footer">
            <div class="footer-title">PEQURSOR</div>

            <div class="footer-subtitle">
                Dziękujemy za wybór naszego kina.
                <span>Miłego seansu!</span>
            </div>
        </div>

    </div>

@endforeach

</body>
</html>