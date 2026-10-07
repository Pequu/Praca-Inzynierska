@extends('errors.layout')

@section('title', 'Wystąpił błąd')

@section('code', '500')

@section('heading', 'Coś poszło nie tak')

@section(
    'message',
    'Wystąpił nieoczekiwany błąd. Spróbuj ponownie za chwilę.'
)

@section('actions')

    <button
        type="button"
        onclick="window.location.reload()"
        class="rounded-xl bg-red-600 px-6 py-3 font-semibold text-white transition hover:bg-red-700"
    >
        Spróbuj ponownie
    </button>

    <a
        href="{{ route('screenings.index') }}"
        class="rounded-xl border border-gray-300 bg-white px-6 py-3 font-semibold text-gray-900 transition hover:bg-gray-50"
    >
        Wróć do repertuaru
    </a>

@endsection
