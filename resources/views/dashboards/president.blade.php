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
.filter-card {
    background: white;
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    margin-bottom: 20px;
}
.chart-card {
    background: white;
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    height: 100%;
}
.enseignant-card {
    background: white;
    border-radius: 12px;
    padding: 15px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
    cursor: pointer;
}
.enseignant-card:hover {
    border-color: #667eea;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
}
.enseignant-card.selected {
    border-color: #667eea;
    background: #f8f9ff;
}
.badge-modern {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
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
    font-size: 1.3rem;
}
</style>
@endpush

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="mb-1 fw-bold">
                    <i class="bi bi-graph-up-arrow me-2"></i>Dashboard Superviseur
                </h3>
                <small class="opacity-75">Vue d'ensemble complète et suivi détaillé</small>
            </div>
            <div>
                <span class="badge bg-white text-primary fs-6 px-3 py-2">
                    <i class="bi bi-calendar-check me-1"></i>{{ date('d/m/Y') }}
                </span>
            </div>
        </div>
    </div>

    {{-- ================= KPI Cards Principales ================= --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stats-card" style="border-color: #667eea;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">TOTAL COPIES</p>
                        <h3 class="mb-0 fw-bold" style="color: #667eea;">{{ $stats['total_copies'] ?? 0 }}</h3>
                        <small class="text-muted">Dans {{ $stats['total'] ?? 0 }} lots</small>
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
                        <h3 class="mb-0 fw-bold text-warning">{{ $stats['en_cours'] ?? 0 }}</h3>
                        <small class="text-muted">{{ $stats['copies_en_cours'] ?? 0 }} copies</small>
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
                        <p class="text-muted mb-1 small">TERMINÉS</p>
                        <h3 class="mb-0 fw-bold text-success">{{ $stats['valide'] ?? 0 }}</h3>
                        <small class="text-muted">{{ $stats['copies_terminees'] ?? 0 }} copies</small>
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
                        <h3 class="mb-0 fw-bold text-danger">{{ $stats['retard'] ?? 0 }}</h3>
                        <small class="text-muted">{{ $stats['copies_retard'] ?? 0 }} copies</small>
                    </div>
                    <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                        <i class="bi bi-exclamation-triangle-fill text-danger fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= Filtres Avancés ================= --}}
    <div class="filter-card">
        <div class="section-title">
            <i class="bi bi-funnel-fill"></i>
            <h6 class="mb-0 fw-bold">Filtres avancés</h6>
        </div>
        
        <form id="filter-form" method="GET">
            <div class="row g-3">
                {{-- Recherche Enseignant --}}
                <div class="col-lg-4 col-md-6">
                    <label class="form-label fw-semibold small">
                        <i class="bi bi-person-search me-1 text-primary"></i>Rechercher un enseignant
                    </label>
                    <select name="enseignant_id" id="enseignant_id" class="form-select">
                        <option value="">-- Tous les enseignants --</option>
                        @foreach($enseignants ?? [] as $ens)
                            <option value="{{ $ens->id }}" @selected(request('enseignant_id') == $ens->id)>
                                {{ $ens->prenom_utilisateur }} {{ $ens->nom_utilisateur }} ({{ $ens->matricule_utilisateur }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Établissement --}}
                <div class="col-lg-4 col-md-6">
                    <label class="form-label fw-semibold small">
                        <i class="bi bi-building me-1 text-primary"></i>Établissement
                    </label>
                    <select name="etablissement_id" id="etablissement" class="form-select">
                        <option value="">Tous les établissements</option>
                        @foreach(App\Models\Etablissement::all() as $etab)
                            <option value="{{ $etab->id }}" @selected(request('etablissement_id')==$etab->id)>
                                {{ $etab->sigle }} - {{ $etab->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Département --}}
                <div class="col-lg-4 col-md-6">
                    <label class="form-label fw-semibold small">
                        <i class="bi bi-diagram-3 me-1 text-primary"></i>Département
                    </label>
                    <select name="departement_id" id="departement" class="form-select">
                        <option value="">Tous les départements</option>
                        @if(request('etablissement_id'))
                            @foreach(App\Models\Departement::where('etablissement_id', request('etablissement_id'))->get() as $dep)
                                <option value="{{ $dep->id }}" @selected(request('departement_id')==$dep->id)>
                                    {{ $dep->sigle }} - {{ $dep->nom }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>

                {{-- Année académique --}}
                <div class="col-lg-3 col-md-6">
                    <label class="form-label fw-semibold small">
                        <i class="bi bi-calendar3 me-1 text-primary"></i>Année académique
                    </label>
                    <select name="annee_academique" class="form-select">
                        <option value="">Toutes les années</option>
                        @foreach(['2022/2023', '2023/2024','2024/2025', '2025/2026'] as $annee)
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
                        @foreach(App\Models\Semestre::all() as $sem)
                            <option value="{{ $sem->id }}" @selected(request('semestre_id')==$sem->id)>
                                {{ $sem->libelle }}
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
                        <option value="disponible" @selected(request('statut')=='disponible')>Disponible</option>
                        <option value="en_cours" @selected(request('statut')=='en_cours')>En cours</option>
                        <option value="termine" @selected(request('statut')=='termine')>Terminé</option>
                        <option value="retard" @selected(request('statut')=='retard')>En retard</option>
                    </select>
                </div>

                {{-- Boutons --}}
                <div class="col-lg-3 col-md-6 d-flex align-items-end">
                    <div class="d-flex gap-2 w-100">
                        <button class="btn btn-primary flex-grow-1" type="submit">
                            <i class="bi bi-search me-1"></i>Filtrer
                        </button>
                        <a href="{{ url()->current() }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle"></i>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- ================= Graphiques Row 1 ================= --}}
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

        {{-- Copies par enseignant (Top 10) --}}
        <div class="col-lg-8">
            <div class="chart-card">
                <div class="section-title">
                    <i class="bi bi-bar-chart-fill"></i>
                    <h6 class="mb-0 fw-bold">Top 10 enseignants (par nombre de copies)</h6>
                </div>
                <div id="enseignantBarChart"></div>
            </div>
        </div>
    </div>

    {{-- ================= Graphiques Row 2 ================= --}}
    <div class="row g-3 mb-4">
        {{-- Évolution par année académique --}}
        <div class="col-lg-8">
            <div class="chart-card">
                <div class="section-title">
                    <i class="bi bi-graph-up"></i>
                    <h6 class="mb-0 fw-bold">Évolution des lots par année académique</h6>
                </div>
                <div id="anneeLineChart"></div>
            </div>
        </div>

        {{-- Taux de complétion --}}
        <div class="col-lg-4">
            <div class="chart-card">
                <div class="section-title">
                    <i class="bi bi-speedometer2"></i>
                    <h6 class="mb-0 fw-bold">Taux de complétion global</h6>
                </div>
                <div id="completionRadialChart"></div>
            </div>
        </div>
    </div>

    {{-- ================= Graphiques Row 3 ================= --}}
    <div class="row g-3 mb-4">
        {{-- Copies par département --}}
        <div class="col-lg-6">
            <div class="chart-card">
                <div class="section-title">
                    <i class="bi bi-diagram-3-fill"></i>
                    <h6 class="mb-0 fw-bold">Répartition par département</h6>
                </div>
                <div id="departementBarChart"></div>
            </div>
        </div>

        {{-- Progression mensuelle --}}
        <div class="col-lg-6">
            <div class="chart-card">
                <div class="section-title">
                    <i class="bi bi-calendar3"></i>
                    <h6 class="mb-0 fw-bold">Progression mensuelle</h6>
                </div>
                <div id="monthlyLineChart"></div>
            </div>
        </div>
    </div>

    {{-- ================= Détails Enseignant Sélectionné ================= --}}
    @if(request('enseignant_id'))
        @php
            $enseignantSelectionne = $enseignants->find(request('enseignant_id'));
            $lotsEnseignant = $lotCopies->where('module.enseignant_id', request('enseignant_id'));
        @endphp
        
        @if($enseignantSelectionne)
        <div class="filter-card">
            <div class="section-title">
                <i class="bi bi-person-badge"></i>
                <h6 class="mb-0 fw-bold">Détails - {{ $enseignantSelectionne->prenom_utilisateur }} {{ $enseignantSelectionne->nom_utilisateur }}</h6>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-3">
                    <div class="stats-card" style="border-color: #17a2b8;">
                        <p class="text-muted mb-1 small">Total lots</p>
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
                        <p class="text-muted mb-1 small">En retard</p>
                        <h4 class="mb-0 fw-bold text-danger">
                            {{ $lotsEnseignant->filter(function($lot) {
                                $dateLimiteRemise = $lot->date_disponible ? $lot->date_disponible->copy()->addDays(14) : null;
                                return $lot->date_remise && $dateLimiteRemise && $lot->date_remise > $dateLimiteRemise;
                            })->count() }}
                        </h4>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Module</th>
                            <th>Copies</th>
                            <th>Date dispo</th>
                            <th>Date remise</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lotsEnseignant as $lot)
                            @php
                                $dateLimiteRemise = $lot->date_disponible ? $lot->date_disponible->copy()->addDays(14) : null;
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
                                <td>{{ $lot->date_disponible?->format('d/m/Y') }}</td>
                                <td>{{ $lot->date_remise?->format('d/m/Y') ?? '-' }}</td>
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
<script>
document.addEventListener('DOMContentLoaded', function () {
    
    const stats = @json($stats ?? []);
    const chartData = @json($chartData ?? []);
    const enseignantsData = @json($enseignantsStats ?? []);
    const departementsData = @json($departementsStats ?? []);
    const anneesData = @json($anneesStats ?? []);
    const monthlyData = @json($monthlyStats ?? []);

    // ================= 1. Donut Chart - Répartition par statut =================
    var donutOptions = {
        chart: { type: 'donut', height: 300, fontFamily: 'inherit' },
        series: [stats.en_cours || 0, stats.valide || 0, stats.retard || 0],
        labels: ['En cours', 'Terminés', 'En retard'],
        colors: ['#FFC107', '#28A745', '#DC3545'],
        legend: { position: 'bottom', fontSize: '13px' },
        plotOptions: {
            pie: {
                donut: {
                    size: '65%',
                    labels: {
                        show: true,
                        total: {
                            show: true,
                            label: 'Total',
                            fontSize: '14px',
                            fontWeight: 600
                        }
                    }
                }
            }
        },
        dataLabels: { enabled: true, style: { fontSize: '13px', fontWeight: 'bold' } }
    };
    new ApexCharts(document.querySelector("#statutDonutChart"), donutOptions).render();

    // ================= 2. Bar Chart - Top 10 Enseignants =================
    const ensLabels = enseignantsData.slice(0, 10).map(e => e.nom || 'N/A');
    const ensCopies = enseignantsData.slice(0, 10).map(e => parseInt(e.total_copies) || 0);
    
    var ensBarOptions = {
        chart: { type: 'bar', height: 350, fontFamily: 'inherit', toolbar: { show: true } },
        series: [{ name: 'Copies', data: ensCopies }],
        xaxis: { categories: ensLabels, labels: { rotate: -45, style: { fontSize: '11px' } } },
        colors: ['#667eea'],
        plotOptions: { bar: { borderRadius: 6, columnWidth: '65%', dataLabels: { position: 'top' } } },
        dataLabels: { enabled: true, offsetY: -20, style: { fontSize: '11px', fontWeight: 600 } },
        tooltip: { y: { formatter: val => val + " copies" } }
    };
    new ApexCharts(document.querySelector("#enseignantBarChart"), ensBarOptions).render();

    // ================= 3. Line Chart - Évolution par année académique =================
    const anneeLabels = anneesData.map(a => a.annee || 'N/A');
    const anneeTotals = anneesData.map(a => parseInt(a.total) || 0);
    
    var anneeLineOptions = {
        chart: { type: 'line', height: 350, fontFamily: 'inherit', toolbar: { show: true } },
        series: [{ name: 'Lots', data: anneeTotals }],
        xaxis: { categories: anneeLabels },
        stroke: { curve: 'smooth', width: 3 },
        markers: { size: 6, colors: '#17A2B8', hover: { size: 8 } },
        colors: ['#17A2B8'],
        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.1 } }
    };
    new ApexCharts(document.querySelector("#anneeLineChart"), anneeLineOptions).render();

    // ================= 4. Radial Chart - Taux de complétion =================
    const total = stats.total || 1;
    const valide = stats.valide || 0;
    const completionRate = Math.round((valide / total) * 100);
    
    var radialOptions = {
        chart: { type: 'radialBar', height: 300, fontFamily: 'inherit' },
        series: [completionRate],
        plotOptions: {
            radialBar: {
                hollow: { size: '60%' },
                dataLabels: {
                    show: true,
                    name: { offsetY: -10, fontSize: '13px', color: '#888' },
                    value: { fontSize: '30px', fontWeight: 700, color: '#28A745', formatter: val => val + '%' }
                }
            }
        },
        colors: ['#28A745'],
        labels: ['Complété']
    };
    new ApexCharts(document.querySelector("#completionRadialChart"), radialOptions).render();

    // ================= 5. Bar Chart - Par département =================
    const deptLabels = departementsData.map(d => d.nom || 'N/A');
    const deptCopies = departementsData.map(d => parseInt(d.total_copies) || 0);
    
    var deptBarOptions = {
        chart: { type: 'bar', height: 320, fontFamily: 'inherit' },
        series: [{ name: 'Copies', data: deptCopies }],
        xaxis: { categories: deptLabels, labels: { rotate: -45, style: { fontSize: '11px' } } },
        colors: ['#764ba2'],
        plotOptions: { bar: { borderRadius: 6, horizontal: false } },
        dataLabels: { enabled: true, style: { fontSize: '11px' } }
    };
    new ApexCharts(document.querySelector("#departementBarChart"), deptBarOptions).render();

    // ================= 6. Line Chart - Progression mensuelle =================
    const monthLabels = monthlyData.map(m => m.mois || 'N/A');
    const monthTotals = monthlyData.map(m => parseInt(m.total) || 0);
    
    var monthLineOptions = {
        chart: { type: 'area', height: 320, fontFamily: 'inherit' },
        series: [{ name: 'Lots créés', data: monthTotals }],
        xaxis: { categories: monthLabels },
        stroke: { curve: 'smooth', width: 2 },
        colors: ['#667eea'],
        fill: { type: 'gradient', gradient: { opacityFrom: 0.6, opacityTo: 0.1 } }
    };
    new ApexCharts(document.querySelector("#monthlyLineChart"), monthLineOptions).render();

});
</script>
@endsection