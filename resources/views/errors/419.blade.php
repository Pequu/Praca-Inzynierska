@extends('errors.layout')

@section('title', 'Sesja wygasła')

@section('code', '419')

@section('heading', 'Sesja wygasła')

@section(
    'message',
    'Ta strona była otwarta zbyt długo albo Twoja sesja wygasła. Odśwież stronę i spróbuj ponownie.'
)

@section('actions')

    <button
        type="button"
        onclick="window.location.reload()"
        class="rounded-xl bg-red-600 px-6 py-3 font-semibold text-white transition hover:bg-red-700"
    >
        Odśwież stronę
    </button>

    <a
        href="{{ route('screenings.index') }}"
        class="rounded-xl border border-gray-300 bg-white px-6 py-3 font-semibold text-gray-900 transition hover:bg-gray-50"
    >
        Wróć do repertuaru
    </a>

@endsection
