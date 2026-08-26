<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Afficher la vue de login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Afficher la vue d'inscription
    public function showRegister()
    {
        return view('auth.register');
    }

    // Traiter l'inscription
    public function register(Request $request)
    {
        // Validation des données d'inscription
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Création du compte avec le rôle stagiaire par défaut
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = 'stagiaire';
        $user->save();

        // Connexion automatique après inscription
        auth()->login($user);
        $request->session()->regenerate();

        return redirect('/stagiaire/dashboard');
    }

    // Traiter la connexion
    public function login(Request $request)
    {
        // Validation directe
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Tentative de connexion via le helper auth()
        if (auth()->attempt($request->only('email', 'password'))) {
            // Sécuriser la session (standard OFPPT)
            $request->session()->regenerate();

            // Redirection selon le rôle
            if (auth()->user()->role === 'stagiaire') {
                return redirect('/stagiaire/dashboard');
            }

            return redirect('/admin');
        }

        // Retour avec erreur si échec
        return back()->withErrors(['email' => 'Identifiants incorrects'])->withInput();
    }

    // Déconnexion
    public function logout(Request $request)
    {
        auth()->logout();

        // Nettoyage de session (préconisé dans le résumé théorique)
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}