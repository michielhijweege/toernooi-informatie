@extends('layouts.app')

@section('content')

    <form action="{{ route('userupdatesettings') }}" method="POST">
        @csrf
        <label for="username">User name:</label>
        <input type="text" name="username" id="username" class="form-control" value="{{ $user->name }}">
        <label for="useremail">User E-mail:</label>
        <input type="text" name="useremail" id="useremail" class="form-control" value="{{ $user->email }}">
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection
