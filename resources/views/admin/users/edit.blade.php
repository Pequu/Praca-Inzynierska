<x-app-layout>
    <div class="min-h-screen bg-gray-100 py-10 px-6 rounded-2xl">

        <div class="max-w-3xl mx-auto">

            {{-- Nagłówek --}}
            <div class="mb-8">

                <a
                    href="{{ route('admin.users.index') }}"
                    class="inline-flex items-center text-sm text-gray-500
                        hover:text-gray-900 transition mb-4"
                >
                    ← Powrót do listy użytkowników
                </a>

                <h1 class="text-4xl font-bold text-gray-900">
                    Edycja konta
                </h1>

                <p class="mt-2 text-gray-500">
                    Edytujesz konto użytkownika:
                    <span class="font-semibold text-gray-700">
                        {{ $user->name }}
                    </span>
                </p>

            </div>


            {{-- Formularz --}}
            <div class="bg-white rounded-2xl border border-gray-200
                        shadow-sm p-8">

                <form
                    method="POST"
                    action="{{ route('admin.users.update', $user) }}"
                >

                    @csrf
                    @method('PUT')


                    {{-- Nazwa --}}
                    <div class="mb-6">

                        <label
                            for="name"
                            class="block text-sm font-semibold text-gray-700 mb-2"
                        >
                            Nazwa użytkownika
                        </label>

                        <input
                            id="name"
                            type="text"
                            name="name"
                            value="{{ old('name', $user->name) }}"
                            required
                            class="w-full rounded-xl border-gray-300
                                focus:border-zinc-500
                                focus:ring-zinc-500"
                        >

                        @error('name')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- E-mail --}}
                    <div class="mb-6">

                        <label
                            for="email"
                            class="block text-sm font-semibold text-gray-700 mb-2"
                        >
                            Adres e-mail
                        </label>

                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email', $user->email) }}"
                            required
                            class="w-full rounded-xl border-gray-300
                                focus:border-zinc-500
                                focus:ring-zinc-500"
                        >

                        @error('email')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Rola --}}
                    <div class="mb-4">

                        <label
                            for="role_id"
                            class="block text-sm font-semibold text-gray-700 mb-2"
                        >
                            Rola użytkownika
                        </label>

                        <select
                            id="role_id"
                            name="role_id"
                            required
                            @disabled($user->getKey() === Auth::id())
                            class="w-full rounded-xl border-gray-300
                                focus:border-zinc-500
                                focus:ring-zinc-500
                                disabled:bg-gray-100
                                disabled:text-gray-500">

                            @foreach($roles as $role)

                                <option
                                    value="{{ $role->id }}"
                                    @selected(old('role_id', $user->role_id) == $role->id)
                                >
                                    {{ $role->role_name }}
                                </option>

                            @endforeach

                        </select>

                        @error('role_id')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- Utworzony + Aktualizowany --}}
                    <div class="mb-8">
                        <label
                            for="created_at"
                            class="block text-sm font-semibold text-gray-700"
                        >
                            Edytowany
                        </label>

                        <div id="created_at" class="text-gray-400 text-sm mb-2">
                            {{ $user->updated_at->format('d-m-Y | H:i') }}
                        </div>

                        <label
                            for="updated_at"
                            class="block text-sm font-semibold text-gray-700"
                        >
                            Edytowany
                        </label>

                        <div id="updated_at" class="text-gray-400 text-sm mb-2">
                            {{ $user->updated_at->format('d-m-Y | H:i') }}
                        </div>
                    </div>


                    {{-- Przyciski --}}
                    <div class="flex justify-end gap-3">

                        <a
                            href="{{ route('admin.users.index') }}"
                            class="px-6 py-3 rounded-xl
                                bg-gray-100 text-gray-700
                                hover:bg-gray-200 transition"
                        >
                            Anuluj
                        </a>

                        <button
                            type="submit"
                            class="px-6 py-3 rounded-xl
                                bg-zinc-900 text-white
                                hover:bg-zinc-800 transition"
                        >
                            Zapisz zmiany
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
</x-app-layout>
