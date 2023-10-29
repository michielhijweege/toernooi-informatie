@extends('layouts.app')
@section('content')
    <form action="{{ route('userstore') }}" method="POST">
        @csrf
        <input type="hidden" name="userid" id="userid" class="form-control" value="{{ $user->id }}" required>
        <label for="username">User name:</label>
        <input type="text" name="username" id="username" class="form-control" value="{{ $user->name }}" disabled>
        <label for="useremail">User E-mail:</label>
        <input type="text" name="useremail" id="useremail" class="form-control" value="{{ $user->email }}" disabled>
        <label for="userroll">roll:</label>
        <select name="userroll" id="userroll" class="form-control">
            <option value="0" {{ $user->roll == '0' ? 'selected' : '' }}>Gebruiker</option>
            <option value="1" {{ $user->roll == '1' ? 'selected' : '' }}>Admin</option>
        </select>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
    <a href="{{ route('users') }}" class="btn btn-primary">Cancel</a>
@endsection
