<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ValidateCodeController extends Controller
{
    /**
     * Display the validate code view.
     */
    public function show(Request $request): View
    {
        return view('auth.validate-code', [
            'email' => $request->email
        ]);
    }

    /**
     * Verify the provided code.
     */
    public function verify(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'code' => ['required', 'digits:6'],
        ]);

        // Busca códigos válidos y no expirados para este correo
        $codigosRecuperacion = DB::table('password_reset_codes')
            ->where('email', $request->email)
            ->where('expires_at', '>', now())
            ->get();

        // Si no hay códigos válidos
        if ($codigosRecuperacion->isEmpty()) {
            return back()->withInput($request->only('email'))
                ->withErrors(['code' => 'El código ha expirado. Por favor solicita uno nuevo.']);
        }

        // Desencripta y compara cada código con el ingresado
        foreach ($codigosRecuperacion as $codigoRecuperacion) {
            try {
                $codigoDesencriptado = Crypt::decryptString($codigoRecuperacion->code);
                if ($codigoDesencriptado === $request->code) {
                    // Código válido, redirige a la página de nueva contraseña
                    return redirect()->route('password.reset-form', [
                        'email' => $request->email,
                        'code' => $request->code
                    ])->with('status', 'Código validado. Ahora establece tu nueva contraseña.');
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        // Si no hay coincidencia
        return back()->withInput($request->only('email', 'code'))
            ->withErrors(['code' => 'El código es inválido. Por favor intenta de nuevo.']);
    }
}
