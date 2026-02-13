<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LotCopie;
use App\Models\Departement;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Redirection selon le rôle
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        return match ($user->type) {
            'DA'         => redirect()->route('dashboard.da'),
            'CD'         => redirect()->route('dashboard.cd'),
            'CS'         => redirect()->route('dashboard.cs'),
            'Enseignant' => redirect()->route('dashboard.enseignant'),
            'President'  => redirect()->route('dashboard.president'),
            'Admin'      => redirect()->route('dashboard.admin'),
            default      => redirect()->route('login')
                                ->with('error', "Type d'utilisateur inconnu !"),
        };
    }

    // -------------------
    // DA Dashboard
    // -------------------
    public function da()
    {
        $user = auth()->user();
        $etablissementId = $user->etablissement_id;

        $departements = Departement::where('etablissement_id', $etablissementId)->get();
        $departementsCount = $departements->count();

        $enseignants = User::where('type', 'Enseignant')
            ->whereIn('departement_id', $departements->pluck('id'))
            ->get();
        $enseignantsCount = $enseignants->count();

        $cs = User::where('type', 'CS')
            ->where('etablissement_id', $etablissementId)
            ->first();
        $csCount = $cs ? 1 : 0;

        $cd = User::where('type', 'CD')
            ->whereIn('departement_id', $departements->pluck('id'))
            ->get();
        $cdCount = $cd->count();

        return view('dashboards.da', compact(
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

    // -------------------
    // CD Dashboard
    // -------------------
    public function cd()
    {
        $user = auth()->user();

        $departements = Departement::where('id', $user->departement_id)->get();
        $departementsCount = $departements->count();

        $enseignants = User::where('type', 'Enseignant')
            ->where('departement_id', $user->departement_id)
            ->get();
        $enseignantsCount = $enseignants->count();

        return view('dashboards.cd', compact(
            'departements',
            'departementsCount',
            'enseignants',
            'enseignantsCount'
        ));
    }

    // -------------------
    // CS Dashboard
    // -------------------
    public function cs()
    {
        $user = auth()->user();
        $etablissementId = $user->etablissement_id;

        $departements = Departement::where('etablissement_id', $etablissementId)->get();
        $departementsCount = $departements->count();

        $enseignantsCount = User::where('type', 'Enseignant')
            ->whereIn('departement_id', $departements->pluck('id'))
            ->count();

        $cdCount = User::where('type', 'CD')
            ->whereIn('departement_id', $departements->pluck('id'))
            ->count();

        return view('dashboards.cs', compact(
            'departementsCount',
            'enseignantsCount',
            'cdCount'
        ));
    }

    // -------------------
    // Enseignant Dashboard
    // -------------------
    public function enseignant()
    {
        $user = auth()->user();

        $query = LotCopie::where('utilisateur_id', $user->id);
        $stats = $this->getStatsLots($query);
        $chart = $this->getChartLots($query, 'month');

        return view('dashboards.enseignant', compact('stats', 'chart'));
    }

    // -------------------
    // Président Dashboard
    // -------------------
    public function president(Request $request)
    {
        $query = LotCopie::query();

        // Filtrer selon établissement
        if ($request->filled('etablissement_id')) {
            $query->whereHas('module.enseignant.etablissement', function($q) use ($request) {
                $q->where('id', $request->etablissement_id);
            });
        }

        // Filtrer selon département
        if ($request->filled('departement_id')) {
            $query->whereHas('module.enseignant.departement', function($q) use ($request) {
                $q->where('id', $request->departement_id);
            });
        }

        // Filtrer selon option (via session examens)
        if ($request->filled('option_id')) {
            $query->whereHas('module.semestre.options', function($q) use ($request) {
                $q->where('id', $request->option_id);
            });
        }

        // Filtrer selon session examen
        if ($request->filled('session_id')) {
            $query->whereHas('module.semestre.sessionExamens', function($q) use ($request) {
                $q->where('id', $request->session_id);
            });
        }

        // Ajouter filtres classiques (année, semestre, période, etc.) ici

        $stats = $this->getStatsLots($query);
        $chartData = $this->getChartLots($query, $request->period ?? 'month');

        $etablissements = \App\Models\Etablissement::all();

        return view('dashboards.president', compact('stats', 'chartData', 'etablissements'));
    }


    // -------------------
    // Admin Dashboard
    // -------------------
    public function admin()
    {
        $query = LotCopie::query();
        $stats = $this->getStatsLots($query);
        $chart = $this->getChartLots($query, 'month');

        return view('dashboards.admin', compact('stats', 'chart'));
    }

    // -------------------
    // Méthodes internes pour Lots
    // -------------------
    private function getStatsLots($query)
    {
        $lots = $query->get();

        return [
            'en_cours' => $lots->filter(fn ($l) => $l->statut_calcule === 'En cours')->count(),
            'valide'   => $lots->filter(fn ($l) => $l->statut_calcule === 'Validé')->count(),
            'retard'   => $lots->filter(fn ($l) => $l->statut_calcule === 'En retard')->count(),
            'total'    => $lots->count(),
        ];
    }

    private function getChartLots($query, string $period)
    {
        $chartQuery = clone $query;

        match ($period) {
            'today' => $chartQuery->whereDate('created_at', today()),
            'week'  => $chartQuery->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]),
            'month' => $chartQuery->whereMonth('created_at', now()->month),
            'year'  => $chartQuery->whereYear('created_at', now()->year),
            default => null,
        };

        return $chartQuery
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }
}
