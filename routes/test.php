<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;

Route::get('/test-email', function () {
    $email = 'jonathancansinoperez@gmail.com';
    
    $status = Password::sendResetLink(['email' => $email]);
    
    return response()->json([
        'status' => $status,
        'message' => $status === Password::RESET_LINK_SENT ? 'Correo enviado correctamente' : 'Error al enviar correo'
    ]);
});
