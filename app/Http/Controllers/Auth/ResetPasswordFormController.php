<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\View\View;

class ResetPasswordFormController extends Controller
{
    /**
     * Display the reset password form.
     */
    public function show(Request $request): View
    {
        return view('auth.reset-password-form', [
            'email' => $request->email,
            'code' => $request->code
        ]);
    }

    /**
     * Reset the password.
     */
    public function reset(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'code' => ['required', 'digits:6'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        // Busca códigos válidos y no expirados
        $codigosRecuperacion = DB::table('password_reset_codes')
            ->where('email', $request->email)
            ->where('expires_at', '>', now())
            ->get();

        // Verifica que el código sea válido
        $codigoEsValido = false;
        foreach ($codigosRecuperacion as $codigoRecuperacion) {
            try {
                $codigoDesencriptado = Crypt::decryptString($codigoRecuperacion->code);
                if ($codigoDesencriptado === $request->code) {
                    $codigoEsValido = true;
                    break;
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        if (!$codigoEsValido) {
            return back()->withErrors(['code' => 'El código es inválido o ha expirado.']);
        }

        // Busca el usuario
        $usuario = User::where('email', $request->email)->first();
        if (!$usuario) {
            return back()->withErrors(['email' => 'Usuario no encontrado.']);
        }

        // Actualiza la contraseña
        $usuario->update(['password' => bcrypt($request->password)]);

        // Elimina el código
        DB::table('password_reset_codes')
            ->where('email', $request->email)
            ->delete();

        return redirect()->route('login')
            ->with('status', '¡Contraseña restablecida exitosamente! Inicia sesión con tu nueva contraseña.');
    }
}
