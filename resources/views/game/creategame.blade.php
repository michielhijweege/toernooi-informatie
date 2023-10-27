@extends('layouts.app')

@section('content')

    <form action="{{ route('gamestore') }}" method="POST">
        @csrf
        <label for="opponent">Opponent:</label>
        <input type="text" name="opponent" id="opponent" value="{{ old('opponent') }}"><br>
        @error('opponent')
        <p class="text-danger">{{ $message }}</p>
        @enderror

        <label for="game_date">Game Datum:</label>
        <input type="date" name="game_date" id="game_date" value="{{ old('game_date') }}"><br>
        @error('game_date')
        <p class="text-danger">{{ $message }}</p>
        @enderror

        <button type="submit">Send</button>
    </form>

@endsection
