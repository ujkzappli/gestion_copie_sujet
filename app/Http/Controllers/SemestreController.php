<?php

namespace App\Http\Controllers;

use App\Models\Semestre;
use App\Models\Departement;
use Illuminate\Http\Request;

class SemestreController extends Controller
{
    // Liste des semestres
    public function index()
    {
        $semestres = Semestre::all();
        return view('semestres.index', compact('semestres'));
    }

    // Formulaire de création
    public function create()
    {
        $departements = Departement::with('etablissement')->get();
        return view('semestres.create', compact('departements'));
    }

    // Stocker un nouveau semestre
    public function store(Request $request)
    {
        $request->validate([
            'numero' => 'required|integer|unique:semestres,numero',
            'libelle' => 'required|string|max:255',
        ]);

        // Création du semestre avec numéro et libelle
        Semestre::create($request->only('numero', 'libelle'));

        return redirect()
            ->route('semestres.index')
            ->with('success', 'Semestre créé avec succès');
    }

    // Afficher un semestre
    public function show(Semestre $semestre)
    {
        return view('semestres.show', compact('semestre'));
    }

    // Formulaire d'édition
    public function edit(Semestre $semestre)
    {
        return view('semestres.edit', compact('semestre'));
    }

    // Mettre à jour un semestre
    public function update(Request $request, Semestre $semestre)
    {
        $request->validate([
            'numero' => 'required|integer|unique:semestres,numero,' . $semestre->id,
            'libelle' => 'required|string|max:255',
        ]);

        $semestre->update($request->only('numero', 'libelle'));

        return redirect()
            ->route('semestres.index')
            ->with('success', 'Semestre mis à jour');
    }

    // Supprimer un semestre
    public function destroy(Semestre $semestre)
    {
        $semestre->delete();

        return redirect()
            ->route('semestres.index')
            ->with('success', 'Semestre supprimé');
    }
}
