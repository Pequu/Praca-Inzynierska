import { Html5Qrcode } from 'html5-qrcode';

const qrReader = document.getElementById('qr-reader');
const scanResult = document.getElementById('scan-result');
const manualForm = document.getElementById('manual-qr-form');
const manualQrCode = document.getElementById('manual-qr-code');
const scanPlaceholder = document.getElementById('scan-placeholder');

if (qrReader && scanResult) {
    const scanner = new Html5Qrcode('qr-reader');

    let processing = false;

    function showResult(type, message, details = []) {
        scanResult.className = 'mt-6 rounded-xl border p-4 text-white';

        if (type === 'success') {
            scanResult.style.backgroundColor = '#16a34a';
        } else if (type === 'info') {
            scanResult.classList.add('border-blue-300', 'bg-blue-600');
        } else {
            scanResult.classList.add('border-red-300', 'bg-red-600');
        }

        scanResult.replaceChildren(); //usuwa poprzednią zawartość

        const heading = document.createElement('div');
        heading.className = 'text-lg font-bold';
        heading.textContent = message;

        scanResult.appendChild(heading);

        if (details instanceof HTMLElement) {
            scanResult.appendChild(details);
        } else if (Array.isArray(details)) {
            details.forEach((element) => {
                scanResult.appendChild(element);
            });
        }

        scanResult.classList.remove('hidden');

        if (scanPlaceholder) {
            scanPlaceholder.classList.add('hidden');
        }
    }

    function createDetail(label, value) {
        const row = document.createElement('div');
        row.className = 'text-sm leading-6';

        const strong = document.createElement('strong');
        strong.textContent = `${label}: `;

        row.appendChild(strong);
        row.appendChild(document.createTextNode(value ?? '—'));

        return row;
    }

    function createTicketDetails(ticket) {
        const container = document.createElement('div');
        container.className = 'mt-4 flex flex-col gap-3 text-sm';

        // Border z salą
        const roomPanel = document.createElement('div');
        roomPanel.className = 'my-1 rounded-xl border-2 border-green-300 bg-green-900 px-4 py-3';

        const roomLabel = document.createElement('div');
        roomLabel.className = 'mb-1 text-xs font-bold uppercase tracking-widest text-green-200';
        roomLabel.textContent = 'Sala';

        const roomName = document.createElement('div');
        roomName.className = 'text-2xl font-extrabold leading-tight';
        roomName.textContent = ticket.room ?? '—';

        roomPanel.append(roomLabel, roomName);
        container.appendChild(roomPanel);

        // Reszta informacji
        container.appendChild(createDetail('Film', ticket.movie));
        container.appendChild(createDetail('Miejsce', ticket.seat));
        container.appendChild(createDetail('Godzina', ticket.screening_time));
        container.appendChild(createDetail('Data', ticket.screening_date));

        return container;
    }

    function createInfoDetails(data) {
        const container = document.createElement('div');
        container.className = 'mt-3 flex flex-col gap-1 text-sm';

        if (data.screening) {
            container.appendChild(createDetail('Seans', data.screening));
        }

        if (data.entry_from) {
            container.appendChild(
                createDetail('Wejście możliwe od', data.entry_from)
            );
        }

        if (data.screening_end) {
            container.appendChild(
                createDetail('Koniec seansu', data.screening_end)
            );
        }

        if (data.used_at) {
            container.appendChild(
                createDetail('Wykorzystano', data.used_at)
            );
        }

        return container;
    }

    async function verifyTicket(qrCode) {
        if (processing) {
            return;
        }

        processing = true;

        try {
            const csrfToken = document
                .querySelector('meta[name="csrf-token"]')
                ?.getAttribute('content');

            if (!csrfToken) {
                throw new Error('Nie znaleziono tokenu CSRF.');
            }

            const response = await fetch('/employee/scanner/verify', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    qr_code: qrCode
                })
            });

            const data = await response.json();

            if (!response.ok && !data.message) {
                throw new Error(`Błąd serwera: ${response.status}`);
            }

            if (data.success) {
                showResult(
                    'success',
                    data.message,
                    createTicketDetails(data.ticket ?? {})
                );
            } else {
                showResult(
                    data.status === 'too_early' ? 'info' : 'error',
                    data.message ?? 'Nie udało się zweryfikować biletu.',
                    createInfoDetails(data)
                );
            }
        } catch (error) {
            console.error(error);

            showResult(
                'error',
                'Wystąpił błąd podczas sprawdzania biletu.'
            );
        } finally {
            setTimeout(() => {
                processing = false;
            }, 2000);
        }
    }

    /*
     * Skanowanie kodów QR z kamery
     */
    scanner.start(
        { facingMode: 'environment' },
        {
            fps: 10,
            qrbox: {
                width: 250,
                height: 250
            }
        },
        (decodedText) => {
            verifyTicket(decodedText);
        },
        () => {
            // Ignorujemy błędy podczas szukania kodu QR.
        }
    ).catch((error) => {
        console.error('Nie udało się uruchomić kamery:', error);

        showResult(
            'error',
            'Nie udało się uruchomić kamery.'
        );
    });

    /*
     * Ręczne wpisywanie kodu biletu
     */
    if (manualForm && manualQrCode) {
        manualForm.addEventListener('submit', async (event) => {
            event.preventDefault();

            const qrCode = manualQrCode.value.trim();

            if (!qrCode) {
                showResult('error', 'Wpisz kod biletu.');
                manualQrCode.focus();
                return;
            }

            await verifyTicket(qrCode);

            manualQrCode.value = '';
            manualQrCode.focus();
        });
    }
}
