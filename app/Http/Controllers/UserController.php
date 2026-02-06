<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //FORMULAIRE INSCRIPTION//
    public function create()
    {
        return view('auth.register');
    }

    //TRAITEMENT INSCRIPTION//
    public function store(Request $request)
    {
        $request->validate([
            'nom_utilisateur' => 'required',
            'prenom_utilisateur' => 'required',
            'email' => 'required|email|unique:users',
            'matricule_utilisateur' => 'required|unique:users',
            'password' => 'required|min:6',
            'type' => 'required|in:Admin,President,Enseignant,CD,CS,DA',
            'etablissement_id' => 'nullable|required_if:type,DA,CS,CD',
            'departement_id' => 'nullable|required_if:type,CD,Enseignant',
        ]);

        $user = User::create([
            'nom_utilisateur'       => $request->nom_utilisateur,
            'prenom_utilisateur'    => $request->prenom_utilisateur,
            'email'                 => $request->email,
            'matricule_utilisateur' => $request->matricule_utilisateur,
            'type'                  => $request->type,
            'password'  => Hash::make($request->password),
            'departement_id'        => $request->departement_id,
            'etablissement_id'      => $request->etablissement_id,
        ]);

        Auth::login($user);

          return redirect()->route('dashboard');
    }

    //FORMULAIRE CONNEXION
    public function loginForm()
    {
        return view('auth.login');
    }

    //TRAITEMENT CONNEXION
    public function login(Request $request)
{
    $credentials = [
        'email' => $request->email,
        'password' => $request->password_utilisateur,
    ];

    if (Auth::attempt($credentials)) {
          return redirect()->route('dashboard');
    }

    return back()->withErrors([
        'email' => 'Email ou mot de passe incorrect',
    ]);
}


    //DECONNEXION
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.form');
    }

    //PROFIL
    public function profile()
    {
        return view('profile');
    }

    //MISE A JOUR PROFIL//
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'nom_utilisateur' => 'required|string|max:255',
            'prenom_utilisateur' => 'required|string|max:255',
            'matricule_utilisateur' => 'required|string|unique:users,matricule_utilisateur,' . $user->id,
            'type' => 'required',
            'departement_id' => 'nullable|integer',
            'etablissement_id' => 'nullable|integer',
            'photo' => 'nullable|image|max:2048',
            'adresse' => 'nullable|string|max:255',
            'phone_country_code' => 'required|string|max:5',
            'phone_number' => 'nullable|string|max:20',
        ]);

        $data = $request->only([
            'nom_utilisateur','prenom_utilisateur','matricule_utilisateur','type','departement_id','etablissement_id','adresse','phone_country_code','phone_number'
        ]);

        // mot de passe
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // photo
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $path = $file->store('photos', 'public');
            $data['photo'] = $path;
        }

        $user->update($data);

        return back()->with('success', 'Profil mis à jour avec succès !');
    }


    //SUPPRESSION DU COMPTE//
    public function destroy()
    {
        /** @var User $user */
        $user = Auth::user();

        Auth::logout();
        $user->delete();

        return redirect()->route('register.form');
    }
}
