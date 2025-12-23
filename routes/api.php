<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\PeliculasApiController;
use App\Http\Controllers\Api\PasswordResetController;
use App\Http\Controllers\FavoritoController;
use App\Models\User;

// Ruta de prueba
Route::get('/test', function () {
    return response()->json(['message' => 'GET API funcionando']);
});

Route::post('/test-post', function () {
    return response()->json(['message' => 'POST API funcionando']);
});

Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login', [AuthApiController::class, 'login']);

// Rutas de recuperación de contraseña con código (sin autenticación)
Route::withoutMiddleware(['web'])->group(function () {
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetCode']);
    Route::post('/validate-code', [PasswordResetController::class, 'validateCode']);
    Route::post('/reset-password', [PasswordResetController::class, 'resetPassword']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });
    
    // Rutas de favoritos protegidas con autenticación
    Route::get('/favoritos', [FavoritoController::class, 'index']);
    Route::post('/favoritos/{peliculaId}', [FavoritoController::class, 'store']);
    Route::delete('/favoritos/{peliculaId}', [FavoritoController::class, 'destroy']);
    Route::get('/favoritos/check/{peliculaId}', [FavoritoController::class, 'check']);
});


//api para traerme todos los usuarios
Route::get('/users', function () {
    return response()->json(User::all());
});

//api para contar todos los usuarios
Route::get('/users/count', function () {
    return response()->json(['count' => User::count()]);
});

//api para traer usuarios por id
Route::get('/users/{id}', function ($id) {
    $user = User::find($id);
    if ($user) {
        return response()->json($user);
    }
    return response()->json(['error' => 'Usuario no encontrado'], 404);
});

// Endpoints para películas
Route::get('/peliculas', [PeliculasApiController::class, 'index']); // Listar todas o filtrar por género
Route::get('/peliculas/{id}', [PeliculasApiController::class, 'show']); // Ver detalles por ID

    