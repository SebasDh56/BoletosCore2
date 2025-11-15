<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Se ejecuta justo después de que el usuario inicia sesión exitosamente.
     */
    protected function authenticated($request, $user)
    {
        // Marcar que NO ha completado la verificación 2FA
        $user->two_factor_confirmed = false;
        $user->save();

        // Redirigir directamente a la pantalla de validación
        return redirect()->route('2fa.validate');
    }
}
