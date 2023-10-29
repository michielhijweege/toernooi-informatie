<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function __construct() { $this->middleware('auth'); }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userID = Auth::user()->id;
        $user = User::where('id', '=', $userID)->first();

        return view('settings', compact('user'));
    }

    public  function update(Request $request)
    {
        $controlledform = $request->validate([
            'username' => 'required|max:255',
            'useremail' => 'required|max:255'
        ]);

        $userID = Auth::user()->id;
        $updateuser = User::where('id', $userID)
            ->update([
                'name' => $request->input('username'),
                'email' => $request->input('useremail'),
            ]);
        return redirect()->route('usersettings');
    }
}
