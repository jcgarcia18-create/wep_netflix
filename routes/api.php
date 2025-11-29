<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\PeliculasApiController;
use App\Http\Controllers\FavoritoController;
use App\Models\User;

Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login', [AuthApiController::class, 'login']);

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

    