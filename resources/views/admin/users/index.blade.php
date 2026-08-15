<x-app-layout>

    <div class="min-h-screen bg-zinc-900 rounded-2xl py-10 px-6">

        <div class="max-w-7xl mx-auto">

            {{-- Nagłówek --}}
            <div class="flex items-center justify-between mb-8">

                <div>
                    <h1 class="text-4xl font-bold text-gray-200">
                        Zarządzanie kontami
                    </h1>

                    <p class="mt-2 text-gray-300">
                        Zarządzaj użytkownikami systemu
                    </p>
                </div>

                <x-a-secondary href="{{ route('admin') }}">
                    {{ 'Powrót' }}
                </x-a-secondary>

            </div>


            {{-- Komunikaty --}}
            @if(session('success'))
                <div class="mb-6 p-4 rounded-xl bg-green-100 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 rounded-xl bg-red-100 text-red-800">
                    {{ session('error') }}
                </div>
            @endif


            {{-- Wyszukiwarka --}}
            <div class="bg-white rounded-2xl border border-gray-200 p-5 mb-6">

                <form method="GET"
                    action="{{ route('admin.users.index') }}"
                    class="flex gap-3">

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Szukaj po nazwie lub adresie e-mail..."
                        class="flex-1 rounded-xl border-gray-300
                            focus:border-zinc-500 focus:ring-zinc-500"
                    >

                    <x-primary-button>
                        Szukaj
                    </x-primary-button>

                </form>

            </div>


            {{-- Lista --}}
            <div class="bg-white rounded-2xl border border-gray-200
                        shadow-sm overflow-hidden">

                <table class="w-full">

                    <thead class="bg-zinc-900 text-white">

                        <tr>
                            <th class="text-left px-6 py-4">
                                Użytkownik
                            </th>

                            <th class="text-left px-6 py-4">
                                E-mail
                            </th>

                            <th class="text-left px-6 py-4">
                                Rola
                            </th>

                            <th class="text-left px-6 py-4">
                                Ostatnio edytowany
                            </th>

                            <th class="text-right px-6 py-4">
                                Akcje
                            </th>
                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-200">

                        @forelse($users as $user)

                            <tr class="hover:bg-gray-50 transition">

                                <td class="px-6 py-4 font-semibold text-gray-900">
                                    {{ $user->name }}
                                </td>

                                <td class="px-6 py-4 text-gray-600">
                                    {{ $user->email }}
                                </td>

                                <td class="px-6 py-4">

                                    @if($user->role?->role_name === 'admin')

                                        <span class="px-3 py-1 rounded-full
                                                    text-xs font-semibold
                                                    bg-red-100 text-red-700">
                                            {{ 'Administrator' }}
                                        </span>

                                    @elseif($user->role?->role_name === 'worker')

                                        <span class="px-3 py-1 rounded-full
                                                    text-xs font-semibold
                                                    bg-green-100 text-green-700">
                                            {{ 'Pracownik' }}
                                        </span>

                                    @elseif($user->role?->role_name === 'customer')

                                        <span class="px-3 py-1 rounded-full
                                                    text-xs font-semibold
                                                    bg-blue-100 text-blue-4 00">
                                            {{ 'Klient' }}
                                        </span>


                                    @else

                                        <span class="px-3 py-1 rounded-full
                                                    text-xs font-semibold
                                                    bg-gray-100 text-gray-700">
                                            {{ $user->role?->name ?? 'Brak roli' }}
                                        </span>

                                    @endif

                                </td>

                                {{-- edytowany --}}
                                <td class="px-6 py-4 text-gray-600">
                                    {{ $user->updated_at->format('d.m.Y H:i') }}
                                </td>

                                <td class="px-6 py-4">

                                    <div class="flex justify-end gap-2">

                                        <a
                                            href="{{ route('admin.users.edit', $user) }}"
                                            class="px-4 py-2 rounded-lg
                                                bg-blue-100 text-blue-700
                                                hover:bg-blue-200 transition">
                                            Edytuj
                                        </a>


                                        @if($user->id !== auth()->id())

                                            <form
                                                method="POST"
                                                action="{{ route('admin.users.destroy', $user) }}"
                                                onsubmit="return confirm('Czy na pewno chcesz usunąć to konto?');"
                                            >

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="px-4 py-2 rounded-lg
                                                        bg-red-100 text-red-700
                                                        hover:bg-red-200 transition">
                                                    Usuń
                                                </button>

                                            </form>

                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5"
                                    class="px-6 py-10 text-center text-gray-500">
                                    Nie znaleziono użytkowników.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- Paginacja --}}
            <div class="mt-6">
                {{ $users->links() }}
            </div>

        </div>

    </div>

</x-app-layout>
