<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController; 
use App\Http\Controllers\Admin\PeliculasController; 
use App\Http\Controllers\Admin\UserController; 
use App\Http\Controllers\NetflixProfileController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\PlaybackController;
use App\Http\Middleware\CheckSubscription;
use App\Models\HistorialVista;
use App\Models\Peliculas;


Route::get('/', function () {
    return view('welcome');
});

// Ruta del dashboard de USUARIO NORMAL
Route::get('/dashboard', function () {
    $perfilId = session('active_profile_id');
    $profile = \App\Models\Profile::find($perfilId);

    // --- 2. LÓGICA DE "SEGUIR VIENDO" 
    $perfilId = session('active_profile_id'); // Obtiene el perfil de la sesión
    
    $peliculasSeguirViendo = collect(); // Crea una lista vacía por si no hay historial
    $activeProfile = null; // Perfil activo

    if ($perfilId) {
        // Obtener el perfil activo desde MongoDB
        $activeProfile = \App\Models\Profile::find($perfilId);
        
        // Busca en MongoDB el historial de ESE perfil
        $historial = HistorialVista::where('perfil_id', $perfilId)
                                    ->orderBy('updated_at', 'desc')
                                    ->take(10)
                                    ->pluck('pelicula_id'); 
        
        if ($historial->count() > 0) {
            
            $peliculasSeguirViendo = Peliculas::findMany($historial)
                                          ->sortBy(function ($pelicula) use ($historial) {
                                              return array_search($pelicula->id, $historial->toArray());
                                          });
        }
    }
    

    return view('dashboard', [
        'peliculas' => $peliculas,
        'peliculasSeguirViendo' => $peliculasSeguirViendo,
        'activeProfile' => $activeProfile
    ]);

})->middleware([
    'auth',
    'verified',
    'profile.selected',
    CheckSubscription::class
])->name('dashboard');

Route::get('/catalog', function () {
    $peliculas = Peliculas::all();
    return view('catalog', compact('peliculas'));
})->name('catalog');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //-----------------------------------------------------------------------------------------------
    // Muestra la pantalla "¿Quién está viendo?"
    Route::get('/profiles', [NetflixProfileController::class, 'index'])->name('profiles.index');

    // Muestra el formulario para crear un nuevo perfil
    Route::get('/profiles/create', [NetflixProfileController::class, 'create'])->name('profiles.create');

    // Guarda el nuevo perfil
    Route::post('/profiles', [NetflixProfileController::class, 'store'])->name('profiles.store');
    // seleccionar perfil
    Route::get('/profiles/{profile}/select', [NetflixProfileController::class, 'select'])->name('profiles.select');
    // Ruta para registrar la vista (usada por JavaScript)
    Route::post('/playback/log-view', [PlaybackController::class, 'registrarVista'])->name('playback.log');
    
    //-----------------------------------------------------------------------------------------------
    // Rutas para administrar perfiles (CRUD completo)
    Route::get('/manage-profiles', [UserProfileController::class, 'index'])->name('user-profiles.index');
    Route::get('/manage-profiles/create', [UserProfileController::class, 'create'])->name('user-profiles.create');
    Route::post('/manage-profiles', [UserProfileController::class, 'store'])->name('user-profiles.store');
    Route::get('/manage-profiles/{id}/edit', [UserProfileController::class, 'edit'])->name('user-profiles.edit');
    Route::put('/manage-profiles/{id}', [UserProfileController::class, 'update'])->name('user-profiles.update');
    Route::delete('/manage-profiles/{id}', [UserProfileController::class, 'destroy'])->name('user-profiles.destroy');
    
    //-----------------------------------------------------------------------------------------------
    // Rutas para ajustes
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings/toggle-dark-mode', [SettingsController::class, 'toggleDarkMode'])->name('settings.toggle-dark-mode');
});

// Carga rutas de login, register, logout
require __DIR__.'/auth.php';


// Rutas para Stripe
use App\Http\Controllers\StripeController;
Route::middleware(['auth', 'profile.selected'])->group(function () {
    Route::get('/stripe', [StripeController::class, 'showForm'])->name('stripe.form');
    Route::post('/stripe/pay', [StripeController::class, 'processPayment'])->name('stripe.pay');
    Route::get('/stripe/success', [StripeController::class, 'success'])->name('stripe.success');
    Route::get('/stripe/cancel', [StripeController::class, 'cancel'])->name('stripe.cancel');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // 1. Dashboard de admin
    Route::get('/dashboard', function () {
        return view('admin.dashboard'); 
    })->name('dashboard');

    // 2. CRUD de Películas 
    Route::resource('peliculas', PeliculasController::class);

    // 3. Rutas de Usuario 
    Route::get('users', [UserController::class, 'index'])->name('users.index'); 
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy'); 
    Route::patch('users/{user}/toggle-admin', [UserController::class, 'toggleAdmin'])->name('users.toggleAdmin');
});

Route::get('/test-mongo', function () {
    $profile = new \App\Models\Profile();
    $profile->user_id = 1;
    $profile->nombre = 'Prueba';
    $profile->save();
    return 'Perfil creado en MongoDB';
});