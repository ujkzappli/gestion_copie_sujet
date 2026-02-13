<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\User;
use App\Models\Semestre;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $user = auth()->user();

        $query = Module::with(['semestre', 'enseignant']);

        if ($user->type === 'DA' || $user->type === 'CS') {
            $query->whereHas('enseignant', function ($q) use ($user) {
                $q->whereHas('departement', function ($q2) use ($user) {
                    $q2->where('etablissement_id', $user->etablissement_id);
                });
            });
        } 
        elseif ($user->type === 'CD') {
            $query->whereHas('enseignant', function ($q) use ($user) {
                $q->where('departement_id', $user->departement_id);
            });
        } 
        elseif ($user->type === 'Enseignant') {
            $query->where('enseignant_id', $user->id);
        }

        $modules = $query->get();

        return view('modules.index', compact('modules'));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $user = auth()->user();

        // Seuls CD et DA peuvent créer
        if (!in_array($user->type, ['CD', 'DA'])) {
            abort(403);
        }

        // CD et DA voient TOUS les enseignants
        $enseignants = User::where('type', 'Enseignant')
            ->select('id', 'nom_utilisateur', 'prenom_utilisateur', 'matricule_utilisateur')
            ->orderBy('nom_utilisateur')
            ->get();

        $semestres = Semestre::orderBy('libelle')->get();

        return view('modules.create', compact('enseignants', 'semestres'));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $user = auth()->user();

        if (!in_array($user->type, ['CD', 'DA'])) {
            abort(403);
        }

        $request->validate([
            'code' => 'required|string|unique:modules,code',
            'nom' => 'required|string',
            'semestre_id' => 'required|exists:semestres,id',
            'enseignant_id' => 'nullable|exists:users,id',
        ]);

        Module::create($request->only([
            'code',
            'nom',
            'semestre_id',
            'enseignant_id'
        ]));

        return redirect()->route('modules.index')
            ->with('success', 'Module créé avec succès');
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(Module $module)
    {
        $user = auth()->user();

        if (!in_array($user->type, ['CD', 'DA'])) {
            abort(403);
        }

        $enseignants = User::where('type', 'Enseignant')
            ->select('id', 'nom_utilisateur', 'prenom_utilisateur', 'matricule_utilisateur')
            ->orderBy('nom_utilisateur')
            ->get();

        $semestres = Semestre::orderBy('libelle')->get();

        return view('modules.edit', compact('module', 'enseignants', 'semestres'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, Module $module)
    {
        $user = auth()->user();

        if (!in_array($user->type, ['CD', 'DA'])) {
            abort(403);
        }

        $request->validate([
            'code' => 'required|string|unique:modules,code,' . $module->id,
            'nom' => 'required|string',
            'semestre_id' => 'required|exists:semestres,id',
            'enseignant_id' => 'nullable|exists:users,id',
        ]);

        $module->update($request->only([
            'code',
            'nom',
            'semestre_id',
            'enseignant_id'
        ]));

        return redirect()->route('modules.index')
            ->with('success', 'Module mis à jour avec succès');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy(Module $module)
    {
        $user = auth()->user();

        if (!in_array($user->type, ['CD', 'DA'])) {
            abort(403);
        }

        $module->delete();

        return redirect()->route('modules.index')
            ->with('success', 'Module supprimé avec succès');
    }
}
