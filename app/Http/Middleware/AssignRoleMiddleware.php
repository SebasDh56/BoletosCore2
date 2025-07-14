<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignRoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Debes iniciar sesión.');
        }

        // Asignar rol predeterminado 'cliente' si no está definido
        if (!Auth::user()->role) {
            $user = Auth::user();
            $user->role = 'cliente';
            $user->save();
            // Forzar recarga de la sesión
            Auth::setUser($user);
        }

        $userRole = strtolower(Auth::user()->role);
        $allowedRoles = array_map('strtolower', $roles);

        if (!in_array($userRole, $allowedRoles)) {
            return redirect('/')->with('error', 'Acceso no autorizado. Tu rol: ' . $userRole . ', Permitidos: ' . implode(', ', $allowedRoles));
        }

        return $next($request);
    }
}