<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $userId = Session::get('user_id');

        if (! $userId) {
            return redirect()
                ->route('login')
                ->with('error', 'Please log in to continue.');
        }

        $user = User::find($userId);

        if (! $user || ! $user->is_admin) {
            return redirect()
                ->route('home')
                ->with('error', 'You do not have permission to access the admin panel.');
        }

        return $next($request);
    }
}
