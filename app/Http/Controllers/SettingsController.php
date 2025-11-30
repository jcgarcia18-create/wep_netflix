<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    /**
     * Mostrar la página de ajustes
     */
    public function index()
    {
        $user = Auth::user();
        $darkMode = session('dark_mode', true); // Por defecto, modo oscuro activado
        
        return view('settings.index', compact('darkMode'));
    }

    /**
     * Actualizar configuración de modo oscuro
     */
    public function toggleDarkMode(Request $request)
    {
        $darkMode = $request->input('dark_mode', false);
        session(['dark_mode' => $darkMode]);
        
        return back()->with('success', 'Configuración actualizada correctamente.');
    }
}
