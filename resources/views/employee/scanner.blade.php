<x-app-layout>
    <div class="min-h-screen bg-zinc-900 px-6 py-10 rounded-2xl">
        <div class="mx-auto max-w-7xl">
            <h1 class="text-3xl font-bold text-white">
                Skaner kodów QR
            </h1>

            <p class="mt-2 text-zinc-400">
                Zeskanuj kod QR biletu, aby zweryfikować jego ważność.
            </p>

            <div class="mt-8 grid grid-cols-1 items-start gap-6 lg:grid-cols-2">

                {{-- Lewa kolumna: kamera i ręczne wpisywanie kodu --}}
                <div class="min-w-0 rounded-2xl border border-zinc-700 bg-zinc-800 p-6">
                    <h2 class="mb-4 text-xl font-semibold text-white">
                        Skanowanie biletu
                    </h2>

                    <div id="qr-reader" class="w-full overflow-hidden rounded-xl"></div>

                    <div class="mt-6 rounded-xl bg-white p-6 text-zinc-900">
                        <h2 class="mb-4 text-lg font-semibold">
                            Wpisz kod ręcznie
                        </h2>

                        <form id="manual-qr-form" class="flex flex-col gap-3 sm:flex-row">
                            <input
                                type="text"
                                id="manual-qr-code"
                                placeholder="Wpisz kod biletu"
                                autocomplete="off"
                                class="min-w-0 flex-1 rounded-lg border border-gray-300 px-4 py-3 outline-none transition focus:border-red-600 focus:ring-1 focus:ring-red-600"
                            >

                            <button
                                type="submit"
                                class="rounded-lg bg-red-600 px-6 py-3 font-semibold text-white transition hover:bg-red-700"
                            >
                                Sprawdź bilet
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Prawa kolumna: wynik weryfikacji --}}
                <div class="min-w-0 rounded-2xl border border-zinc-700 bg-zinc-800 p-6">
                    <h2 class="text-xl font-semibold text-white">
                        Wynik weryfikacji
                    </h2>

                    <p class="mt-2 text-sm text-zinc-400">
                        Informacje o zeskanowanym bilecie pojawią się poniżej.
                    </p>

                    <div
                        id="scan-result"
                        class="mt-6 hidden rounded-xl p-4 text-white"
                    ></div>

                    <div id="scan-placeholder" class="mt-6 rounded-xl border border-dashed border-zinc-600 px-4 py-10 text-center">
                        <p class="font-semibold text-zinc-200">
                            Oczekiwanie na skan
                        </p>

                        <p class="mt-2 text-sm text-zinc-400">
                            Zeskanuj kod kamerą lub wpisz go ręcznie.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@vite('resources/js/scanner.js')
