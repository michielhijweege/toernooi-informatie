@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Game Search</h2>
        <form action="{{ route('search') }}" method="GET">
            @csrf
            <div class="form-group">
                <label for="user1">User 1:</label>
                <input type="text" name="user1" id="user1" class="form-control" value="{{ request('user1') }}">
            </div>
            <div class="form-group">
                <label for="user2">User 2:</label>
                <input type="text" name="user2" id="user2" class="form-control" value="{{ request('user2') }}">
            </div>
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" name="date" id="date" class="form-control" value="{{ request('date') }}">
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <table class="table">
            <thead>
            <tr>
                <th>User 1</th>
                <th>User 2</th>
                <th>Score user 1</th>
                <th>Score user 2</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($games as $game)
                <tr>
                    <td>{{ $game->player_one_name }}</td>
                    <td>{{ $game->player_two_name }}</td>
                    <td>{{ $game->score_player_one }}</td>
                    <td>{{ $game->score_player_two }}</td>
                    <td>{{ $game->game_date }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
