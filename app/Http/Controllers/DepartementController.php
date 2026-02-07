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
        $user = auth()->user();

        if (in_array($user->type, ['Admin', 'President'])) {
            $departements = Departement::with('etablissement')->get();
            $etablissements = Etablissement::all();
        } elseif (in_array($user->type, ['DA', 'CS'])) {
            $departements = Departement::where('etablissement_id', $user->etablissement_id)
                ->with('etablissement')
                ->get();

            $etablissements = Etablissement::where('id', $user->etablissement_id)->get();
        } else {
            $departements = collect();
            $etablissements = collect();
        }

        return view('departements.index', compact('departements', 'etablissements'));
    }

    /**
     * Formulaire de création
     */
    public function create()
    {
        if (!in_array(auth()->user()->type, ['Admin', 'President'])) {
            abort(403, 'Accès interdit');
        }

        $etablissements = Etablissement::orderBy('libelle')->get();

        return view('departements.create', compact('etablissements'));
    }

    /**
     * Enregistrer un département
     */
    public function store(Request $request)
    {
        if (!in_array(auth()->user()->type, ['Admin', 'President'])) {
            abort(403);
        }

        $request->validate([
            'code'             => 'required|string|max:50|unique:departements,code',
            'libelle'          => 'required|string|max:255',
            'sigle'            => 'required|string|max:50',
            'etablissement_id' => 'required|exists:etablissements,id',
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
        $user = auth()->user();

        if (
            in_array($user->type, ['DA', 'CS']) &&
            $departement->etablissement_id !== $user->etablissement_id
        ) {
            abort(403);
        }

        $departement->load('etablissement');

        return view('departements.show', compact('departement'));
    }

    /**
     * Formulaire d’édition
     */
    public function edit(Departement $departement)
    {
        if (!in_array(auth()->user()->type, ['Admin', 'President'])) {
            abort(403);
        }

        $etablissements = Etablissement::orderBy('libelle')->get();

        return view('departements.edit', compact('departement', 'etablissements'));
    }

    /**
     * Mettre à jour un département
     */
    public function update(Request $request, Departement $departement)
    {
        if (!in_array(auth()->user()->type, ['Admin', 'President'])) {
            abort(403);
        }

        $request->validate([
            'code'             => 'required|string|max:55|unique:departements,code,' . $departement->id,
            'libelle'          => 'required|string|max:255',
            'sigle'            => 'required|string|max:50',
            'etablissement_id' => 'required|exists:etablissements,id',
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
        if (!in_array(auth()->user()->type, ['Admin', 'President'])) {
            abort(403);
        }

        $departement->delete();

        return redirect()
            ->route('departements.index')
            ->with('success', 'Département supprimé avec succès');
    }
}
