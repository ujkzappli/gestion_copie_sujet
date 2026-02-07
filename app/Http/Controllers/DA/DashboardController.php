<?php

namespace App\Http\Controllers\DA;

use App\Http\Controllers\Controller;
use App\Models\Departement;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Récupérer l'établissement de l'utilisateur connecté
        $etablissementId = $user->etablissement_id;

        // Départements de cet établissement
        $departements = Departement::where('etablissement_id', $etablissementId)->get();
        $departementsCount = $departements->count();

        // Tous les enseignants dans ces départements
        $enseignants = User::where('type', 'Enseignant')
            ->whereIn('departement_id', $departements->pluck('id'))
            ->get();

        $enseignantsCount = $enseignants->count();

        // CS dans cet établissement (un seul normalement)
        $cs = User::where('type', 'CS')
            ->where('etablissement_id', $etablissementId)
            ->first();
        $csCount = $cs ? 1 : 0;

        // CD dans ces départements
        $cd = User::where('type', 'CD')
            ->whereIn('departement_id', $departements->pluck('id'))
            ->get();
        $cdCount = $cd->count();

        return view('da.dashboard', compact(
            'departements',
            'departementsCount',
            'enseignants',
            'enseignantsCount',
            'cs',
            'csCount',
            'cd',
            'cdCount'
        ));
    }
}
