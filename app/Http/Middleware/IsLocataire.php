<?php
// app/Http/Middleware/IsLocataire.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsLocataire
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->role !== 'locataire') {
            abort(403, 'Accès réservé aux locataires.');
        }

        return $next($request);
    }
}