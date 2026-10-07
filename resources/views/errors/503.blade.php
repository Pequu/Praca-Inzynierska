@extends('errors.layout')

@section('title', 'Przerwa techniczna')

@section('code', '503')

@section('heading', 'Chwilowa przerwa techniczna')

@section(
    'message',
    'Peqursor jest obecnie chwilowo niedostępny. Spróbuj ponownie za kilka minut.'
)

@section('actions')

    <button
        type="button"
        onclick="window.location.reload()"
        class="rounded-xl bg-red-600 px-6 py-3 font-semibold text-white transition hover:bg-red-700"
    >
        Odśwież stronę
    </button>

@endsection
