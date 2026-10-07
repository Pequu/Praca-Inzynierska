@extends('errors.layout')

@section('title', 'Wymagane logowanie')

@section('code', '401')

@section('heading', 'Wymagane logowanie')

@section(
    'message',
    'Aby uzyskać dostęp do tej strony, musisz być zalogowany.'
)

@section('actions')

    <a
        href="{{ route('login') }}"
        class="rounded-xl bg-red-600 px-6 py-3 font-semibold text-white transition hover:bg-red-700"
    >
        Zaloguj się
    </a>

    <a
        href="{{ route('screenings.index') }}"
        class="rounded-xl border border-gray-300 bg-white px-6 py-3 font-semibold text-gray-900 transition hover:bg-gray-50"
    >
        Wróć do repertuaru
    </a>

@endsection
