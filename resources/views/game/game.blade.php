@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>games</h1>
        @foreach ($games as $game)
            <tr>
                <td>{{$game->player_id_one}}</td>
                <td>{{$game->player_id_two}}</td>
            </tr>
        @endforeach
    </div>
@endsection
