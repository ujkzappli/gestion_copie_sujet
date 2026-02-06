<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use App\Models\Etablissement;
use Illuminate\Http\Request;

class DepartementController extends Controller
{
    /**
     * Liste des départements
     */
   public function index()
    {
        $departements = Departement::all();
        $etablissements = Etablissement::all(); // <- Il faut cette ligne

        return view('departements.index', compact('departements', 'etablissements'));
    }

    /**
     * Formulaire de création
     */
    public function create()
    {
        $etablissements = Etablissement::orderBy('libelle')->get();

        return view('departements.create', compact('etablissements'));
    }

    /**
     * Enregistrer un département
     */
    public function store(Request $request)
    {
        $request->validate([
            'code'            => 'required|string|max:50|unique:departements,code',
            'libelle'         => 'required|string|max:255',
            'sigle'           => 'required|string|max:50',
            'etablissement_id'=> 'required|exists:etablissements,id',
        ]);

        Departement::create($request->all());

        return redirect()
            ->route('departements.index')
            ->with('success', 'Département créé avec succès');
    }

    /**
     * Afficher un département
     */
    public function show(Departement $departement)
    {
        $departement->load('etablissement');

        return view('departements.show', compact('departement'));
    }

    /**
     * Formulaire d’édition
     */
    public function edit(Departement $departement)
    {
        $etablissements = Etablissement::orderBy('libelle')->get();

        return view('departements.edit', compact('departement', 'etablissements'));
    }

    /**
     * Mettre à jour un département
     */
    public function update(Request $request, Departement $departement)
    {
        $request->validate([
            'code'            => 'required|string|max:55|unique:departements,code,' . $departement->id,
            'libelle'         => 'required|string|max:255',
            'sigle'           => 'required|string|max:50',
            'etablissement_id'=> 'required|exists:etablissements,id',
        ]);

        $departement->update($request->all());

        return redirect()
            ->route('departements.index')
            ->with('success', 'Département modifié avec succès');
    }

    /**
     * Supprimer un département
     */
    public function destroy(Departement $departement)
    {
        $departement->delete();

        return redirect()
            ->route('departements.index')
            ->with('success', 'Département supprimé avec succès');
    }
}

