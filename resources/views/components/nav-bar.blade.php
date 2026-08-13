<nav
    class="z-50 mx-auto -mt-8
            w-[85%] max-w-6xl
            bg-zinc-900 rounded-2xl shadow-2xl
            border border-zinc-700
            navbar">

    <div class="h-16 flex items-center justify-center gap-12 text-white ">

        <x-nav-link href="{{ route('index') }}">{{ 'Repertuar' }}</x-nav-link>

        <x-nav-link href="{{ route('prices') }}">{{ 'Cennik' }}</x-nav-link>

        <x-nav-link href="#">{{ 'Kina' }}</x-nav-link>

        <x-nav-link href="{{ route('offers') }}">{{ 'Promocje' }}</x-nav-link>

        @auth
            <x-nav-link :href="route('profile.edit')">
                {{ __('Konto') }}
            </x-nav-link>

            <!-- Authentication -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <x-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                    this.closest('form').submit();">
                    {{ __('Wyloguj') }}
                </x-nav-link>
            </form>

        @else
            <x-nav-link href="{{ route('login') }}" :active="request()->routeIs('login')">
                {{ __('Logowanie') }}
            </x-nav-link>

            <x-nav-link href="{{ route('register') }}" :active="request()->routeIs('register')">
                {{ __('Rejestracja') }}
            </x-nav-link>
        @endauth

        @auth
            @if(Auth::user()->role?->name === 'admin')
                <x-nav-link
                    href="{{ route('admin') }}"
                    :active="request()->routeIs('admin')"
                >
                    Panel admina
                </x-nav-link>
            @endif
        @endauth
    </div>
</nav>
