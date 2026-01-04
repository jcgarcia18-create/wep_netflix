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
    /**
     * Envía un código de 6 dígitos al correo electrónico del usuario
     * Este código es encriptado y almacenado en la base de datos con expiración de 15 minutos
     * @param Request $request Debe contener el campo 'email' del usuario registrado
     * @return JSON con estado de éxito o error
     */
    public function sendCode(Request $request)
    {
        try {
            // Valida que el email sea válido y obligatorio
            $validated = $request->validate([
                'email' => 'required|email',
            ]);

            // Verifica que el usuario exista en el sistema
            $usuario = User::where('email', $validated['email'])->first();
            
            if (!$usuario) {
                return response()->json([
                    'success' => false,
                    'message' => 'Este correo no existe en nuestro sistema.'
                ], 404);
            }

            // Genera un código aleatorio de 6 dígitos
            $codigo = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            // Elimina códigos antiguos del mismo usuario para evitar confusiones
            DB::table('password_reset_codes')->where('email', $validated['email'])->delete();

            // Guarda el código encriptado en la base de datos con expiración de 15 minutos
            DB::table('password_reset_codes')->insert([
                'email' => $validated['email'],
                'code' => Crypt::encryptString($codigo),
                'expires_at' => now()->addMinutes(15),
                'created_at' => now(),
            ]);

            // Envía el código al correo del usuario mediante la clase ResetPasswordMail
            Mail::send(new \App\Mail\ResetPasswordMail($codigo, $validated['email']));

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

    /**
     * Valida que el código ingresado por el usuario sea correcto y no haya expirado
     * @param Request $request Debe contener 'email' y 'code' (6 dígitos)
     * @return JSON con estado de validación
     */
    public function validateCode(Request $request)
    {
        try {
            // Valida que el código tenga exactamente 6 caracteres
            $validated = $request->validate([
                'email' => 'required|email',
                'code' => 'required|string|size:6',
            ]);

            // Busca códigos válidos y no expirados para este correo electrónico
            $codigosRecuperacion = DB::table('password_reset_codes')
                ->where('email', $validated['email'])
                ->where('expires_at', '>', now())
                ->get();

            // Desencripta cada código almacenado y lo compara con el ingresado
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

            // Si no hay coincidencia, el código es inválido o ha expirado
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

    /**
     * Restablece la contraseña del usuario después de validar el código
     * @param Request $request Debe contener 'email', 'code', 'password' y 'password_confirmation'
     * @return JSON con estado del restablecimiento y mensaje al usuario
     */
    public function resetPassword(Request $request)
    {
        try {
            // Valida que la nueva contraseña tenga mínimo 6 caracteres y que las dos coincidan
            $validated = $request->validate([
                'email' => 'required|email',
                'code' => 'required|string|size:6',
                'password' => 'required|min:6|confirmed',
            ]);

            // Busca códigos válidos y no expirados para este correo
            $codigosRecuperacion = DB::table('password_reset_codes')
                ->where('email', $validated['email'])
                ->where('expires_at', '>', now())
                ->get();

            // Verifica que el código proporcionado sea válido desencriptando
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

            // Busca el usuario por su correo electrónico
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
