<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FAQRCode\Google2FA;

class TwoFactorController extends Controller
{
    // Mostrar formulario para validar después del login
    public function showValidate()
    {
        return view('auth.2fa.validate');
    }

    // Activar 2FA (mostrar QR)
    public function enable2fa(Request $request)
    {
        $user = $request->user();

        $google2fa = new Google2FA();

        $secret = $google2fa->generateSecretKey();

        $user->google2fa_secret = $secret;
        $user->save();

        $QR_Image = $google2fa->getQRCodeInline(
            "Mi Sitio",
            $user->email,
            $secret
        );

        return view('auth.2fa.enable', compact('secret', 'QR_Image'));
    }

    // Validar código al activar 2FA
    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required'
        ]);

        $google2fa = new Google2FA();

        $valid = $google2fa->verifyKey(
            auth()->user()->google2fa_secret,
            $request->code
        );

        if (!$valid) {
            return back()->withErrors(['code' => 'Código incorrecto']);
        }

        auth()->user()->update([
            'two_factor_enabled' => true,
            'two_factor_confirmed' => true,
        ]);

        return redirect()->route('home');
    }


    // 🟢 VALIDACIÓN OBLIGATORIA DESPUÉS DEL LOGIN
    public function validate2fa(Request $request)
    {
        $request->validate([
            'code' => 'required'
        ]);

        $google2fa = new Google2FA();

        $user = Auth::user();

        // Verificar código
        $valid = $google2fa->verifyKey($user->google2fa_secret, $request->code);

        if (!$valid) {
            return back()->withErrors(['code' => 'Código incorrecto, intenta nuevamente']);
        }

        // Marcar como verificado para esta sesión
        session(['2fa_verified' => true]);

        return redirect()->route('home');
    }
}
