<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\PeliculasApiController;
use App\Http\Controllers\Api\PasswordResetController;
use App\Http\Controllers\Api\ProfileApiController;
use App\Http\Controllers\Api\StripeApiController;
use App\Http\Controllers\FavoritoController;
use App\Models\User;

Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login', [AuthApiController::class, 'login']);

// Rutas públicas para recuperación de contraseña
// Estas rutas NO requieren autenticación para permitir que usuarios olviden su contraseña
// POST /api/password/send-code: Envía un código de 6 dígitos al correo del usuario
// POST /api/password/validate-code: Valida que el código ingresado sea correcto y no haya expirado
// POST /api/password/reset: Restablece la contraseña del usuario después de validar el código
Route::post('/password/send-code', [PasswordResetController::class, 'sendCode']);
Route::post('/password/validate-code', [PasswordResetController::class, 'validateCode']);
Route::post('/password/reset', [PasswordResetController::class, 'resetPassword']);

// Rutas públicas de Stripe
// Webhook de Stripe (sin autenticación, valida firma de Stripe)
Route::post('/stripe/webhook', [StripeApiController::class, 'webhook']);

// Callbacks de Stripe (pueden ser llamadas desde navegador después del pago)
Route::get('/stripe/success', [StripeApiController::class, 'success']);
Route::get('/stripe/cancel', [StripeApiController::class, 'cancel']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });
    
    // Rutas de favoritos protegidas con autenticación
    Route::get('/favoritos', [FavoritoController::class, 'index']);
    Route::post('/favoritos/{peliculaId}', [FavoritoController::class, 'store']);
    Route::delete('/favoritos/{peliculaId}', [FavoritoController::class, 'destroy']);
    Route::get('/favoritos/check/{peliculaId}', [FavoritoController::class, 'check']);
    
    // Rutas de perfiles (adulto/niño) para Android
    Route::get('/profiles', [ProfileApiController::class, 'index']);                    // Listar perfiles del usuario
    Route::post('/profiles', [ProfileApiController::class, 'store']);                   // Crear perfil
    Route::get('/profiles/{id}', [ProfileApiController::class, 'show']);                // Obtener un perfil
    Route::put('/profiles/{id}', [ProfileApiController::class, 'update']);              // Editar perfil
    Route::delete('/profiles/{id}', [ProfileApiController::class, 'destroy']);          // Eliminar perfil
    Route::post('/profiles/{id}/select', [ProfileApiController::class, 'select']);      // Seleccionar perfil activo
    
    // Rutas de Stripe para Android (protegidas con autenticación)
    Route::post('/stripe/create-checkout-session', [StripeApiController::class, 'createCheckoutSession']);
    Route::get('/subscription/status', [StripeApiController::class, 'getSubscriptionStatus']);
    Route::post('/subscription/verify', [StripeApiController::class, 'verifySubscription']);
    // Activar suscripción después de pago exitoso (llamado desde Android)
    Route::post('/subscription/activate', [StripeApiController::class, 'activateSubscriptionAfterPayment']);
    
    // Endpoints de administración de suscripciones
    Route::get('/subscription/active-users', [StripeApiController::class, 'getActiveSubscriptionUsers']);
    Route::get('/subscription/statistics', [StripeApiController::class, 'getSubscriptionStatistics']);
});

// Endpoints para películas
Route::get('/peliculas', [PeliculasApiController::class, 'index']); // Listar todas o filtrar por género
Route::get('/peliculas/{id}', [PeliculasApiController::class, 'show']); // Ver detalles por ID

    