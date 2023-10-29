<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct() { $this->middleware('auth'); }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->roll == 1) {
            $users = User::all();
            return view('admin/users', compact('users'));
        }else{
            return redirect()->route('search');
        }
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
    public function update(Request $request)
    {
        $controlledform = $request->validate([
            'id' => 'numeric'
        ]);
        if (Auth::user()->roll == 1) {
            $user = User::where('id', $request['id'])->first();
            return view('admin/updateuser', compact('user'));
        }else{
            return redirect()->route('search');
        }
    }

    public function storeupdate(Request $request)
    {
        $controlledform = $request->validate([
            'userid' => 'numeric',
            'userroll' => 'numeric'
        ]);
        if (Auth::user()->roll == 1) {
            $updateuser = User::where('id', $request['userid'])
                ->update([
                'roll' => $request->input('userroll'),
            ]);
            return redirect()->route('users');
        }else{
            return redirect()->route('search');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $controlledform = $request->validate([
            'id' => 'numeric'
        ]);
        if (Auth::user()->roll == 1) {
            var_dump($request->all());
            $user = User::where('id', '=', $request['id'])
                ->delete();
            return redirect()->route('users');
        }else{
            return redirect()->route('search');
        }

    }
}
