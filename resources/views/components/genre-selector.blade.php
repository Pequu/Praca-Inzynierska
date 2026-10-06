@props([
    'genres',
    'selectedGenres' => [],
    'displayAmount',
])

@php
    $selectedGenres = collect($selectedGenres)
        ->map(function ($genre) {
            return $genre instanceof \App\Models\Genre
                ? $genre->id
                : $genre;
        })
        ->map(fn ($id) => (int) $id)
        ->toArray();
@endphp

<div
    x-data="{
        open: false,
        search: '',
        selected: @js($selectedGenres),

        toggle(id) {
            id = Number(id);

            if (this.selected.includes(id)) {
                this.selected = this.selected.filter(item => item !== id);
            } else {
                this.selected.push(id);
            }
        },

        isSelected(id) {
            return this.selected.includes(Number(id));
        },

        matches(name) {
            return name
                .toLowerCase()
                .includes(this.search.toLowerCase());
        },

        remove(id) {
            this.selected = this.selected.filter(
                item => item !== Number(id)
            );
        }
    }"
    @keydown.escape.window="open = false"
>
    <label class="mb-2 block text-sm font-medium text-gray-900">
        Gatunki
    </label>

    {{-- Wybrane gatunki --}}
    <div class="mb-2 flex min-h-10 flex-wrap items-center gap-2">
        @foreach ($genres as $genre)
            <template
                x-if="isSelected({{ $genre->id }}) && selected.indexOf({{ $genre->id }}) < {{ $displayAmount }}"
            >
                <span
                    class="inline-flex items-center gap-1.5 rounded-full border px-3 py-1.5 text-sm font-medium"
                    style="
                        border-color: {{ $genre->color }};
                        color: {{ $genre->color }};
                        background-color: {{ $genre->color }}18;
                    "
                >
                    {{ $genre->genre_name }}

                    <button
                        type="button"
                        @click="remove({{ $genre->id }})"
                        class="flex h-4 w-4 items-center justify-center rounded-full transition hover:bg-black/10"
                    >
                        ×
                    </button>
                </span>
            </template>
        @endforeach

        {{-- Liczba ukrytych gatunków --}}
        <template x-if="selected.length > {{ $displayAmount }}">
            <button
                type="button"
                @click="open = true"
                class="inline-flex items-center gap-2 rounded-full border-2 border-dashed border-gray-300 px-4 py-1.5 text-sm font-medium text-gray-500 transition hover:border-red-500 hover:text-red-500">
                + <span x-text="selected.length - {{ $displayAmount }}"></span> więcej
            </button>
        </template>

        {{-- Dodawanie gatunku --}}
        <template x-if="selected.length <= {{ $displayAmount }}">
            <button
                type="button"
                @click="open = true"
                class="inline-flex items-center gap-2 rounded-full border-2 border-dashed border-gray-300 px-4 py-1.5 text-sm font-medium text-gray-500 transition hover:border-red-500 hover:text-red-500">
                <span class="text-lg leading-none">
                    +
                </span>

                Dodaj gatunek
            </button>
        </template>
    </div>

    {{-- Ukryte inputy --}}
    <template x-for="id in selected" :key="id">
        <input
            type="hidden"
            name="genres[]"
            :value="id"
        >
    </template>

    @error('genres')
        <p class="mt-2 text-sm text-red-600">
            {{ $message }}
        </p>
    @enderror

    @error('genres.*')
        <p class="mt-2 text-sm text-red-600">
            Jeden z wybranych gatunków jest nieprawidłowy.
        </p>
    @enderror

    {{-- Overlay --}}
    <div
        x-show="open"
        x-cloak
        x-transition.opacity
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
        @click.self="open = false"
    >
        {{-- Modal --}}
        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="scale-95 opacity-0"
            x-transition:enter-end="scale-100 opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="scale-100 opacity-100"
            x-transition:leave-end="scale-95 opacity-0"
            class="w-full max-w-2xl overflow-hidden rounded-2xl bg-white shadow-2xl"
        >
            {{-- Nagłówek --}}
            <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">
                        Wybierz gatunki
                    </h2>

                    <p class="mt-0.5 text-sm text-gray-500">
                        Możesz wybrać dowolną liczbę gatunków.
                    </p>
                </div>

                <button
                    type="button"
                    @click="open = false"
                    class="flex h-9 w-9 items-center justify-center rounded-full text-xl text-gray-400 transition hover:bg-gray-100 hover:text-gray-700"
                >
                    ×
                </button>
            </div>

            {{-- Wyszukiwarka --}}
            <div class="border-b border-gray-200 px-6 py-4">
                <div class="relative">
                    <svg
                        class="pointer-events-none absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="m21 21-4.35-4.35m2.35-5.65a8 8 0 1 1-16 0 8 8 0 0 1 16 0Z"
                        />
                    </svg>

                    <input
                        type="text"
                        x-model="search"
                        placeholder="Szukaj gatunku..."
                        class="w-full rounded-xl border border-gray-300 py-2.5 pl-10 pr-4 text-sm outline-none transition focus:border-red-500 focus:ring-2 focus:ring-red-500/20"
                    >
                </div>
            </div>

            {{-- Lista gatunków --}}
            <div class="max-h-80 overflow-y-auto px-6 py-4">
                <div class="grid grid-cols-1 gap-2 sm:grid-cols-2">
                    @foreach ($genres as $genre)
                        <label
                            x-show="matches(@js($genre->genre_name))"
                            class="cursor-pointer"
                        >
                            <input
                                type="checkbox"
                                class="sr-only"
                                :checked="isSelected({{ $genre->id }})"
                                @change="toggle({{ $genre->id }})"
                            >

                            <div
                                class="flex items-center justify-between rounded-xl border-2 p-3 transition-all duration-150"
                                :class="isSelected({{ $genre->id }})
                                    ? 'shadow-sm'
                                    : 'border-gray-200 hover:border-gray-300'"
                                :style="isSelected({{ $genre->id }})
                                    ? `border-color: {{ $genre->color }}; background-color: {{ $genre->color }}12;`
                                    : ''"
                            >
                                <div class="flex items-center gap-3">
                                    <span
                                        class="h-3 w-3 rounded-full"
                                        style="background-color: {{ $genre->color }}"
                                    ></span>

                                    <span class="text-sm font-medium text-gray-800">
                                        {{ $genre->genre_name }}
                                    </span>
                                </div>

                                <span
                                    class="flex h-5 w-5 items-center justify-center rounded-md border-2 transition-all"
                                    :style="isSelected({{ $genre->id }})
                                        ? `background-color: {{ $genre->color }}; border-color: {{ $genre->color }};`
                                        : 'border-color: #d1d5db;'"
                                >
                                    <svg
                                        x-show="isSelected({{ $genre->id }})"
                                        class="h-3 w-3 text-white"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="3"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="m5 12 4 4L19 6"
                                        />
                                    </svg>
                                </span>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Stopka --}}
            <div class="flex items-center justify-between border-t border-gray-200 bg-gray-50 px-6 py-4">
                <span class="text-sm text-gray-500">
                    Wybrano:
                    <strong
                        class="text-gray-800"
                        x-text="selected.length"
                    ></strong>
                </span>

                <button
                    type="button"
                    @click="open = false"
                    class="rounded-xl bg-gray-900 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-gray-800"
                >
                    Gotowe
                </button>
            </div>
        </div>
    </div>
</div>
