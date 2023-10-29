@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>your active games</h1>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">name</th>
                <th scope="col">roll</th>
                <th scope="col">email</th>
                <th scope="col">edit</th>
                <th scope="col">delate</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{$user->name}}</td>
                    <td>
                        @if($user->roll === 0)
                            gebruiker
                        @else
                            admin
                        @endif

                    </td>
                    <td>{{$user->email}}</td>
                    <td>
                        <form action="{{ route('useredit') }}" method="POST">
                            @csrf
                            <input name=id id="id" type="hidden" value="{{$user->id}}">
                            <button class="btn btn-warning" type="submit">Edit</button>
                        </form>
                    </td>
                    <td>
                        <form action="{{ route('destroy') }}" method="POST">
                            @csrf
                            <input name=id id="id" type="hidden" value="{{$user->id}}">
                            <button class="btn btn-danger" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
