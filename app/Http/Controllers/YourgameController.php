<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class YourgameController extends Controller
{
    public function __construct() { $this->middleware('auth'); }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userID = Auth::user()->id;
        $games = Game::where('player_id_one', '=', $userID, 'OR', 'player_id_two', '=', $userID)
            ->join('users as player_one', 'games.player_id_one', '=', 'player_one.id')
            ->join('users as player_two', 'games.player_id_two', '=', 'player_two.id')
            ->select('games.id', 'player_one.name as player_one_name', 'player_two.name as player_two_name', 'score_player_one', 'score_player_two', 'game_date')
            ->orderBy('game_date', 'asc')->get();
        return view('game/yourgame', compact('games'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
