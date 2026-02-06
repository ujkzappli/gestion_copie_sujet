<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\User;
use App\Models\Semestre;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    /**
     * Affiche tous les modules.
     */
    public function index()
    {
        $modules = Module::with(['semestre', 'enseignant'])->get();
        return view('modules.index', compact('modules'));
    }

    /**
     * Formulaire de création d'un module.
     */
    public function create()
    {
        $semestres = Semestre::all();
        $enseignants = User::where('type', 'Enseignant')->get();

        return view('modules.create', compact('semestres', 'enseignants'));
    }

    /**
     * Stocke un nouveau module.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:modules,code',
            'nom' => 'required|string',
            'semestre_id' => 'required|exists:semestres,id',
            'enseignant_id' => 'nullable|exists:users,id', // nouveau
        ]);

        Module::create($request->only([
            'code',
            'nom',
            'semestre_id',
            'enseignant_id', // nouveau
        ]));

        return redirect()
            ->route('modules.index')
            ->with('success', 'Module créé avec succès');
    }

    /**
     * Affiche un module.
     */
    public function show(Module $module)
    {
        $module->load(['semestre', 'enseignant']);
        return view('modules.show', compact('module'));
    }

    /**
     * Formulaire d'édition d'un module.
     */
    public function edit(Module $module)
    {
        $semestres = Semestre::all();
        $enseignants = User::where('type', 'Enseignant')->get();

        return view('modules.edit', compact('module', 'semestres', 'enseignants'));
    }

    /**
     * Met à jour un module existant.
     */
    public function update(Request $request, Module $module)
    {
        $request->validate([
            'code' => 'required|string|unique:modules,code,' . $module->id,
            'nom' => 'required|string',
            'semestre_id' => 'required|exists:semestres,id',
            'enseignant_id' => 'nullable|exists:users,id', // nouveau
        ]);

        $module->update($request->only([
            'code',
            'nom',
            'semestre_id',
            'enseignant_id', // nouveau
        ]));

        return redirect()
            ->route('modules.index')
            ->with('success', 'Module mis à jour avec succès');
    }

    /**
     * Supprime un module.
     */
    public function destroy(Module $module)
    {
        $module->delete();

        return redirect()
            ->route('modules.index')
            ->with('success', 'Module supprimé avec succès');
    }
}
