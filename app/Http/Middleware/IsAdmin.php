<?php
// app/Http/Middleware/IsAdmin.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        /** @var User $user */
        $user = Auth::user();

        if (!Auth::check() || !$user->isAdmin()) {
            abort(403, 'Accès réservé aux administrateurs.');
        }

        return $next($request);
    }
}