<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\Departement;
use App\Models\Semestre;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    /**
     * Liste des options
     */
    public function index()
{
    $user = auth()->user();

    $query = Option::with(['departement.etablissement', 'semestre']);

    // 🔐 DA : uniquement son établissement
    if ($user->type === 'DA') {
        $query->whereHas('departement', function ($q) use ($user) {
            $q->where('etablissement_id', $user->etablissement_id);
        });
    }

    // 🔐 CD : uniquement son département
    if ($user->type === 'CD') {
        $query->where('departement_id', $user->departement_id);
    }

    // 🔐 CS : uniquement son établissement
    if ($user->type === 'CS') {
        $query->whereHas('departement', function ($q) use ($user) {
            $q->where('etablissement_id', $user->etablissement_id);
        });
    }

    // Admin & Président → pas de restriction
    $options = $query->get();

    return view('options.index', compact('options'));
}


    /**
     * Formulaire de création
     */
    public function create()
    {
        $departements = Departement::with('etablissement')
            ->orderBy('libelle')
            ->get();

        $semestres = Semestre::orderBy('libelle')->get();

        return view('options.create', compact('departements', 'semestres'));
    }

    /**
     * Enregistrer une option
     */
    public function store(Request $request)
    {
        $request->validate([
            'code'            => 'required|integer',
            'libelle_option'  => 'required|string|max:255',
            'departement_id'  => 'required|exists:departements,id',
            'semestre_id'     => 'required|exists:semestres,id',
        ]);

        Option::create($request->all());

        return redirect()
            ->route('options.index')
            ->with('success', 'Option créée avec succès');
    }

    /**
     * Afficher une option
     */
    public function show(Option $option)
    {
        $option->load(['departement.etablissement', 'semestre']);

        return view('options.show', compact('option'));
    }

    /**
     * Formulaire d’édition
     */
    public function edit(Option $option)
    {
        $departements = Departement::with('etablissement')->get();
        $semestres    = Semestre::orderBy('libelle')->get();

        return view('options.edit', compact('option', 'departements', 'semestres'));
    }

    /**
     * Mettre à jour une option
     */
    public function update(Request $request, Option $option)
    {
        $request->validate([
            'code'            => 'required|integer',
            'libelle_option'  => 'required|string|max:255',
            'departement_id'  => 'required|exists:departements,id',
            'semestre_id'     => 'required|exists:semestres,id',
        ]);

        $option->update($request->all());

        return redirect()
            ->route('options.index')
            ->with('success', 'Option modifiée avec succès');
    }

    /**
     * Supprimer une option
     */
    public function destroy(Option $option)
    {
        $option->delete();

        return redirect()
            ->route('options.index')
            ->with('success', 'Option supprimée avec succès');
    }
}
