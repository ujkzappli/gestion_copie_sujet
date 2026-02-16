@extends('layouts.app')

@push('styles')
<style>
.page-header {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    border-radius: 15px;
    padding: 25px;
    color: white;
    margin-bottom: 25px;
    box-shadow: 0 10px 30px rgba(79, 172, 254, 0.3);
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
    color: #4facfe;
}
.lot-card {
    border: 1px solid #e9ecef;
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 15px;
    transition: all 0.3s ease;
}
.lot-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transform: translateY(-2px);
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
                    <i class="bi bi-person-workspace me-2"></i>Dashboard Enseignant
                </h3>
                <small class="opacity-75">
                    Bienvenue, <strong>{{ auth()->user()->prenom_utilisateur }} {{ auth()->user()->nom_utilisateur }}</strong>
                </small>
            </div>
            <div>
                <span class="badge bg-white text-info px-3 py-2">
                    <i class="bi bi-calendar-check me-1"></i>{{ date('d/m/Y') }}
                </span>
            </div>
        </div>
    </div>

    {{-- ================= KPI Cards ================= --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stats-card" style="border-color: #4facfe;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">MES COPIES</p>
                        <h3 class="mb-0 fw-bold" style="color: #4facfe;">{{ number_format($stats['total_copies'] ?? 0) }}</h3>
                        <small class="text-muted">{{ $stats['total'] ?? 0 }} lots</small>
                    </div>
                    <div class="bg-info bg-opacity-10 rounded-circle p-3">
                        <i class="bi bi-file-earmark-text-fill text-info fs-2"></i>
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
                        <p class="text-muted mb-1 small">RENDUES</p>
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
            <h6 class="mb-0 fw-bold">Filtres</h6>
        </div>
        
        <form id="filter-form" method="GET" action="{{ route('dashboard.enseignant') }}">
            <div class="row g-3">
                
                {{-- Module --}}
                <div class="col-lg-6 col-md-6">
                    <label class="form-label fw-semibold small">
                        <i class="bi bi-book me-1 text-info"></i>Module
                    </label>
                    <select name="module_id" class="form-select">
                        <option value="">Tous mes modules</option>
                        @foreach($modules ?? [] as $mod)
                            <option value="{{ $mod->id }}" @selected(request('module_id')==$mod->id)>
                                {{ $mod->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Statut --}}
                <div class="col-lg-3 col-md-6">
                    <label class="form-label fw-semibold small">
                        <i class="bi bi-filter me-1 text-info"></i>Statut
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
                        <button class="btn btn-info flex-grow-1" type="submit">
                            <i class="bi bi-search me-1"></i>Filtrer
                        </button>
                        <a href="{{ route('dashboard.enseignant') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle"></i>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- ================= Graphiques ================= --}}
    <div class="row g-3 mb-4">
        
        {{-- Progression mensuelle --}}
        <div class="col-lg-8">
            <div class="chart-card">
                <div class="section-title">
                    <i class="bi bi-calendar3"></i>
                    <h6 class="mb-0 fw-bold">Mes lots par mois (12 derniers mois)</h6>
                </div>
                <div id="monthlyLineChart"></div>
            </div>
        </div>

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
    </div>

    {{-- ================= Mes lots de copies ================= --}}
    <div class="filter-card">
        <div class="section-title">
            <i class="bi bi-list-check"></i>
            <h6 class="mb-0 fw-bold">Mes lots de copies</h6>
        </div>

        <div class="row">
            @forelse($lotCopies ?? [] as $lot)
                @php
                    $dateLimiteRecup = $lot->date_disponible ? $lot->date_disponible->copy()->addDays(2) : null;
                    $dateLimiteRemise = $dateLimiteRecup ? $dateLimiteRecup->copy()->addDays(12) : null;
                    $isRetard = $lot->date_remise && $dateLimiteRemise && $lot->date_remise > $dateLimiteRemise;
                    
                    if($lot->date_remise) {
                        $statut = $isRetard ? 'En retard' : 'Terminé';
                        $badgeClass = $isRetard ? 'bg-danger' : 'bg-success';
                        $iconClass = $isRetard ? 'bi-exclamation-triangle-fill' : 'bi-check-circle-fill';
                    } elseif($lot->date_recuperation) {
                        $statut = 'En cours de correction';
                        $badgeClass = 'bg-warning';
                        $iconClass = 'bi-hourglass-split';
                    } else {
                        $statut = 'Disponible';
                        $badgeClass = 'bg-info';
                        $iconClass = 'bi-inbox-fill';
                    }
                @endphp
                
                <div class="col-lg-6 col-md-12">
                    <div class="lot-card">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h6 class="mb-1 fw-bold">{{ $lot->module->nom ?? 'N/A' }}</h6>
                                <small class="text-muted">
                                    <i class="bi bi-files"></i> {{ $lot->nombre_copies }} copies
                                </small>
                            </div>
                            <span class="badge {{ $badgeClass }}">
                                <i class="bi {{ $iconClass }}"></i> {{ $statut }}
                            </span>
                        </div>

                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <small class="text-muted d-block">Date disponible</small>
                                <strong>{{ $lot->date_disponible?->format('d/m/Y') ?? '-' }}</strong>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Limite récupération</small>
                                <strong class="text-primary">{{ $dateLimiteRecup?->format('d/m/Y') ?? '-' }}</strong>
                            </div>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <small class="text-muted d-block">Date récupération</small>
                                <strong>{{ $lot->date_recuperation?->format('d/m/Y') ?? '-' }}</strong>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Limite remise</small>
                                <strong class="text-danger">{{ $dateLimiteRemise?->format('d/m/Y') ?? '-' }}</strong>
                            </div>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block">Date remise</small>
                            <strong>{{ $lot->date_remise?->format('d/m/Y H:i') ?? 'Non remis' }}</strong>
                        </div>

                        <div class="d-flex gap-2">
                            @if(!$lot->date_recuperation)
                                <button class="btn btn-sm btn-primary flex-grow-1">
                                    <i class="bi bi-download"></i> Récupérer
                                </button>
                            @elseif(!$lot->date_remise)
                                <button class="btn btn-sm btn-success flex-grow-1">
                                    <i class="bi bi-upload"></i> Remettre
                                </button>
                            @else
                                <button class="btn btn-sm btn-outline-secondary flex-grow-1" disabled>
                                    <i class="bi bi-check-circle"></i> Remis
                                </button>
                            @endif
                            <button class="btn btn-sm btn-outline-info">
                                <i class="bi bi-eye"></i> Détails
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                        <p class="mb-0">Aucun lot de copies trouvé</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    
    // ================= Graphiques =================
    const stats = @json($stats ?? []);
    const monthlyStats = @json($monthlyStats ?? []);

    // 1. Area - Mensuel
    const monthLabels = monthlyStats.map(m => m.mois || 'N/A');
    const monthTotals = monthlyStats.map(m => parseInt(m.total) || 0);
    
    new ApexCharts(document.querySelector("#monthlyLineChart"), {
        chart: { type: 'area', height: 300 },
        series: [{ name: 'Lots', data: monthTotals }],
        xaxis: { categories: monthLabels },
        colors: ['#4facfe'],
        fill: { type: 'gradient' },
        stroke: { curve: 'smooth', width: 2 }
    }).render();

    // 2. Donut - Statut
    const disponible = (stats.total || 0) - (stats.en_cours || 0) - (stats.valide || 0);
    
    new ApexCharts(document.querySelector("#statutDonutChart"), {
        chart: { type: 'donut', height: 300 },
        series: [disponible, stats.en_cours || 0, stats.valide || 0, stats.retard || 0],
        labels: ['Disponible', 'En cours', 'Terminés', 'En retard'],
        colors: ['#17A2B8', '#FFC107', '#28A745', '#DC3545'],
        legend: { position: 'bottom' },
        plotOptions: { pie: { donut: { size: '65%' } } }
    }).render();

});
</script>
@endpush