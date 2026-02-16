@extends('layouts.app')

@push('styles')
<style>
.page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 15px;
    padding: 25px;
    color: white;
    margin-bottom: 25px;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
}
.stats-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    border-left: 4px solid;
    transition: all 0.3s ease;
    height: 100%;
}
.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
}
.filter-card, .chart-card {
    background: white;
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
}
.section-title {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 2px solid #f1f3f5;
}
.section-title i {
    color: #667eea;
}
.select2-container--bootstrap-5 .select2-selection {
    min-height: 38px;
    border: 2px solid #e9ecef;
    border-radius: 8px;
}
.select2-container--bootstrap-5 .select2-selection:focus {
    border-color: #667eea;
}
</style>

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
@endpush

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="mb-1 fw-bold">
                    <i class="bi bi-graph-up-arrow me-2"></i>Dashboard {{ auth()->user()->type }}
                </h3>
                <small class="opacity-75">Vue d'ensemble complète et suivi détaillé des copies</small>
            </div>
            <div>
                <span class="badge bg-white text-primary px-3 py-2">
                    <i class="bi bi-calendar-check me-1"></i>{{ date('d/m/Y') }}
                </span>
            </div>
        </div>
    </div>

    {{-- ================= KPI Cards ================= --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stats-card" style="border-color: #667eea;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">TOTAL COPIES</p>
                        <h3 class="mb-0 fw-bold" style="color: #667eea;">{{ number_format($stats['total_copies'] ?? 0) }}</h3>
                        <small class="text-muted">{{ $stats['total'] ?? 0 }} lots</small>
                    </div>
                    <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                        <i class="bi bi-file-earmark-text-fill text-primary fs-2"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stats-card" style="border-color: #ffc107;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">EN COURS</p>
                        <h3 class="mb-0 fw-bold text-warning">{{ $stats['copies_en_cours'] ?? 0 }}</h3>
                        <small class="text-muted">{{ $stats['en_cours'] ?? 0 }} lots</small>
                    </div>
                    <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                        <i class="bi bi-hourglass-split text-warning fs-2"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stats-card" style="border-color: #28a745;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">TERMINÉES</p>
                        <h3 class="mb-0 fw-bold text-success">{{ $stats['copies_terminees'] ?? 0 }}</h3>
                        <small class="text-muted">{{ $stats['valide'] ?? 0 }} lots</small>
                    </div>
                    <div class="bg-success bg-opacity-10 rounded-circle p-3">
                        <i class="bi bi-check-circle-fill text-success fs-2"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stats-card" style="border-color: #dc3545;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">EN RETARD</p>
                        <h3 class="mb-0 fw-bold text-danger">{{ $stats['copies_retard'] ?? 0 }}</h3>
                        <small class="text-muted">{{ $stats['retard'] ?? 0 }} lots</small>
                    </div>
                    <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                        <i class="bi bi-exclamation-triangle-fill text-danger fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= Filtres Avancés ================= --}}
    <div class="filter-card mb-4">
        <div class="section-title">
            <i class="bi bi-funnel-fill"></i>
            <h6 class="mb-0 fw-bold">Filtres de recherche</h6>
        </div>
        
        <form id="filter-form" method="GET" action="{{ route('dashboard.president') }}">
            <div class="row g-3">
                
                {{-- Recherche Enseignant avec Select2 --}}
                <div class="col-lg-6">
                    <label class="form-label fw-semibold small">
                        <i class="bi bi-person-search me-1 text-primary"></i>Rechercher un enseignant
                    </label>
                    <select name="enseignant_id" id="enseignant_select" class="form-select">
                        <option value="">-- Tous les enseignants --</option>
                        @foreach($enseignants ?? [] as $ens)
                            <option value="{{ $ens->id }}" 
                                    @selected(request('enseignant_id') == $ens->id)
                                    data-matricule="{{ $ens->matricule_utilisateur }}">
                                {{ $ens->prenom_utilisateur }} {{ $ens->nom_utilisateur }} - {{ $ens->matricule_utilisateur }}
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted">
                        <i class="bi bi-info-circle"></i> Tapez pour rechercher par nom, prénom ou matricule
                    </small>
                </div>

                {{-- Établissement --}}
                <div class="col-lg-3 col-md-6">
                    <label class="form-label fw-semibold small">
                        <i class="bi bi-building me-1 text-primary"></i>Établissement
                    </label>
                    <select name="etablissement_id" id="etablissement" class="form-select">
                        <option value="">Tous les établissements</option>
                        @foreach(\App\Models\Etablissement::orderBy('sigle')->get() as $etab)
                            <option value="{{ $etab->id }}" @selected(request('etablissement_id')==$etab->id)>
                                {{ $etab->sigle }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Département --}}
                <div class="col-lg-3 col-md-6">
                    <label class="form-label fw-semibold small">
                        <i class="bi bi-diagram-3 me-1 text-primary"></i>Département
                    </label>
                    <select name="departement_id" id="departement" class="form-select">
                        <option value="">Tous les départements</option>
                        @foreach(\App\Models\Departement::orderBy('sigle')->get() as $dep)
                            <option value="{{ $dep->id }}" 
                                    data-etablissement="{{ $dep->etablissement_id }}"
                                    @selected(request('departement_id')==$dep->id)>
                                {{ $dep->sigle }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Année académique --}}
                <div class="col-lg-3 col-md-6">
                    <label class="form-label fw-semibold small">
                        <i class="bi bi-calendar3 me-1 text-primary"></i>Année académique
                    </label>
                    <select name="annee_academique" class="form-select">
                        <option value="">Toutes les années</option>
                        @foreach(['2021/2022', '2022/2023', '2023/2024','2024/2025', '2025/2026'] as $annee)
                            <option value="{{ $annee }}" @selected(request('annee_academique')==$annee)>
                                {{ $annee }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Semestre --}}
                <div class="col-lg-3 col-md-6">
                    <label class="form-label fw-semibold small">
                        <i class="bi bi-bookmark-fill me-1 text-primary"></i>Semestre
                    </label>
                    <select name="semestre_id" class="form-select">
                        <option value="">Tous les semestres</option>
                        @foreach(\App\Models\Semestre::orderBy('code')->get() as $sem)
                            <option value="{{ $sem->id }}" @selected(request('semestre_id')==$sem->id)>
                                {{ $sem->code }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Statut --}}
                <div class="col-lg-3 col-md-6">
                    <label class="form-label fw-semibold small">
                        <i class="bi bi-filter me-1 text-primary"></i>Statut
                    </label>
                    <select name="statut" class="form-select">
                        <option value="">Tous les statuts</option>
                        <option value="disponible" @selected(request('statut')=='disponible')>📥 Disponible</option>
                        <option value="en_cours" @selected(request('statut')=='en_cours')>⏳ En cours</option>
                        <option value="termine" @selected(request('statut')=='termine')>✅ Terminé</option>
                        <option value="retard" @selected(request('statut')=='retard')>⚠️ En retard</option>
                    </select>
                </div>

                {{-- Boutons --}}
                <div class="col-lg-3 col-md-6">
                    <label class="form-label fw-semibold small d-block">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary flex-grow-1" type="submit">
                            <i class="bi bi-search me-1"></i>Filtrer
                        </button>
                        <a href="{{ route('dashboard.president') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle"></i>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- ================= Graphiques ================= --}}
    <div class="row g-3 mb-4">
        
        {{-- Répartition par statut --}}
        <div class="col-lg-4">
            <div class="chart-card">
                <div class="section-title">
                    <i class="bi bi-pie-chart-fill"></i>
                    <h6 class="mb-0 fw-bold">Répartition par statut</h6>
                </div>
                <div id="statutDonutChart"></div>
            </div>
        </div>

        {{-- Top enseignants --}}
        <div class="col-lg-8">
            <div class="chart-card">
                <div class="section-title">
                    <i class="bi bi-bar-chart-fill"></i>
                    <h6 class="mb-0 fw-bold">Top 10 enseignants (nombre de copies)</h6>
                </div>
                <div id="enseignantBarChart"></div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        
        {{-- Évolution par année --}}
        <div class="col-lg-8">
            <div class="chart-card">
                <div class="section-title">
                    <i class="bi bi-graph-up"></i>
                    <h6 class="mb-0 fw-bold">Évolution par année académique</h6>
                </div>
                <div id="anneeLineChart"></div>
            </div>
        </div>

        {{-- Taux de complétion --}}
        <div class="col-lg-4">
            <div class="chart-card">
                <div class="section-title">
                    <i class="bi bi-speedometer2"></i>
                    <h6 class="mb-0 fw-bold">Taux de complétion</h6>
                </div>
                <div id="completionRadialChart"></div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        
        {{-- Par département --}}
        <div class="col-lg-6">
            <div class="chart-card">
                <div class="section-title">
                    <i class="bi bi-diagram-3-fill"></i>
                    <h6 class="mb-0 fw-bold">Copies par département</h6>
                </div>
                <div id="departementBarChart"></div>
            </div>
        </div>

        {{-- Progression mensuelle --}}
        <div class="col-lg-6">
            <div class="chart-card">
                <div class="section-title">
                    <i class="bi bi-calendar3"></i>
                    <h6 class="mb-0 fw-bold">Progression mensuelle (12 derniers mois)</h6>
                </div>
                <div id="monthlyLineChart"></div>
            </div>
        </div>
    </div>

    {{-- ================= Détails Enseignant ================= --}}
    @if(request('enseignant_id') && isset($enseignants))
        @php
            $enseignantSelectionne = $enseignants->find(request('enseignant_id'));
            $lotsEnseignant = $lotCopies->filter(fn($l) => $l->module && $l->module->enseignant_id == request('enseignant_id'));
        @endphp
        
        @if($enseignantSelectionne && $lotsEnseignant->count() > 0)
        <div class="filter-card">
            <div class="section-title">
                <i class="bi bi-person-badge"></i>
                <h6 class="mb-0 fw-bold">
                    Détails - {{ $enseignantSelectionne->prenom_utilisateur }} {{ $enseignantSelectionne->nom_utilisateur }}
                </h6>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-3">
                    <div class="stats-card" style="border-color: #17a2b8;">
                        <p class="text-muted mb-1 small">Lots assignés</p>
                        <h4 class="mb-0 fw-bold text-info">{{ $lotsEnseignant->count() }}</h4>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card" style="border-color: #667eea;">
                        <p class="text-muted mb-1 small">Total copies</p>
                        <h4 class="mb-0 fw-bold" style="color: #667eea;">{{ $lotsEnseignant->sum('nombre_copies') }}</h4>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card" style="border-color: #28a745;">
                        <p class="text-muted mb-1 small">Copies rendues</p>
                        <h4 class="mb-0 fw-bold text-success">{{ $lotsEnseignant->whereNotNull('date_remise')->sum('nombre_copies') }}</h4>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card" style="border-color: #dc3545;">
                        <p class="text-muted mb-1 small">Lots en retard</p>
                        <h4 class="mb-0 fw-bold text-danger">
                            {{ $lotsEnseignant->filter(function($lot) {
                                $dateLimiteRecup = $lot->date_disponible ? $lot->date_disponible->copy()->addDays(2) : null;
                                $dateLimiteRemise = $dateLimiteRecup ? $dateLimiteRecup->copy()->addDays(12) : null;
                                return $lot->date_remise && $dateLimiteRemise && $lot->date_remise > $dateLimiteRemise;
                            })->count() }}
                        </h4>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-sm">
                    <thead class="table-light">
                        <tr>
                            <th>Module</th>
                            <th>Copies</th>
                            <th>Date disponible</th>
                            <th>Date remise</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lotsEnseignant as $lot)
                            @php
                                $dateLimiteRecup = $lot->date_disponible ? $lot->date_disponible->copy()->addDays(2) : null;
                                $dateLimiteRemise = $dateLimiteRecup ? $dateLimiteRecup->copy()->addDays(12) : null;
                                $isRetard = $lot->date_remise && $dateLimiteRemise && $lot->date_remise > $dateLimiteRemise;
                                
                                if($lot->date_remise) {
                                    $statut = $isRetard ? 'En retard' : 'Terminé';
                                    $badgeClass = $isRetard ? 'bg-danger' : 'bg-success';
                                } elseif($lot->date_recuperation) {
                                    $statut = 'En cours';
                                    $badgeClass = 'bg-warning';
                                } else {
                                    $statut = 'Disponible';
                                    $badgeClass = 'bg-info';
                                }
                            @endphp
                            <tr>
                                <td><strong>{{ $lot->module->nom ?? 'N/A' }}</strong></td>
                                <td><span class="badge bg-secondary">{{ $lot->nombre_copies }}</span></td>
                                <td><small>{{ $lot->date_disponible?->format('d/m/Y') }}</small></td>
                                <td><small>{{ $lot->date_remise?->format('d/m/Y') ?? '-' }}</small></td>
                                <td><span class="badge {{ $badgeClass }}">{{ $statut }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    @endif

</div>
@endsection

@section('scripts')
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    
    // ================= Select2 pour recherche enseignant =================
    $('#enseignant_select').select2({
        theme: 'bootstrap-5',
        placeholder: '-- Rechercher un enseignant --',
        allowClear: true,
        language: {
            noResults: () => "Aucun enseignant trouvé",
            searching: () => "Recherche...",
        },
        matcher: function(params, data) {
            if ($.trim(params.term) === '') return data;
            if (typeof data.text === 'undefined') return null;
            
            const term = params.term.toLowerCase();
            const text = data.text.toLowerCase();
            const matricule = $(data.element).data('matricule');
            
            if (text.indexOf(term) > -1 || 
                (matricule && matricule.toString().toLowerCase().indexOf(term) > -1)) {
                return data;
            }
            return null;
        }
    });

    // ================= Filtrage département par établissement =================
    $('#etablissement').on('change', function() {
        const etablissementId = $(this).val();
        const departementSelect = $('#departement');
        
        departementSelect.find('option').each(function() {
            if ($(this).val() === '') {
                $(this).show();
                return;
            }
            
            if (!etablissementId || $(this).data('etablissement') == etablissementId) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
        
        departementSelect.val('');
    });

    // ================= Graphiques =================
    const stats = @json($stats ?? []);
    const enseignantsStats = @json($enseignantsStats ?? []);
    const departementsStats = @json($departementsStats ?? []);
    const anneesStats = @json($anneesStats ?? []);
    const monthlyStats = @json($monthlyStats ?? []);

    // 1. Donut - Statut
    new ApexCharts(document.querySelector("#statutDonutChart"), {
        chart: { type: 'donut', height: 300 },
        series: [stats.en_cours || 0, stats.valide || 0, stats.retard || 0],
        labels: ['En cours', 'Terminés', 'En retard'],
        colors: ['#FFC107', '#28A745', '#DC3545'],
        legend: { position: 'bottom' },
        plotOptions: { pie: { donut: { size: '65%' } } }
    }).render();

    // 2. Bar - Enseignants
    const ensLabels = enseignantsStats.slice(0, 10).map(e => e.nom || 'N/A');
    const ensCopies = enseignantsStats.slice(0, 10).map(e => parseInt(e.total_copies) || 0);
    
    new ApexCharts(document.querySelector("#enseignantBarChart"), {
        chart: { type: 'bar', height: 320 },
        series: [{ name: 'Copies', data: ensCopies }],
        xaxis: { categories: ensLabels, labels: { rotate: -45, style: { fontSize: '11px' } } },
        colors: ['#667eea'],
        plotOptions: { bar: { borderRadius: 6 } },
        dataLabels: { enabled: true }
    }).render();

    // 3. Line - Années
    const anneeLabels = anneesStats.map(a => a.annee || 'N/A');
    const anneeTotals = anneesStats.map(a => parseInt(a.total) || 0);
    
    new ApexCharts(document.querySelector("#anneeLineChart"), {
        chart: { type: 'line', height: 320 },
        series: [{ name: 'Lots', data: anneeTotals }],
        xaxis: { categories: anneeLabels },
        stroke: { curve: 'smooth', width: 3 },
        colors: ['#17A2B8']
    }).render();

    // 4. Radial - Complétion
    const completionRate = Math.round(((stats.valide || 0) / (stats.total || 1)) * 100);
    
    new ApexCharts(document.querySelector("#completionRadialChart"), {
        chart: { type: 'radialBar', height: 300 },
        series: [completionRate],
        colors: ['#28A745'],
        labels: ['Complété'],
        plotOptions: {
            radialBar: {
                dataLabels: {
                    value: { fontSize: '30px', formatter: val => val + '%' }
                }
            }
        }
    }).render();

    // 5. Bar - Départements
    const deptLabels = departementsStats.map(d => d.nom || 'N/A');
    const deptCopies = departementsStats.map(d => parseInt(d.total_copies) || 0);
    
    new ApexCharts(document.querySelector("#departementBarChart"), {
        chart: { type: 'bar', height: 300 },
        series: [{ name: 'Copies', data: deptCopies }],
        xaxis: { categories: deptLabels, labels: { rotate: -45 } },
        colors: ['#764ba2']
    }).render();

    // 6. Area - Mensuel
    const monthLabels = monthlyStats.map(m => m.mois || 'N/A');
    const monthTotals = monthlyStats.map(m => parseInt(m.total) || 0);
    
    new ApexCharts(document.querySelector("#monthlyLineChart"), {
        chart: { type: 'area', height: 300 },
        series: [{ name: 'Lots', data: monthTotals }],
        xaxis: { categories: monthLabels },
        colors: ['#667eea'],
        fill: { type: 'gradient' }
    }).render();

});
</script>
@endsection