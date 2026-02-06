<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\NewUserMail;

class AdminUserController extends Controller
{
    public function __construct()
    {
        // Middleware anonyme pour vérifier si l'utilisateur est Admin
        $this->middleware(function ($request, $next) {
            $user = $request->user(); // <-- mieux que auth()->user()
            if (!$user || $user->type !== 'Admin') {
                abort(403, 'Accès interdit');
            }
            return $next($request);
        });
    }
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom_utilisateur' => 'required|string|max:255',
            'prenom_utilisateur' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'matricule_utilisateur' => 'required|string|unique:users,matricule_utilisateur',
            'type' => 'required|in:Admin,President,Enseignant,CD,CS,DA',
        ]);

        $temporaryPassword = Str::random(8);

        $user = User::create([
            'nom_utilisateur' => $request->nom_utilisateur,
            'prenom_utilisateur' => $request->prenom_utilisateur,
            'email' => $request->email,
            'matricule_utilisateur' => $request->matricule_utilisateur,
            'password' => Hash::make($temporaryPassword),
            'type' => $request->type,
            'must_change_password' => true,
        ]);

        Mail::to($user->email)->send(new NewUserMail($user, $temporaryPassword));

        return redirect()->route('admin.users.index')->with('success', 'Utilisateur créé et email envoyé !');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'nom_utilisateur' => 'required|string|max:255',
            'prenom_utilisateur' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'matricule_utilisateur' => 'required|string|unique:users,matricule_utilisateur,' . $user->id,
            'type' => 'required|in:Admin,President,Enseignant,CD,CS,DA',
        ]);

        $user->update($request->all());

        return redirect()->route('admin.users.index')->with('success', 'Utilisateur mis à jour !');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Utilisateur supprimé !');
    }
}
