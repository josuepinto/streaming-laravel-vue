<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // add a new user with signup form
    public function register(Request $request)
    {
        // validate the data
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        // make a new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return redirect()->route('login');

    }

    // login 
    public function login(Request $request)
    {
        // find user by name 
        $user = User::where('name', $request->name)->first();

        // if user exists and password is correct
        if ($user && $user->password === $request->password) {
            return redirect()->route('home');
        }
        return redirect()->route('inici');
    }
}
