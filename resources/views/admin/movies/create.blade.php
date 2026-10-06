<x-app-layout>
    <div class="min-h-screen bg-zinc-900 border-2 border-gray-200 py-10 px-6 rounded-2xl">

        <div class="mb-8">
            <a
                href="{{ route('admin.movies.index') }}"
                class="text-sm text-zinc-300 transition hover:text-red-600"
            >
                ← Powrót do filmów
            </a>

            <h1 class="mt-3 text-3xl font-bold">
                Dodaj film
            </h1>

            <p class="mt-1 text-zinc-300">
                Dodaj informacje o nowym filmie do repertuaru.
            </p>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4">
                <ul class="space-y-1 text-sm text-red-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            action="{{ route('admin.movies.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-6"
        >
            @csrf

            <div class="grid gap-6 lg:grid-cols-2">

                {{-- Informacje podstawowe --}}
                <div class="rounded-2xl bg-white p-6 shadow-sm">

                    <h2 class="mb-6 text-lg font-semibold">
                        Informacje podstawowe
                    </h2>

                    <div class="space-y-5">

                        {{-- Tytuł --}}
                        <div>
                            <label
                                for="title"
                                class="mb-2 block text-sm font-medium"
                            >
                                Tytuł filmu
                            </label>

                            <input
                                type="text"
                                id="title"
                                name="title"
                                value="{{ old('title') }}"
                                placeholder="Np. Interstellar"
                                required
                                class="w-full rounded-xl border border-zinc-300 px-4 py-3 outline-none transition focus:border-red-500 focus:ring-2 focus:ring-red-100"
                            >
                        </div>

                        {{-- Czas + wiek --}}
                        <div class="grid grid-cols-2 gap-4">

                            <div>
                                <label
                                    for="duration"
                                    class="mb-2 block text-sm font-medium"
                                >
                                    Czas trwania
                                </label>

                                <div class="relative">
                                    <input
                                        type="number"
                                        id="duration"
                                        name="duration"
                                        value="{{ old('duration') }}"
                                        min="1"
                                        placeholder="120"
                                        required
                                        class="w-full rounded-xl border border-zinc-300 px-4 py-3 pr-16 outline-none transition focus:border-red-500 focus:ring-2 focus:ring-red-100"
                                    >

                                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm text-zinc-400">
                                        min.
                                    </span>
                                </div>
                            </div>

                            <div>
                                <label
                                    for="age_rating"
                                    class="mb-2 block text-sm font-medium"
                                >
                                    Kategoria wiekowa
                                </label>

                                <select
                                    id="age_rating"
                                    name="age_rating"
                                    required
                                    class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-3 outline-none transition focus:border-red-500 focus:ring-2 focus:ring-red-100"
                                >
                                    <option value="">Wybierz</option>

                                    @foreach (['3+', '7+', '12+', '16+', '18+'] as $rating)
                                        <option
                                            value="{{ $rating }}"
                                            @selected(old('age_rating') === $rating)
                                        >
                                            {{ $rating }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        {{-- Data premiery --}}
                        <div>
                            <label
                                for="release_date"
                                class="mb-2 block text-sm font-medium"
                            >
                                Data premiery
                            </label>

                            <input
                                type="date"
                                id="release_date"
                                name="release_date"
                                value="{{ old('release_date') }}"
                                required
                                class="w-full rounded-xl border border-zinc-300 px-4 py-3 outline-none transition focus:border-red-500 focus:ring-2 focus:ring-red-100"
                            >
                        </div>

                        <x-genre-selector
                            :genres="$genres"
                            :displayAmount="3"
                        />

                    </div>
                </div>

                {{-- Plakat --}}
                <x-poster-upload />

            </div>

            {{-- Opis --}}
            <div class="rounded-2xl bg-white p-6 shadow-sm">

                <div class="mb-4 flex items-center justify-between gap-4">

                    <div>
                        <h2 class="text-lg font-semibold">
                            Opis filmu
                        </h2>

                        <p class="mt-1 text-sm text-zinc-500">
                            Możesz wpisać opis ręcznie lub wygenerować go przy pomocy AI.
                        </p>
                    </div>

                    <button
                        type="button"
                        id="generate-description"
                        class="shrink-0 rounded-xl bg-zinc-900 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-red-600"
                    >
                        ✨ Wygeneruj opis AI
                    </button>

                </div>

                <textarea
                    id="description"
                    name="description"
                    rows="7"
                    placeholder="Wpisz opis filmu..."
                    required
                    class="w-full resize-y rounded-xl border border-zinc-300 px-4 py-3 outline-none transition focus:border-red-500 focus:ring-2 focus:ring-red-100"
                >{{ old('description') }}</textarea>

            </div>

            {{-- Przyciski --}}
            <div class="flex justify-end gap-3">

                <a
                    href="{{ route('admin.movies.index') }}"
                    class="rounded-xl border border-zinc-300 bg-zinc-200 px-6 py-3 font-medium transition hover:bg-white"
                >
                    Anuluj
                </a>

                <x-secondary-button
                    type="submit"
                    class="rounded-xl px-6 py-3"
                >
                    Dodaj film
            </x-secondary-button>

            </div>

        </form>

    </div>

    <script>
        const posterInput = document.getElementById('poster');
        const dropzone = document.getElementById('poster-dropzone');
        const preview = document.getElementById('poster-preview');
        const placeholder = document.getElementById('poster-placeholder');
        const removeButton = document.getElementById('remove-poster');

        function showPoster(file)
        {
            if (!file || !file.type.startsWith('image/')) {
                return;
            }

            const reader = new FileReader();

            reader.onload = function(event)
            {
                preview.src = event.target.result;

                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
                removeButton.classList.remove('hidden');
            };

            reader.readAsDataURL(file);
        }

        posterInput.addEventListener('change', function()
        {
            showPoster(this.files[0]);
        });

        dropzone.addEventListener('dragover', function(event)
        {
            event.preventDefault();

            dropzone.classList.add(
                'border-red-500',
                'bg-red-50'
            );
        });

        dropzone.addEventListener('dragleave', function()
        {
            dropzone.classList.remove(
                'border-red-500',
                'bg-red-50'
            );
        });

        dropzone.addEventListener('drop', function(event)
        {
            event.preventDefault();

            dropzone.classList.remove(
                'border-red-500',
                'bg-red-50'
            );

            const file = event.dataTransfer.files[0];

            if (!file) {
                return;
            }

            const dataTransfer = new DataTransfer();

            dataTransfer.items.add(file);

            posterInput.files = dataTransfer.files;

            showPoster(file);
        });

        removeButton.addEventListener('click', function()
        {
            posterInput.value = '';

            preview.src = '';
            preview.classList.add('hidden');

            placeholder.classList.remove('hidden');
            removeButton.classList.add('hidden');
        });

        document.getElementById('generate-description').addEventListener('click', function()
            {
                const title = document.getElementById('title').value;
                const button = this;

                if (!title.trim()) {
                    alert('Najpierw wpisz tytuł filmu.');
                    return;
                }

                button.disabled = true;
                button.textContent = '⏳ Generowanie...';

                /*
                 * Tutaj później podepniemy endpoint AI.
                 */

                setTimeout(function()
                {
                    button.disabled = false;
                    button.textContent = '✨ Wygeneruj opis AI';
                }, 1000);
            });
    </script>

</x-app-layout>
