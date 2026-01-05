<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ProfileApiController extends Controller
{
    /**
     * GET /api/profiles - Listar todos los perfiles del usuario autenticado
     */
    public function index(Request $request)
    {
        try {
            $profiles = Profile::where('user_id', $request->user()->id)->get();
            
            // Asegurar que _id se serializa correctamente para Android
            $profilesArray = $profiles->map(function($profile) {
                return [
                    '_id' => (string) $profile->_id,
                    'user_id' => $profile->user_id,
                    'nombre_perfil' => $profile->nombre_perfil,
                    'avatar_url' => $profile->avatar_url,
                    'es_niño' => $profile->es_niño,
                    'created_at' => $profile->created_at,
                    'updated_at' => $profile->updated_at
                ];
            });
            
            return response()->json([
                'success' => true,
                'profiles' => $profilesArray,
                'count' => $profilesArray->count(),
                'message' => null
            ], 200);
            
        } catch (\Exception $e) {
            Log::error('Error al listar perfiles: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'profiles' => [],
                'count' => 0,
                'message' => 'Error al cargar perfiles'
            ], 500);
        }
    }

    /**
     * POST /api/profiles - Crear nuevo perfil
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nombre_perfil' => 'required|string|max:100',
                'avatar_url' => 'nullable|string',
                'es_niño' => 'required|boolean'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'profile' => null,
                    'message' => $validator->errors()->first()
                ], 400);
            }

            // Verificar límite de 5 perfiles
            $count = Profile::where('user_id', $request->user()->id)->count();
            if ($count >= 5) {
                return response()->json([
                    'success' => false,
                    'profile' => null,
                    'message' => 'Has alcanzado el límite de 5 perfiles'
                ], 400);
            }

            $profile = Profile::create([
                'user_id' => $request->user()->id,
                'nombre_perfil' => $request->nombre_perfil,
                'avatar_url' => $request->avatar_url ?? 'http://placehold.co/150x150/E50914/FFFFFF?text=P',
                'es_niño' => $request->es_niño,
            ]);

            return response()->json([
                'success' => true,
                'profile' => [
                    '_id' => (string) $profile->_id,
                    'user_id' => $profile->user_id,
                    'nombre_perfil' => $profile->nombre_perfil,
                    'avatar_url' => $profile->avatar_url,
                    'es_niño' => $profile->es_niño,
                    'created_at' => $profile->created_at,
                    'updated_at' => $profile->updated_at
                ],
                'message' => 'Perfil creado exitosamente'
            ], 201);
            
        } catch (\Exception $e) {
            Log::error('Error al crear perfil: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'profile' => null,
                'message' => 'Error al crear perfil'
            ], 500);
        }
    }

    /**
     * GET /api/profiles/{id} - Obtener un perfil específico
     */
    public function show(Request $request, $id)
    {
        $profile = Profile::find($id);

        if (!$profile) {
            return response()->json([
                'success' => false,
                'message' => 'Perfil no encontrado'
            ], 404);
        }

        if ($profile->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'No autorizado'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'profile' => $profile
        ]);
    }

    /**
     * PUT /api/profiles/{id} - Actualizar perfil
     */
    public function update(Request $request, $id)
    {
        $profile = Profile::find($id);

        if (!$profile) {
            return response()->json([
                'success' => false,
                'message' => 'Perfil no encontrado'
            ], 404);
        }

        if ($profile->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'No autorizado'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'nombre_perfil' => 'string|max:100',
            'avatar_url' => 'string|url',
            'es_niño' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400);
        }

        $profile->update($request->only(['nombre_perfil', 'avatar_url', 'es_niño']));

        return response()->json([
            'success' => true,
            'message' => 'Perfil actualizado exitosamente',
            'profile' => $profile
        ]);
    }

    /**
     * DELETE /api/profiles/{id} - Eliminar perfil
     */
    public function destroy(Request $request, $id)
    {
        $profile = Profile::find($id);

        if (!$profile) {
            return response()->json([
                'success' => false,
                'message' => 'Perfil no encontrado'
            ], 404);
        }

        if ($profile->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'No autorizado'
            ], 403);
        }

        // Verificar que no sea el último perfil
        $count = Profile::where('user_id', $request->user()->id)->count();
        if ($count <= 1) {
            return response()->json([
                'success' => false,
                'message' => 'Debes mantener al menos un perfil activo'
            ], 400);
        }

        $profile->delete();

        return response()->json([
            'success' => true,
            'message' => 'Perfil eliminado exitosamente'
        ]);
    }

    /**
     * POST /api/profiles/{id}/select - Seleccionar perfil activo
     * Devuelve el perfil seleccionado para que Android lo guarde localmente
     */
    public function select(Request $request, $id)
    {
        try {
            $profile = Profile::find($id);

            if (!$profile) {
                return response()->json([
                    'success' => false,
                    'profile' => null,
                    'message' => 'Perfil no encontrado'
                ], 404);
            }

            if ($profile->user_id !== $request->user()->id) {
                return response()->json([
                    'success' => false,
                    'profile' => null,
                    'message' => 'No autorizado'
                ], 403);
            }

            return response()->json([
                'success' => true,
                'profile' => [
                    '_id' => (string) $profile->_id,
                    'user_id' => $profile->user_id,
                    'nombre_perfil' => $profile->nombre_perfil,
                    'avatar_url' => $profile->avatar_url,
                    'es_niño' => $profile->es_niño,
                    'created_at' => $profile->created_at,
                    'updated_at' => $profile->updated_at
                ],
                'message' => 'Perfil seleccionado correctamente'
            ], 200);
            
        } catch (\Exception $e) {
            Log::error('Error al seleccionar perfil: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'profile' => null,
                'message' => 'Error al seleccionar perfil'
            ], 500);
        }
    }
}
