<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Verifica que el usuario exista
        $usuario = User::where('email', $request->email)->first();
        
        if (!$usuario) {
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => __('passwords.user')]);
        }

        // Genera código aleatorio de 6 dígitos
        $codigo = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Elimina códigos antiguos del usuario
        DB::table('password_reset_codes')->where('email', $request->email)->delete();

        // Guarda el código encriptado en la BD con expiración de 15 minutos
        DB::table('password_reset_codes')->insert([
            'email' => $request->email,
            'code' => Crypt::encryptString($codigo),
            'expires_at' => now()->addMinutes(15),
            'created_at' => now(),
        ]);

        // Envía el código usando la clase Mailable
        Mail::send(new ResetPasswordMail($codigo, $request->email));

        // Redirige a la página de validación de código
        return redirect()->route('password.validate', ['email' => $request->email])
            ->with('status', '¡Código enviado! Revisa tu correo electrónico.');
    }
}

