<?php

namespace App\Http\Controllers;

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

        $yesterday = Carbon::yesterday();
        $games = Game::where('game_date', '>', $yesterday)
            ->where('accepted', '=', '1')
            ->join('users as player_one', 'games.player_id_one', '=', 'player_one.id')
            ->join('Users as player_two', 'games.player_id_two', '=', 'player_two.id')
            ->select('games.id', 'player_one.name as player_one_name', 'player_two.name as player_two_name', 'score_player_one', 'score_player_two', 'game_date')
            ->orderBy('game_date', 'asc');

        if ($user1input) {
            $games->where('player_one.name', 'LIKE', "%$user1input%");
        }

        if ($user2input) {
            $games->where('player_two.name', 'LIKE', "%$user2input%");
        }

        if ($dateinput) {
            $games->whereDate('game_date', '=', $dateinput);
        }

        $games = $games->get();
        return view('game/game', compact('games'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('game/creategame');
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
            'accept' => 'required|max:1'
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $thisuserID = Auth::user()->id;

        var_dump($request->all());

        $game = Game::where('id', '=', $request['id'])
            ->where(function ($query) use ($thisuserID) {
                $query->where('player_id_one', $thisuserID)
                    ->orWhere('player_id_two', $thisuserID);
            })->delete();
        return redirect()->route('yourgame');
    }
}
