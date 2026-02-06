<?php

namespace App\Http\Controllers;

use App\Models\Etablissement;
use Illuminate\Http\Request;

class EtablissementController extends Controller
{
     // Afficher la liste des établissements
    public function index()
    {
        $etablissements = Etablissement::orderBy('libelle')->get();

        return view('etablissements.index', compact('etablissements'));
    }

    // Afficher le formulaire de création
    public function create()
    {
        return view('etablissements.create');
    }

   // Enregistrer un nouvel établissement
    public function store(Request $request)
    {
        $request->validate([
            'sigle'   => 'required|string|max:255|unique:etablissements,sigle',
            'libelle' => 'required|string|max:255',
        ]);

        Etablissement::create($request->only('sigle', 'libelle'));

        return redirect()
            ->route('etablissements.index')
            ->with('success', 'Établissement ajouté avec succès');
    }

    // Afficher un établissement
    public function show(Etablissement $etablissement)
    {
        return view('etablissements.show', compact('etablissement'));
    }

    // Afficher le formulaire d’édition
    public function edit(Etablissement $etablissement)
    {
        return view('etablissements.edit', compact('etablissement'));
    }

    // Mettre à jour un établissement
    public function update(Request $request, Etablissement $etablissement)
    {
        $request->validate([
            'sigle'   => 'required|string|max:255|unique:etablissements,sigle,' . $etablissement->id,
            'libelle' => 'required|string|max:255',
        ]);

        $etablissement->update($request->only('sigle', 'libelle'));

        return redirect()
            ->route('etablissements.index')
            ->with('success', 'Établissement modifié avec succès');
    }

    // Supprimer un établissement
    public function destroy(Etablissement $etablissement)
    {
        $etablissement->delete();

        return redirect()
            ->route('etablissements.index')
            ->with('success', 'Établissement supprimé avec succès');
    }
}
