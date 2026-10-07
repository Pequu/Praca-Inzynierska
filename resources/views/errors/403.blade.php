@extends('errors.layout')

@section('title', 'Brak dostępu')

@section('code', '403')

@section('heading', 'Brak dostępu')

@section(
    'message',
    'Nie masz uprawnień do wyświetlenia tej strony.'
)

@section('actions')

    <a
        href="{{ route('screenings.index') }}"
        class="rounded-xl bg-red-600 px-6 py-3 font-semibold text-white transition hover:bg-red-700"
    >
        Wróć do repertuaru
    </a>

@endsection
