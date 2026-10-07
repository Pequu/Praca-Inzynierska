@extends('errors.layout')

@section('title', 'Nie znaleziono strony')

@section('code', '404')

@section('heading', 'Ups! Nie znaleziono tej strony.')

@section(
    'message',
    'Wygląda na to, że strona, której szukasz, nie istnieje albo została przeniesiona.'
)

@section('actions')

    <a
        href="{{ route('screenings.index') }}"
        class="rounded-xl bg-red-600 px-6 py-3 font-semibold text-white transition hover:bg-red-700"
    >
        Wróć do repertuaru
    </a>

@endsection
