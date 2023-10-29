@extends('layouts.app')
@section('content')
    <form action="{{ route('gamestore') }}" method="POST">
        @csrf
        <label for="opponent">Opponent:</label>
        <input type="text" name="opponent" id="opponent" value="{{ old('opponent') }}" required><br>
        @error('opponent')
        <p class="text-danger">{{ $message }}</p>
        @enderror
        <label for="game_date">Game Datum:</label>
        <input type="date" name="game_date" id="game_date" value="{{ old('game_date') }}" min="2023-10-29" max="" required><br>
        @error('game_date')
        <p class="text-danger">{{ $message }}</p>
        @enderror
        <button class="btn btn-primary" type="submit">Send</button>
    </form>

    <script>
        // Get the current date
        const currentDate = new Date();

        // Calculate the date one week from the current date
        const maxDate = new Date(currentDate);
        maxDate.setDate(maxDate.getDate() + 7);

        // Format the maxDate as "YYYY-MM-DD"
        const maxDateFormatted = maxDate.toISOString().split('T')[0];
        @if ($resultCount <= 5)
        // Set the max attribute of the date input
        document.getElementById("game_date").setAttribute("max", maxDateFormatted);
        @endif
    </script>

@endsection
