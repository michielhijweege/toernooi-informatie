<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\Game;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use function Psy\debug;

class GameController extends Controller
{
    public function __construct() { $this->middleware('auth'); }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    public function search(Request $request)
    {
        $user1input = $request->input('user1');
        $user2input = $request->input('user2');
        $dateinput = $request->input('date');
        $followStatus = $request->input('followStatus');

        $controlledform = $request->validate([
            'user1',
            'user2',
            'date',
            'followStatus'
        ]);

        $yesterday = Carbon::yesterday();
        $games = Game::where('game_date', '>', $yesterday)
            ->where('accepted', '=', '1')
            ->join('users as player_one', 'games.player_id_one', '=', 'player_one.id')
            ->join('Users as player_two', 'games.player_id_two', '=', 'player_two.id')
            ->select('games.id', 'player_one.name as player_one_name', 'player_two.name as player_two_name', 'score_player_one', 'score_player_two', 'game_date')
            ->orderBy('game_date', 'asc');

        if ($user1input) {
            $games->where(function ($games) use ($user1input) {
                $games->where('player_one.name', '=', "$user1input")
                    ->orWhere('player_two.name', '=', "$user1input");
            });
        }

        if ($user2input) {
            $games->where(function ($games) use ($user2input) {
                $games->where('player_one.name', '=', "$user2input")
                    ->orWhere('player_two.name', '=', "$user2input");
            });
        }

        if ($dateinput) {
            $games->whereDate('game_date', '=', $dateinput);
        }

        $thisuserID = Auth::user()->id;
        $followinggames = Follow::where('user_id', '=', $thisuserID)
            ->pluck('game_id')
            ->all();

        // Filter by follow status
        if ($followStatus == '1') {
            $games->whereIn('games.id', $followinggames);
        }
        if ($followStatus == '2') {
            $games->whereNotIn('games.id', $followinggames);
        }

        $games = $games->get();

        return view('game/game', compact('games', 'followinggames'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $thisuserID = Auth::user()->id;
        $games = Game::where(function ($query) use ($thisuserID) {
            $query->where('player_id_one', $thisuserID)
                ->orWhere('player_id_two', $thisuserID);
        })->get();

        $resultCount = $games->count();

        return view('game/creategame', compact('games', 'resultCount'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $thisuserID = Auth::user()->id;

        var_dump($request->all());
        $controlledform = $request->validate([
            'opponent' => 'required|max:255',
            'game_date' => 'required|date',
        ]);

        $user = User::where('name', $request['opponent'])->first();
        if (!$user) {
            return back();
        }

        $uservsId = $user->id;

        $game = new Game();
        $game->player_id_one= $thisuserID;
        $game->player_id_two= $uservsId;
        $game->game_date= $request['game_date'];
        $game->save();
        return redirect()->route('yourgame');
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
    public function update(Request $request)
    {
        $thisuserID = Auth::user()->id;

        $controlledform = $request->validate([
            'accept' => 'required|numeric'
        ]);

        $game = Game::where('id', $request['id']) // Use the provided ID to find the specific game
        ->where(function ($query) use ($thisuserID) {
            $query->where('player_id_one', $thisuserID)
                ->orWhere('player_id_two', $thisuserID);
        })
            ->update([
                'accepted' => $request->input('accept'),
            ]);

        // Check if the update was successful
        if ($game) {
            return redirect()->route('yourgame')->with('success', 'Game updated successfully');
        } else {
            return redirect()->route('yourgame')->with('error', 'Game not found or you do not have permission to update it.');
        }
    }
    public function updatepage(Request $request)
    {
        $game = Game::where('id', '=', $request->input('id'))->first();

        return view('game/updategame', compact('game'));
    }

    public function updatescore(Request $request)
    {
        $controlledform = $request->validate([
            'id' => 'required|numeric',
            'score1' => 'required|numeric',
            'score2' => 'required|numeric'
        ]);

        $game = Game::where('id', '=', $request->input('id'))
            ->update([
                'score_player_one' => $request['score1'],
                'score_player_two' => $request['score2'],
            ]);
        return redirect()->route('yourgame');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $thisuserID = Auth::user()->id;

        var_dump($request->all());
        $controlledform = $request->validate([
            'id' => 'required|numeric'
        ]);

        $game = Game::where('id', '=', $request['id'])
            ->where(function ($query) use ($thisuserID) {
                $query->where('player_id_one', $thisuserID)
                    ->orWhere('player_id_two', $thisuserID);
            })->delete();
        return redirect()->route('yourgame');
    }

    public function followgame(Request $request) {
        $thisuserID = Auth::user()->id;

        var_dump($request->all());

        $controlledform = $request->validate([
            'gameid' => 'required|numeric'
        ]);

        // Check if the user is already following the game
        $userGame = Follow::where('user_id', $thisuserID)
            ->where('game_id', $request['gameid'])
            ->first();

        if (!$userGame)
        {
            // User is not following, so create a new relationship
            $follow = new Follow();
            $follow->user_id= $thisuserID;
            $follow->game_id= $request['gameid'];
            $follow->save();
        }
        else
        {
            $userGame->delete();
        }
        return redirect()->back();
    }
}
