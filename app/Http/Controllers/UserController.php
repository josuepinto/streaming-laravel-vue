<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
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

        // if user exists and password is correct then put them into session
        if ($user && $user->password === $request->password) {
            // ✅ Guardar último acceso
            $user->last_login = now();
            $user->save();
            Session::put('user_id', $user->id);
            Session::put('user_name', $user->name);
            return redirect('/');

        } else {
            return redirect()->back()->with('error', 'Invalid credentials please try again or create an account 1st');
        }
        return redirect()->route('inici');
    }
}
