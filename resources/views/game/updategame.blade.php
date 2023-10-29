@extends('layouts.app')
@section('content')
    <form action="{{ route('saveupdategame') }}" method="POST">
        @csrf
        <input type="hidden" name="id" id="id" class="form-control" value="{{ $game->id }}">
        <label for="score1">your score:</label>
        <input type="text" name="score1" id="score1" class="form-control" value="{{ $game->score_player_one }}">
        <label for="score2">opponent score:</label>
        <input type="text" name="score2" id="score2" class="form-control" value="{{ $game->score_player_two }}">
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
    <a href="{{ route('yourgame') }}" class="btn btn-primary">Cancel</a>
@endsection
