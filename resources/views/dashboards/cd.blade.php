@extends('layouts.app')

@push('styles')
<style>
.page-header {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    border-radius: 15px;
    padding: 25px;
    color: white;
    margin-bottom: 25px;
    box-shadow: 0 10px 30px rgba(240, 147, 251, 0.3);
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
    color: #f093fb;
}
.select2-container--bootstrap-5 .select2-selection {
    min-height: 38px;
    border: 2px solid #e9ecef;
    border-radius: 8px;
}
.select2-container--bootstrap-5 .select2-selection:focus {
    border-color: #f093fb;
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
                    <i class="bi bi-building me-2"></i>Dashboard Chef de Département
                </h3>
                <small class="opacity-75">
                    Département: <strong>{{ $departement->sigle ?? 'N/A' }}</strong> - {{ $departement->nom ?? '' }}
                </small>
            </div>
            <div>
                <span class="badge bg-white text-danger px-3 py-2">
                    <i class="bi bi-calendar-check me-1"></i>{{ date('d/m/Y') }}
                </span>
            </div>
        </div>
    </div>

    {{-- ================= KPI Cards ================= --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stats-card" style="border-color: #f093fb;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">TOTAL COPIES</p>
                        <h3 class="mb-0 fw-bold" style="color: #f093fb;">{{ number_format($stats['total_copies'] ?? 0) }}</h3>
                        <small class="text-muted">{{ $stats['total'] ?? 0 }} lots</small>
                    </div>
                    <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                        <i class="bi bi-file-earmark-text-fill text-danger fs-2"></i>
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

    {{-- ================= Filtres ================= --}}
    <div class="filter-card mb-4">
        <div class="section-title">
            <i class="bi bi-funnel-fill"></i>
            <h6 class="mb-0 fw-bold">Filtres de recherche</h6>
        </div>
        
        <form id="filter-form" method="GET" action="{{ route('dashboard.cd') }}">
            <div class="row g-3">
                
                {{-- Recherche Enseignant avec Select2 --}}
                <div class="col-lg-6 col-md-6">
                    <label class="form-label fw-semibold small">
                        <i class="bi bi-person-search me-1 text-danger"></i>Enseignant
                    </label>
                    <select name="enseignant_id" id="enseignant_select" class="form-select">
                        <option value="">-- Tous les enseignants du département --</option>
                        @foreach($enseignants ?? [] as $ens)
                            <option value="{{ $ens->id }}" 
                                    @selected(request('enseignant_id') == $ens->id)
                                    data-matricule="{{ $ens->matricule_utilisateur }}">
                                {{ $ens->prenom_utilisateur }} {{ $ens->nom_utilisateur }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Statut --}}
                <div class="col-lg-3 col-md-6">
                    <label class="form-label fw-semibold small">
                        <i class="bi bi-filter me-1 text-danger"></i>Statut
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
                        <button class="btn btn-danger flex-grow-1" type="submit">
                            <i class="bi bi-search me-1"></i>Filtrer
                        </button>
                        <a href="{{ route('dashboard.cd') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle"></i>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- ================= Graphiques ================= --}}
    <div class="row g-3 mb-4">
        
        {{-- Top enseignants du département --}}
        <div class="col-lg-6">
            <div class="chart-card">
                <div class="section-title">
                    <i class="bi bi-bar-chart-fill"></i>
                    <h6 class="mb-0 fw-bold">Enseignants du département (nombre de copies)</h6>
                </div>
                <div id="enseignantBarChart"></div>
            </div>
        </div>

        {{-- Répartition par statut --}}
        <div class="col-lg-6">
            <div class="chart-card">
                <div class="section-title">
                    <i class="bi bi-pie-chart-fill"></i>
                    <h6 class="mb-0 fw-bold">Répartition par statut</h6>
                </div>
                <div id="statutDonutChart"></div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        
        {{-- Progression mensuelle --}}
        <div class="col-lg-12">
            <div class="chart-card">
                <div class="section-title">
                    <i class="bi bi-calendar3"></i>
                    <h6 class="mb-0 fw-bold">Progression mensuelle (12 derniers mois)</h6>
                </div>
                <div id="monthlyLineChart"></div>
            </div>
        </div>
    </div>

    {{-- ================= Liste des lots ================= --}}
    <div class="filter-card">
        <div class="section-title">
            <i class="bi bi-list-ul"></i>
            <h6 class="mb-0 fw-bold">Liste des lots de copies du département</h6>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-sm">
                <thead class="table-light">
                    <tr>
                        <th>Module</th>
                        <th>Enseignant</th>
                        <th>Copies</th>
                        <th>Date disponible</th>
                        <th>Date récupération</th>
                        <th>Date remise</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lotCopies ?? [] as $lot)
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
                            <td>{{ $lot->module->enseignant->prenom_utilisateur ?? '' }} {{ $lot->module->enseignant->nom_utilisateur ?? 'N/A' }}</td>
                            <td><span class="badge bg-primary">{{ $lot->nombre_copies }}</span></td>
                            <td><small>{{ $lot->date_disponible?->format('d/m/Y') ?? '-' }}</small></td>
                            <td><small>{{ $lot->date_recuperation?->format('d/m/Y') ?? '-' }}</small></td>
                            <td><small>{{ $lot->date_remise?->format('d/m/Y') ?? '-' }}</small></td>
                            <td><span class="badge {{ $badgeClass }}">{{ $statut }}</span></td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" title="Voir détails">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                Aucun lot de copies trouvé pour ce département
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
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
        }
    });

    // ================= Graphiques =================
    const stats = @json($stats ?? []);
    const enseignantsStats = @json($enseignantsStats ?? []);
    const monthlyStats = @json($monthlyStats ?? []);

    // 1. Bar - Enseignants
    const ensLabels = enseignantsStats.map(e => e.nom || 'N/A');
    const ensCopies = enseignantsStats.map(e => parseInt(e.total_copies) || 0);
    
    new ApexCharts(document.querySelector("#enseignantBarChart"), {
        chart: { type: 'bar', height: 320 },
        series: [{ name: 'Copies', data: ensCopies }],
        xaxis: { categories: ensLabels, labels: { rotate: -45, style: { fontSize: '11px' } } },
        colors: ['#f093fb'],
        plotOptions: { bar: { borderRadius: 6 } },
        dataLabels: { enabled: true }
    }).render();

    // 2. Donut - Statut
    new ApexCharts(document.querySelector("#statutDonutChart"), {
        chart: { type: 'donut', height: 320 },
        series: [stats.en_cours || 0, stats.valide || 0, stats.retard || 0],
        labels: ['En cours', 'Terminés', 'En retard'],
        colors: ['#FFC107', '#28A745', '#DC3545'],
        legend: { position: 'bottom' },
        plotOptions: { pie: { donut: { size: '65%' } } }
    }).render();

    // 3. Area - Mensuel
    const monthLabels = monthlyStats.map(m => m.mois || 'N/A');
    const monthTotals = monthlyStats.map(m => parseInt(m.total) || 0);
    
    new ApexCharts(document.querySelector("#monthlyLineChart"), {
        chart: { type: 'area', height: 280 },
        series: [{ name: 'Lots', data: monthTotals }],
        xaxis: { categories: monthLabels },
        colors: ['#f093fb'],
        fill: { type: 'gradient' },
        stroke: { curve: 'smooth', width: 2 }
    }).render();

});
</script>
@endpush