<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Affiche le formulaire de login
    public function showLogin()
    {
        return view('auth.login'); // On créera cette vue
    }

    // Gérer la connexion
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirection en fonction du rôle (optionnel)
            return redirect()->intended('/dashboard'); // tu peux changer
        }

        return back()->withErrors([
            'email' => 'Email ou mot de passe incorrect.',
        ])->withInput();
    }

    // Gérer la déconnexion
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
