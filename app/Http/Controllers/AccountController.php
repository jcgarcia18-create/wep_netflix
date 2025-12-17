<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

class AccountController extends Controller
{
    public function index()
    {
        return view('profiles.account');
    }

    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $field = $request->input('field');

        switch ($field) {
            case 'email':
                $request->validate([
                    'email' => ['required', 'email', 'unique:users,email,' . $user->id],
                    'current_password' => ['required'],
                ]);

                if (!Hash::check($request->current_password, $user->password)) {
                    return back()->withErrors(['current_password' => 'La contraseña actual es incorrecta.']);
                }

                $user->email = $request->email;
                $user->save();

                return back()->with('success', 'Correo electrónico actualizado correctamente.');

            case 'password':
                $request->validate([
                    'current_password' => ['required'],
                    'new_password' => ['required', 'confirmed', Password::min(8)],
                ]);

                if (!Hash::check($request->current_password, $user->password)) {
                    return back()->withErrors(['current_password' => 'La contraseña actual es incorrecta.']);
                }

                $user->password = Hash::make($request->new_password);
                $user->save();

                return back()->with('success', 'Contraseña actualizada correctamente.');

            case 'name':
                $request->validate([
                    'name' => ['required', 'string', 'max:255'],
                ]);

                $user->name = $request->name;
                $user->save();

                return back()->with('success', 'Nombre actualizado correctamente.');

            default:
                return back()->withErrors(['error' => 'Campo no válido.']);
        }
    }
}
