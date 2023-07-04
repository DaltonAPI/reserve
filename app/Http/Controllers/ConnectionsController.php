<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConnectionsController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
        $connectedUser = User::findOrFail($request->input('user_id'));

        $user->connect($connectedUser);

        return redirect()->back()->with('success', 'Connection request sent.');
    }

    public function acceptRequest(User $user)
    {
        Auth::user()->acceptConnectionRequest($user);

        return redirect()->back()->with('success', 'Connection request accepted.');
    }
}
