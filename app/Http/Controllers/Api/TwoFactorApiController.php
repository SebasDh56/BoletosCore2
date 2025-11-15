<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PragmaRX\Google2FAQRCode\Google2FA;

class TwoFactorApiController extends Controller
{
    public function setup(Request $request)
    {
        $user = $request->user();

        $google2fa = new Google2FA();

        $secret = $google2fa->generateSecretKey();

        $user->google2fa_secret = $secret;
        $user->save();

        $qrImage = $google2fa->getQRCodeInline(
            'BoletosCore2',
            $user->email,
            $secret
        );

        return response()->json([
            'secret' => $secret,
            'qr_image' => $qrImage,
        ]);
    }

    public function enable(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string'],
        ]);

        $user = $request->user();

        if (empty($user->google2fa_secret)) {
            return response()->json([
                'message' => 'Primero debes generar el código QR de 2FA con /api/2fa/setup.',
            ], 400);
        }

        $google2fa = new Google2FA();

        $valid = $google2fa->verifyKey($user->google2fa_secret, $request->code);

        if (!$valid) {
            return response()->json([
                'message' => 'Código de autenticación de 2 factores inválido.',
            ], 401);
        }

        $user->two_factor_enabled = true;
        $user->two_factor_confirmed = true;
        $user->save();

        return response()->json([
            'message' => 'Autenticación de 2 factores habilitada correctamente.',
        ]);
    }
}
