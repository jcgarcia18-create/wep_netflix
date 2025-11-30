<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    /**
     * Mostrar todos los perfiles del usuario autenticado
     */
    public function index()
    {
        $user = Auth::user();
        $profiles = Profile::where('user_id', $user->id)->get();
        
        return view('profiles.index', compact('profiles'));
    }

    /**
     * Mostrar formulario para crear un nuevo perfil
     */
    public function create()
    {
        return view('profiles.create');
    }

    /**
     * Guardar un nuevo perfil
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_perfil' => 'required|string|max:50',
            'avatar_url' => 'nullable|url',
            'es_niño' => 'boolean'
        ]);

        $user = Auth::user();
        
        // Verificar límite de perfiles (máximo 5 como Netflix)
        $profileCount = Profile::where('user_id', $user->id)->count();
        if ($profileCount >= 5) {
            return back()->with('error', 'Has alcanzado el límite máximo de 5 perfiles.');
        }

        Profile::create([
            'user_id' => $user->id,
            'nombre_perfil' => $request->nombre_perfil,
            'avatar_url' => $request->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($request->nombre_perfil) . '&background=FFD700&color=001F3F&size=200',
            'es_niño' => $request->has('es_niño')
        ]);

        return redirect()->route('user-profiles.index')->with('success', 'Perfil creado exitosamente.');
    }

    /**
     * Mostrar formulario para editar un perfil
     */
    public function edit($id)
    {
        $profile = Profile::findOrFail($id);
        
        // Verificar que el perfil pertenezca al usuario autenticado
        if ($profile->user_id !== Auth::id()) {
            abort(403, 'No autorizado');
        }

        return view('profiles.edit', compact('profile'));
    }

    /**
     * Actualizar un perfil existente
     */
    public function update(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);
        
        // Verificar que el perfil pertenezca al usuario autenticado
        if ($profile->user_id !== Auth::id()) {
            abort(403, 'No autorizado');
        }

        $request->validate([
            'nombre_perfil' => 'required|string|max:50',
            'avatar_url' => 'nullable|url',
            'es_niño' => 'boolean'
        ]);

        $profile->update([
            'nombre_perfil' => $request->nombre_perfil,
            'avatar_url' => $request->avatar_url ?? $profile->avatar_url,
            'es_niño' => $request->has('es_niño')
        ]);

        return redirect()->route('user-profiles.index')->with('success', 'Perfil actualizado exitosamente.');
    }

    /**
     * Eliminar un perfil
     */
    public function destroy($id)
    {
        $profile = Profile::findOrFail($id);
        
        // Verificar que el perfil pertenezca al usuario autenticado
        if ($profile->user_id !== Auth::id()) {
            abort(403, 'No autorizado');
        }

        // Verificar que no sea el último perfil
        $profileCount = Profile::where('user_id', Auth::id())->count();
        if ($profileCount <= 1) {
            return back()->with('error', 'Debes mantener al menos un perfil activo.');
        }

        $profile->delete();

        return redirect()->route('user-profiles.index')->with('success', 'Perfil eliminado exitosamente.');
    }
}
