<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CustomerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Niezalogowani użytkownicy mogą kontynuować.
        if (!Auth::check()) {
            return $next($request);
        }

        // Zalogowany użytkownik musi być klientem.
        if (Auth::user()->role?->role_name !== 'customer') {
            abort(403, 'Rezerwować może tylko klient');
        }

        return $next($request);
    }
}
