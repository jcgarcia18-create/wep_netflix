<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileApiController extends Controller
{
    /**
     * GET /api/profiles - Listar todos los perfiles del usuario autenticado
     */
    public function index(Request $request)
    {
        $profiles = Profile::where('user_id', $request->user()->id)->get();
        return response()->json([
            'success' => true,
            'profiles' => $profiles
        ]);
    }

    /**
     * POST /api/profiles - Crear nuevo perfil
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre_perfil' => 'required|string|max:100',
            'avatar_url' => 'required|string|url',
            'es_niÃ±o' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400);
        }

        // Verificar lÃ­mite de 5 perfiles
        $count = Profile::where('user_id', $request->user()->id)->count();
        if ($count >= 5) {
            return response()->json([
                'success' => false,
                'message' => 'Has alcanzado el lÃ­mite de 5 perfiles'
            ], 400);
        }

        $profile = Profile::create([
            'user_id' => $request->user()->id,
            'nombre_perfil' => $request->nombre_perfil,
            'avatar_url' => $request->avatar_url,
            'es_niÃ±o' => $request->es_niÃ±o ?? false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Perfil creado exitosamente',
            'profile' => $profile
        ], 201);
    }

    /**
     * GET /api/profiles/{id} - Obtener un perfil especÃ­fico
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
            'es_niÃ±o' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400);
        }

        $profile->update($request->only(['nombre_perfil', 'avatar_url', 'es_niÃ±o']));

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

        // Verificar que no sea el Ãºltimo perfil
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
            'message' => 'Perfil seleccionado exitosamente',
            'profile' => $profile
        ]);
    }
}

