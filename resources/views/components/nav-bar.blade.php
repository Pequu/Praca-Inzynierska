<nav
    class="z-50 mx-auto -mt-8
           w-[85%] max-w-6xl
           bg-zinc-900 rounded-2xl shadow-2xl
           border border-zinc-700
           navbar">

    <div class="h-16 flex items-center justify-center gap-12 text-white">

        @auth

            @if(Auth::user()->role?->name === 'admin')

                {{-- ================= ADMIN ================= --}}

                <x-nav-link
                    href="{{ route('admin') }}"
                    :active="request()->routeIs('admin')"
                >
                    Panel admina
                </x-nav-link>

                <x-nav-link :href="route('profile.edit')"
                    :active="request()->routeIs('profile.edit')">
                    Konto
                </x-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-nav-link
                        :href="route('logout')"
                        onclick="event.preventDefault();
                                 this.closest('form').submit();"
                    >
                        Wyloguj
                    </x-nav-link>
                </form>

            @else

                {{-- ================= ZWYKŁY UŻYTKOWNIK ================= --}}

                <x-nav-link href="{{ route('index') }}"
                    :active="request()->routeIs('index')">
                    Repertuar
                </x-nav-link>

                <x-nav-link href="{{ route('prices') }}"
                    :active="request()->routeIs('prices')">
                    Cennik
                </x-nav-link>

                <x-nav-link href="#">
                    Kina
                </x-nav-link>

                <x-nav-link href="{{ route('offers') }}"
                    :active="request()->routeIs('offers')">
                    Promocje
                </x-nav-link>

                <x-nav-link :href="route('profile.edit')"
                    :active="request()->routeIs('profile.edit')">
                    Konto
                </x-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-nav-link
                        :href="route('logout')"
                        onclick="event.preventDefault();
                                 this.closest('form').submit();"
                    >
                        Wyloguj
                    </x-nav-link>
                </form>

            @endif

        @else

            {{-- ================= NIEZALOGOWANY ================= --}}

            <x-nav-link
                href="{{ route('index') }}"
                :active="request()->routeIs('index')"
            >
                Repertuar
            </x-nav-link>

            <x-nav-link
                href="{{ route('prices') }}"
                :active="request()->routeIs('prices')"
            >
                Cennik
            </x-nav-link>

            <x-nav-link href="#">
                Kina
            </x-nav-link>

            <x-nav-link
                href="{{ route('offers') }}"
                :active="request()->routeIs('offers')"
            >
                Promocje
            </x-nav-link>

            <x-nav-link
                href="{{ route('login') }}"
                :active="request()->routeIs('login')"
            >
                Logowanie
            </x-nav-link>

            <x-nav-link
                href="{{ route('register') }}"
                :active="request()->routeIs('register')"
            >
                Rejestracja
            </x-nav-link>

        @endauth

    </div>
</nav>
