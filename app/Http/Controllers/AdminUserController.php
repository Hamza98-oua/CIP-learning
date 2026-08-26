<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    /**
     * Redirection vers la liste des utilisateurs.
     */
    public function dashboard()
    {
        return redirect()->route('admin.users.index'); // Utilisation recommandée des routes nommées
    }

    /**
     * Afficher la liste de tous les utilisateurs.
     */
    public function index()
    {
        $users = User::all();

        return view('admin.users', compact('users'));
    }

    /**
     * Afficher le formulaire de création.
     */
    public function create()
    {
        return view('admin.users_create');
    }

    /**
     * Enregistrer un nouvel utilisateur.
     */
    public function store(Request $request)
    {
        // Validation stricte d'après les standards
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role'     => 'required',
        ]);

        // Création via Eloquent
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password); // Utilisation de la façade Hash
        $user->role = $request->role;
        $user->save();

        // Redirection avec message flash (syntaxe fluide)
        return redirect('/admin/users')->with('success', 'Utilisateur ajouté avec succès.');
    }

    /**
     * Afficher le formulaire de modification.
     */
    public function edit($id)
    {
        // Utilisation de findOrFail pour la sécurité (génère une 404 si non trouvé)
        $user = User::findOrFail($id);

        return view('admin.users_edit', compact('user'));
    }

    /**
     * Mettre à jour l'utilisateur.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'role'  => 'required',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        // Mise à jour du mot de passe uniquement s'il est renseigné
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect('/admin/users')->with('success', 'Utilisateur modifié avec succès.');
    }

    /**
     * Supprimer un utilisateur.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Vérification de sécurité pour éviter l'auto-suppression
        if (auth()->id() == $id) {
            return back()->withErrors(['erreur' => 'Impossible de supprimer votre propre compte.']);
        }

        $user->delete();

        return back()->with('success', 'Utilisateur supprimé.');
    }
}