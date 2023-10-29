@extends('layouts.app')
@section('content')
    <div class="container">
        <h2>Game Search</h2>
        <form action="{{ route('search') }}" method="GET">
            @csrf
                <label for="user1">User name:</label>
                <input type="text" name="user1" id="user1" class="form-control" value="{{ request('user1') }}">
                <label for="user2">User name:</label>
                <input type="text" name="user2" id="user2" class="form-control" value="{{ request('user2') }}">
                <label for="date">Date:</label>
                <input type="date" name="date" id="date" class="form-control" value="{{ request('date') }}">
                <label for="followStatus">Follow Status:</label>
                <select name="followStatus" id="followStatus" class="form-control">
                    <option value="0" {{ request('followStatus') == '0' ? 'selected' : '' }}>All</option>
                    <option value="1" {{ request('followStatus') == '1' ? 'selected' : '' }}>Follow</option>
                    <option value="2" {{ request('followStatus') == '2' ? 'selected' : '' }}>Not Follow</option>
                </select>
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
                <th>Volgend</th>
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
                    <td>
                        <div class="form-check form-switch">
                            <form id="followForm{{ $game->id }}" action="{{ route('followgame') }}" method="post">
                                @csrf
                                <input name=gameid id="gameid" type="hidden" value="{{ $game->id }}">
                                <input class="form-check-input" type="checkbox" role="switch" id="followSwitch{{ $game->id }}" @if(in_array($game->id, $followinggames))checked @endif>
                                <label class="form-check-label" for="followSwitch">Follow</label>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <script>
        @foreach ($games as $game)
        const followSwitch{{ $game->id }} = document.getElementById('followSwitch{{ $game->id }}');
        const followForm{{ $game->id }} = document.getElementById('followForm{{ $game->id }}');

        followSwitch{{ $game->id }}.addEventListener('change', () => {
            followForm{{ $game->id }}.submit();
            console.log("send");
        });
        @endforeach
    </script>
@endsection
