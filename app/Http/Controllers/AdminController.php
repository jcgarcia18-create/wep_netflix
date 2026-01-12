<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Peliculas;
use App\Models\Favorito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    /**
     * Dashboard con estadísticas generales
     * GET /api/admin/dashboard
     */
    public function dashboard()
    {
        try {
            $totalUsuarios = User::count();
            $totalPeliculas = Peliculas::count();
            $totalFavoritos = Favorito::count();

            // Película más popular (la que tiene más favoritos)
            $peliculaPopular = Favorito::select('pelicula_id')
                ->selectRaw('COUNT(*) as count')
                ->groupBy('pelicula_id')
                ->orderByDesc('count')
                ->first();

            $peliculaMasPopular = $peliculaPopular
                ? Peliculas::find($peliculaPopular->pelicula_id)?->title
                : null;

            // Usuario más activo (con más favoritos)
            $usuarioActivo = Favorito::select('user_id')
                ->selectRaw('COUNT(*) as count')
                ->groupBy('user_id')
                ->orderByDesc('count')
                ->first();

            $usuarioMasActivo = $usuarioActivo
                ? User::find($usuarioActivo->user_id)?->name
                : null;

            Log::info('Dashboard admin accedido', [
                'user_id' => request()->user()->id ?? 'unknown'
            ]);

            return response()->json([
                'totalUsuarios' => $totalUsuarios,
                'totalPeliculas' => $totalPeliculas,
                'totalFavoritos' => $totalFavoritos,
                'peliculaMasPopular' => $peliculaMasPopular,
                'usuarioMasActivo' => $usuarioMasActivo
            ]);

        } catch (\Exception $e) {
            Log::error('Error en dashboard admin', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'error' => 'Error al cargar estadísticas'
            ], 500);
        }
    }

    /**
     * Lista de usuarios con conteo de favoritos
     * GET /api/admin/users
     */
    public function getUsers()
    {
        try {
            $usuarios = User::withCount('favoritos')
                ->get()
                ->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'role' => $user->role ?? 'user',
                        'createdAt' => $user->created_at?->toIso8601String(),
                        'favoritosCount' => $user->favoritos_count
                    ];
                });

            Log::info('Lista de usuarios obtenida', [
                'count' => $usuarios->count(),
                'admin_id' => request()->user()->id
            ]);

            return response()->json($usuarios);

        } catch (\Exception $e) {
            Log::error('Error al obtener usuarios', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'error' => 'Error al obtener usuarios'
            ], 500);
        }
    }

    /**
     * Eliminar usuario
     * DELETE /api/admin/users/{id}
     */
    public function deleteUser($id)
    {
        try {
            $user = User::findOrFail($id);

            // Prevenir que el admin se elimine a sí mismo
            if ($user->id == request()->user()->id) {
                return response()->json([
                    'error' => 'No puedes eliminarte a ti mismo'
                ], 403);
            }

            $userName = $user->name;
            $user->delete();

            Log::warning('Usuario eliminado', [
                'deleted_user_id' => $id,
                'deleted_user_name' => $userName,
                'admin_id' => request()->user()->id
            ]);

            return response()->json([
                'message' => 'Usuario eliminado correctamente'
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Usuario no encontrado'
            ], 404);

        } catch (\Exception $e) {
            Log::error('Error al eliminar usuario', [
                'user_id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'error' => 'No se pudo eliminar el usuario'
            ], 500);
        }
    }

    /**
     * Actualizar usuario
     * PUT /api/admin/users/{id}
     */
    public function updateUser(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $request->validate([
                'name' => 'sometimes|string|max:255',
                'email' => 'sometimes|email|unique:users,email,' . $id
            ]);

            $user->update($request->only(['name', 'email']));

            Log::info('Usuario actualizado', [
                'updated_user_id' => $id,
                'admin_id' => request()->user()->id,
                'changes' => $request->only(['name', 'email'])
            ]);

            return response()->json([
                'message' => 'Usuario actualizado correctamente'
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Usuario no encontrado'
            ], 404);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'Datos inválidos',
                'details' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Error al actualizar usuario', [
                'user_id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'error' => 'No se pudo actualizar el usuario'
            ], 500);
        }
    }

    /**
     * Lista de películas
     * GET /api/admin/peliculas
     */
    public function getPeliculas()
    {
        try {
            $peliculas = Peliculas::all();

            Log::info('Lista de películas obtenida para admin', [
                'count' => $peliculas->count(),
                'admin_id' => request()->user()->id
            ]);

            return response()->json($peliculas);

        } catch (\Exception $e) {
            Log::error('Error al obtener películas', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'error' => 'Error al obtener películas'
            ], 500);
        }
    }

    /**
    * Crear nueva película
    * POST /api/admin/peliculas
    */
    public function storePelicula(Request $request)
    {
    try {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'poster_url' => 'required|url',
            'video_url' => 'required|url',
            'duration_minutes' => 'required|integer|min:1',
            'genre' => 'required|string|max:255'
        ]);

        $pelicula = Peliculas::create([
            'title' => $request->title,
            'description' => $request->description,
            'poster_url' => $request->poster_url,
            'video_url' => $request->video_url,
            'duration_minutes' => $request->duration_minutes,
            'genre' => $request->genre
        ]);

        Log::info('Película creada', [
            'pelicula_id' => $pelicula->id,
            'admin_id' => request()->user()->id
        ]);

        return response()->json([
            'message' => 'Película creada correctamente',
            'pelicula' => $pelicula
        ], 201);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'error' => 'Datos inválidos',
            'details' => $e->errors()
        ], 422);

    } catch (\Exception $e) {
        Log::error('Error al crear película', [
            'error' => $e->getMessage()
        ]);

        return response()->json([
            'error' => 'No se pudo crear la película'
        ], 500);
    }
    }

    /**
    * Actualizar película
    * PUT /api/admin/peliculas/{id}
    */
    public function updatePelicula(Request $request, $id)
    {
    try {
        $pelicula = Peliculas::findOrFail($id);

        $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'poster_url' => 'sometimes|url',
            'video_url' => 'sometimes|url',
            'duration_minutes' => 'sometimes|integer|min:1',
            'genre' => 'sometimes|string|max:255'
        ]);

        $pelicula->update($request->only([
            'title',
            'description',
            'poster_url',
            'video_url',
            'duration_minutes',
            'genre'
        ]));

        Log::info('Película actualizada', [
            'pelicula_id' => $id,
            'admin_id' => request()->user()->id,
            'changes' => $request->only([
                'title',
                'description',
                'poster_url',
                'video_url',
                'duration_minutes',
                'genre'
            ])
        ]);

        return response()->json([
            'message' => 'Película actualizada correctamente',
            'pelicula' => $pelicula
        ]);

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json([
            'error' => 'Película no encontrada'
        ], 404);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'error' => 'Datos inválidos',
            'details' => $e->errors()
        ], 422);

    } catch (\Exception $e) {
        Log::error('Error al actualizar película', [
            'pelicula_id' => $id,
            'error' => $e->getMessage()
        ]);

        return response()->json([
            'error' => 'No se pudo actualizar la película'
        ], 500);
    }
    }

    /**
     * Eliminar película
     * DELETE /api/admin/peliculas/{id}
     */
    public function deletePelicula($id)
    {
        try {
            $pelicula = Peliculas::findOrFail($id);

            // Eliminar favoritos asociados
            Favorito::where('pelicula_id', $id)->delete();

            $peliculaTitle = $pelicula->title;
            $pelicula->delete();

            Log::warning('Película eliminada', [
                'deleted_pelicula_id' => $id,
                'deleted_pelicula_title' => $peliculaTitle,
                'admin_id' => request()->user()->id
            ]);

            return response()->json([
                'message' => 'Película eliminada correctamente'
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Película no encontrada'
            ], 404);

        } catch (\Exception $e) {
            Log::error('Error al eliminar película', [
                'pelicula_id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'error' => 'No se pudo eliminar la película'
            ], 500);
        }
    }

    /**
     * Logs de actividad (simulado - implementar según tu sistema)
     * GET /api/admin/logs
     */
    public function getLogs()
    {
        try {
            // Si tienes una tabla de logs real, úsala aquí
            // Por ahora, devolvemos datos simulados

            $logs = [
                [
                    'id' => 1,
                    'usuarioId' => request()->user()->id,
                    'usuarioNombre' => request()->user()->name,
                    'accion' => 'Login',
                    'detalles' => 'Acceso al panel de administración',
                    'timestamp' => now()->toIso8601String()
                ],
                [
                    'id' => 2,
                    'usuarioId' => request()->user()->id,
                    'usuarioNombre' => request()->user()->name,
                    'accion' => 'Ver Dashboard',
                    'detalles' => 'Visualización de estadísticas',
                    'timestamp' => now()->subMinutes(5)->toIso8601String()
                ]
            ];

            Log::info('Logs de actividad obtenidos', [
                'admin_id' => request()->user()->id
            ]);

            return response()->json($logs);

        } catch (\Exception $e) {
            Log::error('Error al obtener logs', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'error' => 'Error al obtener logs'
            ], 500);
        }
    }
}
