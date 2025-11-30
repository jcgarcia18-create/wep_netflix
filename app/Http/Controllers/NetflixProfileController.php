<?php

namespace App\Http\Controllers;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NetflixProfileController extends Controller
{
    
    public function index()
    {
        $profiles = Profile::where('user_id', Auth::id())->get();

       
        return view('profile.index', ['profiles' => $profiles]);
    }

 
    public function create()
    {
      $avatars = [
            'http://placehold.co/150x150/E50914/FFFFFF?text=P1', 
            'http://placehold.co/150x150/3070B8/FFFFFF?text=P2',
            'http://placehold.co/150x150/F5A623/FFFFFF?text=P3', 
            'http://placehold.co/150x150/5E5E5E/FFFFFF?text=P4', 
            'http://placehold.co/150x150/00A8E1/FFFFFF?text=P5', 
        ];

     
        return view('profile.create', ['avatars' => $avatars]);
       
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'nombre_perfil' => 'required|string|max:100',
            
            'avatar_url' => 'required|string|url', 
        ]);

        Profile::create([
            'user_id' => Auth::id(),
            'nombre_perfil' => $request->nombre_perfil,
            'avatar_url' => $request->avatar_url ?? 'https://via.placeholder.com/150/374151?text=Perfil',
            'es_niño' => $request->has('es_niño'),
        ]);

        return redirect()->route('profiles.index')->with('success', 'Perfil creado.');
    }
    public function select(Profile $profile) 
    {
      
        if ($profile->user_id !== Auth::id()) {
            abort(403); 
        }

        session(['active_profile_id' => $profile->id]);

       
        return redirect()->route('dashboard'); 
    }
}
