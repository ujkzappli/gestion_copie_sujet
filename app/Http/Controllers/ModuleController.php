<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\User;
use App\Models\Semestre;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    /**
     * Affiche tous les modules selon le rôle de l'utilisateur
     */
    public function index()
    {
        $user = auth()->user();

        $query = Module::with(['semestre', 'enseignant']);

        if ($user->type === 'DA' || $user->type === 'CS') {
            // Modules liés à l'établissement de l'utilisateur
            $query->whereHas('enseignant', function ($q) use ($user) {
                $q->whereHas('departement', function ($q2) use ($user) {
                    $q2->where('etablissement_id', $user->etablissement_id);
                });
            });
        } elseif ($user->type === 'CD') {
            // Modules liés au département de l'utilisateur
            $query->whereHas('enseignant', function ($q) use ($user) {
                $q->where('departement_id', $user->departement_id);
            });
        } elseif ($user->type === 'Enseignant') {
            // L'enseignant ne voit que ses modules
            $query->where('enseignant_id', $user->id);
        }
        // Admin / Président → accès complet

        $modules = $query->get();

        return view('modules.index', compact('modules'));
    }

    /**
     * Formulaire de création d'un module
     */
    public function create()
    {
        $user = auth()->user();

        // Enseignants disponibles selon le rôle
        if ($user->type === 'DA' || $user->type === 'CS') {
            $enseignants = User::where('type', 'Enseignant')
                ->whereHas('departement', function ($q) use ($user) {
                    $q->where('etablissement_id', $user->etablissement_id);
                })->get();
        } elseif ($user->type === 'CD') {
            $enseignants = User::where('type', 'Enseignant')
                ->where('departement_id', $user->departement_id)
                ->get();
        } else {
            // Admin / Président → tous les enseignants
            $enseignants = User::where('type', 'Enseignant')->get();
        }

        $semestres = Semestre::orderBy('libelle')->get();

        return view('modules.create', compact('semestres', 'enseignants'));
    }

    /**
     * Stocke un nouveau module
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:modules,code',
            'nom' => 'required|string',
            'semestre_id' => 'required|exists:semestres,id',
            'enseignant_id' => 'nullable|exists:users,id',
        ]);

        Module::create($request->only(['code', 'nom', 'semestre_id', 'enseignant_id']));

        return redirect()->route('modules.index')
                         ->with('success', 'Module créé avec succès');
    }

    /**
     * Affiche un module
     */
    public function show(Module $module)
    {
        $module->load(['semestre', 'enseignant']);
        return view('modules.show', compact('module'));
    }

    /**
     * Formulaire d'édition d'un module
     */
    public function edit(Module $module)
    {
        $user = auth()->user();

        // Filtrer les enseignants selon le rôle
        if ($user->type === 'DA' || $user->type === 'CS') {
            $enseignants = User::where('type', 'Enseignant')
                ->whereHas('departement', function ($q) use ($user) {
                    $q->where('etablissement_id', $user->etablissement_id);
                })->get();
        } elseif ($user->type === 'CD') {
            $enseignants = User::where('type', 'Enseignant')
                ->where('departement_id', $user->departement_id)
                ->get();
        } else {
            $enseignants = User::where('type', 'Enseignant')->get();
        }

        $semestres = Semestre::orderBy('libelle')->get();

        return view('modules.edit', compact('module', 'semestres', 'enseignants'));
    }

    /**
     * Met à jour un module existant
     */
    public function update(Request $request, Module $module)
    {
        $request->validate([
            'code' => 'required|string|unique:modules,code,' . $module->id,
            'nom' => 'required|string',
            'semestre_id' => 'required|exists:semestres,id',
            'enseignant_id' => 'nullable|exists:users,id',
        ]);

        $module->update($request->only(['code', 'nom', 'semestre_id', 'enseignant_id']));

        return redirect()->route('modules.index')
                         ->with('success', 'Module mis à jour avec succès');
    }

    /**
     * Supprime un module
     */
    public function destroy(Module $module)
    {
        $module->delete();

        return redirect()->route('modules.index')
                         ->with('success', 'Module supprimé avec succès');
    }
}
