<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peliculas; 
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PeliculasController extends Controller
{
  
    public function index()
    {
        $peliculas = Peliculas::all(); 
        
        return view('admin.peliculas.administrar-peliculas', [
            'peliculas' => $peliculas
        ]);
    }

 
    public function create()
    {
      
        return view('admin.peliculas.form-peliculas'); 
    }
    

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|max:255',
                'description' => 'required',
                'poster_url' => 'required|url',
                'genre' => 'required|max:100',
                'duration_minutes' => 'nullable|integer',
                'video_url' => 'nullable|url',
            ]);
            
            
            Peliculas::create([
                'title' => $request->title,
                'description' => $request->description,
                'poster_url' => $request->poster_url,
                'genre' => $request->genre,
                'duration_minutes' => $request->duration_minutes,
                'video_url' => $request->video_url,
            ]);

     
            return redirect()->route('admin.peliculas.index')->with('success', '¡Película añadida correctamente!');
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    
    public function edit($id)
    {
    
        $pelicula = Peliculas::findOrFail($id);
        
        
        return view('admin.peliculas.editar-pelicula', [
            'pelicula' => $pelicula
        ]);
    }


    public function update(Request $request, $id) 
    {
     
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'genre' => 'required',
            'duration_minutes' => 'nullable|integer',
           
        ]);

 
        $pelicula = Peliculas::findOrFail($id);
        
     
        $pelicula->title = $request->input('title');
        $pelicula->description = $request->input('description');
        $pelicula->genre = $request->input('genre');
        $pelicula->duration_minutes = $request->input('duration_minutes');
        $pelicula->poster_url = $request->input('poster_url'); 
        $pelicula->video_url = $request->input('video_url'); 
        
     
        $pelicula->save();

   
        return redirect()->route('admin.peliculas.index')->with('success', 'Película modificada correctamente.');
    }


    public function destroy($id) 
    {
        try {
       
            Peliculas::findOrFail($id)->delete();
            
            return redirect()->route('admin.peliculas.index')->with('success', 'Película eliminada correctamente.');

        } catch (\Exception $e) {
            \Log::error('Error de eliminación: ' . $e->getMessage());
            return redirect()->route('admin.peliculas.index')->with('error', 'Error CRÍTICO: No se pudo eliminar la película.');
        }
    }

    
}