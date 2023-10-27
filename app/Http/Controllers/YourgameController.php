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
        //get current user id
        $userID = Auth::user()->id;

        //queary to get active games
        $gamesacitve = Game::where('accepted', '=', '1')
            ->where(function($query) use ($userID) {
                $query->where('player_id_one', '=', $userID)
                    ->orWhere('player_id_two', '=', $userID);
            })
            ->join('users as player_one', 'games.player_id_one', '=', 'player_one.id')
            ->join('users as player_two', 'games.player_id_two', '=', 'player_two.id')
            ->select('games.id', 'player_one.name as player_one_name', 'player_two.name as player_two_name', 'score_player_one', 'score_player_two', 'game_date', 'accepted')
            ->orderBy('game_date', 'asc')->get();

        //queary to get send games not answered
        $sendgames = Game::where('accepted', '=', '0')
            ->where('player_id_one', '=', $userID)
            ->join('users as player_one', 'games.player_id_one', '=', 'player_one.id')
            ->join('users as player_two', 'games.player_id_two', '=', 'player_two.id')
            ->select('games.id', 'player_one.name as player_one_name', 'player_two.name as player_two_name', 'score_player_one', 'score_player_two', 'game_date', 'accepted')
            ->orderBy('game_date', 'asc')->get();

        //queary to get retrieve games not answered
        $retrievegames = Game::where('accepted', '=', '0')
            ->where('player_id_two', '=', $userID)
            ->join('users as player_one', 'games.player_id_one', '=', 'player_one.id')
            ->join('users as player_two', 'games.player_id_two', '=', 'player_two.id')
            ->select('games.id', 'player_one.name as player_one_name', 'player_two.name as player_two_name', 'score_player_one', 'score_player_two', 'game_date', 'accepted')
            ->orderBy('game_date', 'asc')->get();

        //retun all
        return view('game/yourgame', compact('gamesacitve', 'sendgames', 'retrievegames'));
    }
}
