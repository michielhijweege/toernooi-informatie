@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>your active games</h1>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">player one</th>
                <th scope="col">player two</th>
                <th scope="col">game date</th>
                <th scope="col">cancel</th>
                <th scope="col">update</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($gamesacitve as $gameacitve)
                <tr>
                    <td>{{$gameacitve->player_one_name}}</td>
                    <td>{{$gameacitve->player_two_name}}</td>
                    <td>{{$gameacitve->game_date}}</td>
                    <td>
                        <form action="{{ route('cancelgame') }}" method="POST">
                            @csrf
                            <input name=id id="id" type="hidden" value="{{$gameacitve->id}}">
                            <button class="btn btn-danger" type="submit">Cancel</button>
                        </form>
                    </td><td>
                        @if($gameacitve->player_one_name == Auth::user()->name)
                        <form action="{{ route('updategame') }}" method="POST">
                            @csrf
                            <input name=id id="id" type="hidden" value="{{$gameacitve->id}}">
                            <button class="btn btn-warning" type="submit">Update</button>
                        </form>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <h1>send invitation</h1>
        <a class="btn btn-primary" href="{{ route('creategame') }}">SEND NEW</a>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">player one</th>
                <th scope="col">player two</th>
                <th scope="col">game date</th>
                <th scope="col">cancel</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($sendgames as $sendgame)
                <tr>
                    <td>{{$sendgame->player_one_name}}</td>
                    <td>{{$sendgame->player_two_name}}</td>
                    <td>{{$sendgame->game_date}}</td>
                    <td>
                    <form action="{{ route('cancelgame') }}" method="POST">
                        @csrf
                        <input name=id id="id" type="hidden" value="{{$sendgame->id}}">
                        <button class="btn btn-danger" type="submit">Cancel</button>
                    </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <h1>retrieve invitation</h1>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">player one</th>
                <th scope="col">player two</th>
                <th scope="col">game date</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($retrievegames as $retrievegame)
                <tr>
                    <td>{{$retrievegame->player_one_name}}</td>
                    <td>{{$retrievegame->player_two_name}}</td>
                    <td>{{$retrievegame->game_date}}</td>
                    <td>
                        <form action="{{ route('acceptgame') }}" method="POST">
                            @csrf
                            <input name=id id="id" type="hidden" value="{{$retrievegame->id}}">
                            <input name=accept id="accept" type="hidden" value="1">
                            <button class="btn btn-success" type="submit">accept</button>
                        </form>
                    </td>
                    <td>
                        <form action="{{ route('cancelgame') }}" method="POST">
                            @csrf
                            <input name=id id="id" type="hidden" value="{{$retrievegame->id}}">
                            <button class="btn btn-warning" type="submit">decline</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
