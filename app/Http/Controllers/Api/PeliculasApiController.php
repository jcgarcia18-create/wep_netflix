<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peliculas;
use App\Models\HistorialVista;
use Illuminate\Support\Facades\Http; 

class PeliculasApiController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('ai_search') && !empty($request->input('ai_search'))) {
            
            $userQuery = $request->input('ai_search');

            try {
                $response = Http::timeout(5)->post('http://ai:8089/recomendar', [
                    'prompt' => $userQuery
                ]);
            } catch (\Exception $e) {
                return response()->json(['error' => 'No se pudo conectar con Python: ' . $e->getMessage()], 500);
            }

            if ($response->failed()) {
                return response()->json(['error' => 'Python devolvió error: ' . $response->status()], 500);
            }

            $data = $response->json();
            $idsOrdenados = $data['movie_ids'] ?? [];

            if (empty($idsOrdenados)) {
                return response()->json([]);
            }

            $peliculasEncontradas = Peliculas::whereIn('id', $idsOrdenados)->get();

            $peliculasRanking = $peliculasEncontradas->sortBy(function ($modelo) use ($idsOrdenados) {
                return array_search($modelo->id, $idsOrdenados);
            })->values();

            return response()->json($peliculasRanking);
        }

        if ($request->has('perfil_id')) {
            $perfilId = $request->input('perfil_id');
            
            $historial = HistorialVista::where('perfil_id', $perfilId)
                                       ->orderBy('updated_at', 'desc')
                                       ->take(10)
                                       ->pluck('pelicula_id');

            if ($historial->count() == 0) {
                return response()->json([]);
            }

            $peliculas = Peliculas::findMany($historial)
                                  ->sortBy(function ($pelicula) use ($historial) {
                                      return array_search($pelicula->id, $historial->toArray());
                                  });
            
            return response()->json($peliculas->values());
        }
        
        $query = Peliculas::query();
        if ($request->has('genre')) {
            $genre = $request->input('genre');
            $query->where('genre', 'LIKE', "%$genre%");
        }
        
        return response()->json($query->get());
    }

    public function show($id)
    {
        $pelicula = Peliculas::find($id);
        if ($pelicula) {
            return response()->json($pelicula);
        }
        return response()->json(['error' => 'Película no encontrada'], 404);
    }
}