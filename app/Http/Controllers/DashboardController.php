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
    // -------------------
// DA Dashboard
// -------------------
    public function da(Request $request)
    {
        $user = auth()->user();
        $etablissementId = $user->etablissement_id;

        // Départements de son établissement
        $departements = Departement::where('etablissement_id', $etablissementId)->get();
        
        // Query des lots avec filtres
        $query = LotCopie::with(['module.enseignant'])
            ->whereHas('module.enseignant', fn($q) => 
                $q->whereIn('departement_id', $departements->pluck('id'))
            );

        // Filtre par département
        if ($request->filled('departement_id')) {
            $query->whereHas('module.enseignant', fn($q) => 
                $q->where('departement_id', $request->departement_id)
            );
        }

        // Filtre par statut
        if ($request->filled('statut')) {
            $query = $this->applyStatutFilter($query, $request->statut);
        }

        $lotCopies = $query->get();
        $stats = $this->calculateStats($lotCopies);
        
        // Stats graphiques
        $departementsStats = $this->getDepartementsStats($lotCopies);
        $monthlyStats = $this->getMonthlyStats($lotCopies);
        $enseignantsStats = $this->getEnseignantsStats($lotCopies);

        // Enseignants de l'établissement
        $enseignants = User::where('type', 'Enseignant')
            ->whereIn('departement_id', $departements->pluck('id'))
            ->orderBy('nom_utilisateur')
            ->get();

        return view('dashboards.da', compact(
            'stats', 'lotCopies', 'departements', 'enseignants',
            'departementsStats', 'monthlyStats', 'enseignantsStats'
        ));
    }

    // -------------------
    // CS Dashboard
    // -------------------
    public function cs(Request $request)
    {
        $user = auth()->user();
        $etablissementId = $user->etablissement_id;

        $departements = Departement::where('etablissement_id', $etablissementId)->get();
        
        // Query des lots
        $query = LotCopie::with(['module.enseignant'])
            ->whereHas('module.enseignant', fn($q) => 
                $q->whereIn('departement_id', $departements->pluck('id'))
            );

        // Filtre par département
        if ($request->filled('departement_id')) {
            $query->whereHas('module.enseignant', fn($q) => 
                $q->where('departement_id', $request->departement_id)
            );
        }

        // Filtre par statut
        if ($request->filled('statut')) {
            $query = $this->applyStatutFilter($query, $request->statut);
        }

        $lotCopies = $query->get();
        $stats = $this->calculateStats($lotCopies);
        
        $departementsStats = $this->getDepartementsStats($lotCopies);
        $monthlyStats = $this->getMonthlyStats($lotCopies);
        $enseignantsStats = $this->getEnseignantsStats($lotCopies);

        $enseignants = User::where('type', 'Enseignant')
            ->whereIn('departement_id', $departements->pluck('id'))
            ->orderBy('nom_utilisateur')
            ->get();

        return view('dashboards.cs', compact(
            'stats', 'lotCopies', 'departements', 'enseignants',
            'departementsStats', 'monthlyStats', 'enseignantsStats'
        ));
    }

    // -------------------
    // CD Dashboard
    // -------------------
    public function cd(Request $request)
    {
        $user = auth()->user();
        $departementId = $user->departement_id;

        $departement = Departement::find($departementId);
        
        // Query des lots de son département uniquement
        $query = LotCopie::with(['module.enseignant'])
            ->whereHas('module.enseignant', fn($q) => 
                $q->where('departement_id', $departementId)
            );

        // Filtre par statut
        if ($request->filled('statut')) {
            $query = $this->applyStatutFilter($query, $request->statut);
        }

        // Filtre par enseignant
        if ($request->filled('enseignant_id')) {
            $query->whereHas('module', fn($q) => 
                $q->where('enseignant_id', $request->enseignant_id)
            );
        }

        $lotCopies = $query->get();
        $stats = $this->calculateStats($lotCopies);
        
        $monthlyStats = $this->getMonthlyStats($lotCopies);
        $enseignantsStats = $this->getEnseignantsStats($lotCopies);

        $enseignants = User::where('type', 'Enseignant')
            ->where('departement_id', $departementId)
            ->orderBy('nom_utilisateur')
            ->get();

        return view('dashboards.cd', compact(
            'stats', 'lotCopies', 'departement', 'enseignants',
            'monthlyStats', 'enseignantsStats'
        ));
    }

    // -------------------
    // Enseignant Dashboard
    // -------------------
    public function enseignant(Request $request)
    {
        $user = auth()->user();

        // Lots de l'enseignant via ses modules
        $query = LotCopie::with(['module'])
            ->whereHas('module', fn($q) => $q->where('enseignant_id', $user->id));

        // Filtre par module
        if ($request->filled('module_id')) {
            $query->where('module_id', $request->module_id);
        }

        // Filtre par statut
        if ($request->filled('statut')) {
            $query = $this->applyStatutFilter($query, $request->statut);
        }

        $lotCopies = $query->get();
        $stats = $this->calculateStats($lotCopies);
        
        $monthlyStats = $this->getMonthlyStats($lotCopies);
        
        // Ses modules
        $modules = \App\Models\Module::where('enseignant_id', $user->id)
            ->orderBy('nom')
            ->get();

        return view('dashboards.enseignant', compact(
            'stats', 'lotCopies', 'modules', 'monthlyStats'
        ));
    }

    // -------------------
    // Méthodes helper
    // -------------------
    private function applyStatutFilter($query, $statut)
    {
        switch($statut) {
            case 'disponible':
                return $query->whereNull('date_recuperation');
            case 'en_cours':
                return $query->whereNotNull('date_recuperation')->whereNull('date_remise');
            case 'termine':
                return $query->whereNotNull('date_remise');
            case 'retard':
                return $query->whereNotNull('date_remise')
                    ->whereRaw('date_remise > DATE_ADD(DATE_ADD(date_disponible, INTERVAL 2 DAY), INTERVAL 12 DAY)');
            default:
                return $query;
        }
    }

    private function calculateStats($lotCopies)
    {
        return [
            'total' => $lotCopies->count(),
            'total_copies' => $lotCopies->sum('nombre_copies'),
            'en_cours' => $lotCopies->whereNotNull('date_recuperation')->whereNull('date_remise')->count(),
            'copies_en_cours' => $lotCopies->whereNotNull('date_recuperation')->whereNull('date_remise')->sum('nombre_copies'),
            'valide' => $lotCopies->whereNotNull('date_remise')->count(),
            'copies_terminees' => $lotCopies->whereNotNull('date_remise')->sum('nombre_copies'),
            'retard' => $lotCopies->filter(function($lot) {
                $dateLimiteRecup = $lot->date_disponible ? $lot->date_disponible->copy()->addDays(2) : null;
                $dateLimiteRemise = $dateLimiteRecup ? $dateLimiteRecup->copy()->addDays(12) : null;
                return $lot->date_remise && $dateLimiteRemise && $lot->date_remise > $dateLimiteRemise;
            })->count(),
            'copies_retard' => $lotCopies->filter(function($lot) {
                $dateLimiteRecup = $lot->date_disponible ? $lot->date_disponible->copy()->addDays(2) : null;
                $dateLimiteRemise = $dateLimiteRecup ? $dateLimiteRecup->copy()->addDays(12) : null;
                return $lot->date_remise && $dateLimiteRemise && $lot->date_remise > $dateLimiteRemise;
            })->sum('nombre_copies'),
        ];
    }

    private function getEnseignantsStats($lotCopies)
    {
        return $lotCopies->groupBy(function($lot) {
            return $lot->module->enseignant_id ?? 0;
        })->map(function($lots) {
            $enseignant = $lots->first()->module->enseignant ?? null;
            if (!$enseignant) return null;
            
            return [
                'nom' => $enseignant->prenom_utilisateur . ' ' . $enseignant->nom_utilisateur,
                'total_copies' => $lots->sum('nombre_copies'),
            ];
        })->filter()->sortByDesc('total_copies')->values()->take(10);
    }

    private function getDepartementsStats($lotCopies)
    {
        return $lotCopies->groupBy(function($lot) {
            return $lot->module->enseignant->departement_id ?? 0;
        })->map(function($lots, $deptId) {
            if ($deptId == 0) return null;
            $dept = Departement::find($deptId);
            if (!$dept) return null;
            
            return [
                'nom' => $dept->sigle ?? $dept->nom,
                'total_copies' => $lots->sum('nombre_copies'),
            ];
        })->filter()->sortByDesc('total_copies')->values();
    }

    private function getMonthlyStats($lotCopies)
    {
        $stats = collect();
        for($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $lots = $lotCopies->filter(fn($lot) => $lot->created_at->format('Y-m') == $date->format('Y-m'));
            $stats->push(['mois' => $date->locale('fr')->isoFormat('MMM YY'), 'total' => $lots->count()]);
        }
        return $stats;
    }

    // -------------------
    // Président Dashboard
    // -------------------
    public function president(Request $request)
    {
        $query = LotCopie::with(['module.enseignant', 'module.semestre']);

        // Filtres
        if ($request->filled('enseignant_id')) {
            $query->whereHas('module', fn($q) => $q->where('enseignant_id', $request->enseignant_id));
        }

        if ($request->filled('etablissement_id')) {
            $query->whereHas('module.enseignant', fn($q) => 
                $q->where('etablissement_id', $request->etablissement_id)
            );
        }

        if ($request->filled('departement_id')) {
            $query->whereHas('module.enseignant', fn($q) => 
                $q->where('departement_id', $request->departement_id)
            );
        }

        if ($request->filled('semestre_id')) {
            $query->whereHas('module', fn($q) => $q->where('semestre_id', $request->semestre_id));
        }

        if ($request->filled('statut')) {
            switch($request->statut) {
                case 'disponible':
                    $query->whereNull('date_recuperation');
                    break;
                case 'en_cours':
                    $query->whereNotNull('date_recuperation')->whereNull('date_remise');
                    break;
                case 'termine':
                    $query->whereNotNull('date_remise');
                    break;
                case 'retard':
                    $query->whereNotNull('date_remise')
                        ->whereRaw('date_remise > DATE_ADD(DATE_ADD(date_disponible, INTERVAL 2 DAY), INTERVAL 12 DAY)');
                    break;
            }
        }

        $lotCopies = $query->get();

        // Stats
        $stats = [
            'total' => $lotCopies->count(),
            'total_copies' => $lotCopies->sum('nombre_copies'),
            'en_cours' => $lotCopies->whereNotNull('date_recuperation')->whereNull('date_remise')->count(),
            'copies_en_cours' => $lotCopies->whereNotNull('date_recuperation')->whereNull('date_remise')->sum('nombre_copies'),
            'valide' => $lotCopies->whereNotNull('date_remise')->count(),
            'copies_terminees' => $lotCopies->whereNotNull('date_remise')->sum('nombre_copies'),
            'retard' => $lotCopies->filter(function($lot) {
                $dateLimiteRecup = $lot->date_disponible ? $lot->date_disponible->copy()->addDays(2) : null;
                $dateLimiteRemise = $dateLimiteRecup ? $dateLimiteRecup->copy()->addDays(12) : null;
                return $lot->date_remise && $dateLimiteRemise && $lot->date_remise > $dateLimiteRemise;
            })->count(),
            'copies_retard' => $lotCopies->filter(function($lot) {
                $dateLimiteRecup = $lot->date_disponible ? $lot->date_disponible->copy()->addDays(2) : null;
                $dateLimiteRemise = $dateLimiteRecup ? $dateLimiteRecup->copy()->addDays(12) : null;
                return $lot->date_remise && $dateLimiteRemise && $lot->date_remise > $dateLimiteRemise;
            })->sum('nombre_copies'),
        ];

        // Enseignants pour le filtre
        $enseignants = User::where('type', 'Enseignant')
            ->orderBy('nom_utilisateur')
            ->orderBy('prenom_utilisateur')
            ->get();

        // Stats par enseignant
        $enseignantsStats = $lotCopies->groupBy(function($lot) {
            return $lot->module->enseignant_id ?? 0;
        })->map(function($lots) {
            $enseignant = $lots->first()->module->enseignant ?? null;
            if (!$enseignant) return null;
            
            return [
                'id' => $enseignant->id,
                'nom' => $enseignant->prenom_utilisateur . ' ' . $enseignant->nom_utilisateur,
                'total_copies' => $lots->sum('nombre_copies'),
            ];
        })->filter()->sortByDesc('total_copies')->values()->take(10);

        // Stats par département
        $departementsStats = $lotCopies->groupBy(function($lot) {
            return $lot->module->enseignant->departement_id ?? 0;
        })->map(function($lots, $deptId) {
            if ($deptId == 0) return null;
            $dept = Departement::find($deptId);
            if (!$dept) return null;
            
            return [
                'nom' => $dept->sigle ?? $dept->nom,
                'total_copies' => $lots->sum('nombre_copies'),
            ];
        })->filter()->sortByDesc('total_copies')->values();

        // Stats par année
        $anneesStats = $lotCopies->groupBy(function($lot) {
            $year = $lot->created_at->year;
            return $year . '/' . ($year + 1);
        })->map(function($lots, $annee) {
            return ['annee' => $annee, 'total' => $lots->count()];
        })->sortBy('annee')->values();

        // Stats mensuelles
        $monthlyStats = collect();
        for($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $lots = $lotCopies->filter(fn($lot) => $lot->created_at->format('Y-m') == $date->format('Y-m'));
            $monthlyStats->push(['mois' => $date->locale('fr')->isoFormat('MMM YY'), 'total' => $lots->count()]);
        }

        $chartData = [];

        return view('dashboards.president', compact(
            'stats', 'chartData', 'lotCopies', 'enseignants',
            'enseignantsStats', 'departementsStats', 'anneesStats', 'monthlyStats'
        ));
    }


    // -------------------
    // Admin Dashboard
    // -------------------
    public function admin(Request $request)
    {
        $query = LotCopie::with(['module.enseignant', 'module.semestre']);

        // Filtres
        if ($request->filled('enseignant_id')) {
            $query->whereHas('module', fn($q) => $q->where('enseignant_id', $request->enseignant_id));
        }

        if ($request->filled('etablissement_id')) {
            $query->whereHas('module.enseignant', fn($q) => 
                $q->where('etablissement_id', $request->etablissement_id)
            );
        }

        if ($request->filled('departement_id')) {
            $query->whereHas('module.enseignant', fn($q) => 
                $q->where('departement_id', $request->departement_id)
            );
        }

        if ($request->filled('semestre_id')) {
            $query->whereHas('module', fn($q) => $q->where('semestre_id', $request->semestre_id));
        }

        if ($request->filled('statut')) {
            switch($request->statut) {
                case 'disponible':
                    $query->whereNull('date_recuperation');
                    break;
                case 'en_cours':
                    $query->whereNotNull('date_recuperation')->whereNull('date_remise');
                    break;
                case 'termine':
                    $query->whereNotNull('date_remise');
                    break;
                case 'retard':
                    $query->whereNotNull('date_remise')
                        ->whereRaw('date_remise > DATE_ADD(DATE_ADD(date_disponible, INTERVAL 2 DAY), INTERVAL 12 DAY)');
                    break;
            }
        }

        $lotCopies = $query->get();

        // Stats
        $stats = [
            'total' => $lotCopies->count(),
            'total_copies' => $lotCopies->sum('nombre_copies'),
            'en_cours' => $lotCopies->whereNotNull('date_recuperation')->whereNull('date_remise')->count(),
            'copies_en_cours' => $lotCopies->whereNotNull('date_recuperation')->whereNull('date_remise')->sum('nombre_copies'),
            'valide' => $lotCopies->whereNotNull('date_remise')->count(),
            'copies_terminees' => $lotCopies->whereNotNull('date_remise')->sum('nombre_copies'),
            'retard' => $lotCopies->filter(function($lot) {
                $dateLimiteRecup = $lot->date_disponible ? $lot->date_disponible->copy()->addDays(2) : null;
                $dateLimiteRemise = $dateLimiteRecup ? $dateLimiteRecup->copy()->addDays(12) : null;
                return $lot->date_remise && $dateLimiteRemise && $lot->date_remise > $dateLimiteRemise;
            })->count(),
            'copies_retard' => $lotCopies->filter(function($lot) {
                $dateLimiteRecup = $lot->date_disponible ? $lot->date_disponible->copy()->addDays(2) : null;
                $dateLimiteRemise = $dateLimiteRecup ? $dateLimiteRecup->copy()->addDays(12) : null;
                return $lot->date_remise && $dateLimiteRemise && $lot->date_remise > $dateLimiteRemise;
            })->sum('nombre_copies'),
        ];

        // Enseignants pour le filtre
        $enseignants = User::where('type', 'Enseignant')
            ->orderBy('nom_utilisateur')
            ->orderBy('prenom_utilisateur')
            ->get();

        // Stats par enseignant
        $enseignantsStats = $lotCopies->groupBy(function($lot) {
            return $lot->module->enseignant_id ?? 0;
        })->map(function($lots) {
            $enseignant = $lots->first()->module->enseignant ?? null;
            if (!$enseignant) return null;
            
            return [
                'id' => $enseignant->id,
                'nom' => $enseignant->prenom_utilisateur . ' ' . $enseignant->nom_utilisateur,
                'total_copies' => $lots->sum('nombre_copies'),
            ];
        })->filter()->sortByDesc('total_copies')->values()->take(10);

        // Stats par département
        $departementsStats = $lotCopies->groupBy(function($lot) {
            return $lot->module->enseignant->departement_id ?? 0;
        })->map(function($lots, $deptId) {
            if ($deptId == 0) return null;
            $dept = Departement::find($deptId);
            if (!$dept) return null;
            
            return [
                'nom' => $dept->sigle ?? $dept->nom,
                'total_copies' => $lots->sum('nombre_copies'),
            ];
        })->filter()->sortByDesc('total_copies')->values();

        // Stats par année
        $anneesStats = $lotCopies->groupBy(function($lot) {
            $year = $lot->created_at->year;
            return $year . '/' . ($year + 1);
        })->map(function($lots, $annee) {
            return ['annee' => $annee, 'total' => $lots->count()];
        })->sortBy('annee')->values();

        // Stats mensuelles
        $monthlyStats = collect();
        for($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $lots = $lotCopies->filter(fn($lot) => $lot->created_at->format('Y-m') == $date->format('Y-m'));
            $monthlyStats->push(['mois' => $date->locale('fr')->isoFormat('MMM YY'), 'total' => $lots->count()]);
        }

        $chartData = [];

        return view('dashboards.admin', compact(
            'stats', 'chartData', 'lotCopies', 'enseignants',
            'enseignantsStats', 'departementsStats', 'anneesStats', 'monthlyStats'
        ));
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
