@extends('layouts.app')

@section('content')

    <form action="{{ route('games.store') }}" method="POST">
        @csrf
        <label for="vs">Titel:</label>
        <input type="text" name="vs" id="vsuser"><br>

        <label for="release_date">Release Datum:</label>
        <input type="date" name="release_date" id="release_date"><br>

        <label for="rating">Beoordeling:</label>
        <input type="number" name="rating" id="rating"><br>

        <button type="submit">Opslaan</button>
    </form>

@endsection
