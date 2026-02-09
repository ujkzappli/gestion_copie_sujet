<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Etablissement;
use App\Models\Departement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewUserMail;

class AdminUserController extends Controller
{
     public function index()
    {
        $users = User::with(['etablissement', 'departement'])->get(); // charger relations

        return view('admin.users.index', compact('users'));
    }

    // Formulaire création utilisateur
    public function create()
    {
        $etablissements = Etablissement::all();
        $departements = Departement::all();
        return view('admin.users.create', compact('etablissements', 'departements'));
    }

    // Création utilisateur
    public function store(Request $request)
    {
        // Validation des champs
        $request->validate([
            'nom_utilisateur' => 'required|string|max:255',
            'prenom_utilisateur' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'matricule_utilisateur' => 'required|unique:users,matricule_utilisateur',
            'type' => 'required|in:Admin,President,Enseignant,CD,CS,DA',
            'etablissement_id' => 'nullable|required_if:type,DA,CS,CD',
            'departement_id' => 'nullable|required_if:type,CD,Enseignant',
        ]);

        // Génération d'un mot de passe aléatoire
        $password = Str::random(8);

        // Création de l'utilisateur
        $user = User::create([
            'nom_utilisateur' => $request->nom_utilisateur,
            'prenom_utilisateur' => $request->prenom_utilisateur,
            'email' => $request->email,
            'matricule_utilisateur' => $request->matricule_utilisateur,
            'type' => $request->type,
            'etablissement_id' => $request->etablissement_id,
            'departement_id' => $request->departement_id,
            'password' => Hash::make($password),
        ]);

        // Envoi du mail avec les infos de connexion
        Mail::to($user->email)->send(new NewUserMail($user, $password));

        return redirect()->route('admin.users.index')
                         ->with('success', 'Utilisateur créé avec succès et mail envoyé.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Utilisateur supprimé.');
    }

    // Index, edit, update, destroy peuvent être ajoutés ici
}
