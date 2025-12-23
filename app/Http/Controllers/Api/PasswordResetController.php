<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class PasswordResetController extends Controller
{
    // enviarCodigoRecuperacion - Genera un código aleatorio de 6 dígitos, lo encripta y lo envía por email
    public function sendResetCode(Request $request)
    {
        try {
            $validated = $request->validate([
                'email' => 'required|email',
            ]);

            // Verifica que el usuario exista
            $usuario = User::where('email', $validated['email'])->first();
            
            if (!$usuario) {
                return response()->json([
                    'success' => false,
                    'message' => 'Este correo no existe en nuestro sistema.'
                ], 404);
            }

            // Genera código aleatorio de 6 dígitos
            $codigo = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            // Elimina códigos antiguos del usuario
            DB::table('password_reset_codes')->where('email', $validated['email'])->delete();

            // Guarda el código encriptado en la BD con expiración de 15 minutos
            DB::table('password_reset_codes')->insert([
                'email' => $validated['email'],
                'code' => Crypt::encryptString($codigo),
                'expires_at' => now()->addMinutes(15),
                'created_at' => now(),
            ]);

            // Envía el código sin encriptar por email
            Mail::raw("Tu código de recuperación es: {$codigo}\n\nEste código expirará en 15 minutos.\n\nNo compartir este código con nadie.", function ($message) use ($usuario) {
                $message->to($usuario->email)
                        ->subject('Código de recuperación - Netflix')
                        ->from('netflix@example.com');
            });

            return response()->json([
                'success' => true,
                'message' => 'Se ha enviado un código de 6 dígitos a tu correo. Revisa tu bandeja de entrada.'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // validarCodigo - Valida que el código ingresado sea correcto y no haya expirado
    public function validateCode(Request $request)
    {
        try {
            // Valida que el código sea 6 dígitos
            $validated = $request->validate([
                'email' => 'required|email',
                'code' => 'required|digits:6',
            ]);

            // Busca códigos válidos y no expirados para este correo
            $codigosRecuperacion = DB::table('password_reset_codes')
                ->where('email', $validated['email'])
                ->where('expires_at', '>', now())
                ->get();

            // Desencripta y compara cada código con el ingresado
            foreach ($codigosRecuperacion as $codigoRecuperacion) {
                try {
                    $codigoDesencriptado = Crypt::decryptString($codigoRecuperacion->code);
                    if ($codigoDesencriptado === $validated['code']) {
                        return response()->json([
                            'success' => true,
                            'message' => 'Código validado correctamente. Procede a cambiar tu contraseña.'
                        ], 200);
                    }
                } catch (\Exception $e) {
                    continue;
                }
            }

            // Si no hay coincidencia, el código es inválido o expiró
            return response()->json([
                'success' => false,
                'message' => 'El código es inválido o ha expirado.'
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // restablecerContrasena - Cambia la contraseña del usuario usando el código validado
    public function resetPassword(Request $request)
    {
        try {
            // Valida que la contraseña tenga mínimo 8 caracteres y que coincidan
            $validated = $request->validate([
                'email' => 'required|email',
                'code' => 'required|digits:6',
                'password' => 'required|min:8|confirmed',
            ]);

            // Busca códigos válidos y no expirados
            $codigosRecuperacion = DB::table('password_reset_codes')
                ->where('email', $validated['email'])
                ->where('expires_at', '>', now())
                ->get();

            // Verifica que el código sea válido desencriptando
            $codigoEsValido = false;
            foreach ($codigosRecuperacion as $codigoRecuperacion) {
                try {
                    $codigoDesencriptado = Crypt::decryptString($codigoRecuperacion->code);
                    if ($codigoDesencriptado === $validated['code']) {
                        $codigoEsValido = true;
                        break;
                    }
                } catch (\Exception $e) {
                    continue;
                }
            }

            // Si el código no es válido, rechaza la solicitud
            if (!$codigoEsValido) {
                return response()->json([
                    'success' => false,
                    'message' => 'El código es inválido o ha expirado. Solicita uno nuevo.'
                ], 400);
            }

            // Busca el usuario por su correo
            $usuario = User::where('email', $validated['email'])->first();
            if (!$usuario) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado.'
                ], 404);
            }

            // Actualiza la contraseña encriptada con bcrypt
            $usuario->update(['password' => bcrypt($validated['password'])]);

            // Elimina el código para que no se pueda reutilizar
            DB::table('password_reset_codes')
                ->where('email', $validated['email'])
                ->delete();

            return response()->json([
                'success' => true,
                'message' => 'Tu contraseña ha sido restablecida exitosamente. Ahora puedes iniciar sesión.'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
