@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1 fw-bold text-primary">
                        <i class="bi bi-graph-up-arrow me-2"></i>Dashboard Président
                    </h2>
                    <p class="text-muted mb-0">Vue d'ensemble des lots et de leur progression</p>
                </div>
                <div>
                    <span class="badge bg-primary fs-6 px-3 py-2">
                        <i class="bi bi-calendar-check me-1"></i>{{ date('d/m/Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= KPI Cards ================= --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 hover-lift">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-hourglass-split text-warning fs-2"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted mb-1 small fw-semibold">EN COURS</p>
                            <h3 class="mb-0 fw-bold">{{ $stats['en_cours'] }}</h3>
                            <small class="text-warning">
                                <i class="bi bi-arrow-up"></i> En traitement
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 hover-lift">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-check-circle-fill text-success fs-2"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted mb-1 small fw-semibold">VALIDÉS</p>
                            <h3 class="mb-0 fw-bold">{{ $stats['valide'] }}</h3>
                            <small class="text-success">
                                <i class="bi bi-check2"></i> Terminés
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 hover-lift">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-danger bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-exclamation-triangle-fill text-danger fs-2"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted mb-1 small fw-semibold">EN RETARD</p>
                            <h3 class="mb-0 fw-bold">{{ $stats['retard'] }}</h3>
                            <small class="text-danger">
                                <i class="bi bi-arrow-down"></i> Urgents
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 hover-lift bg-primary bg-gradient text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-white bg-opacity-25 rounded-circle p-3">
                            <i class="bi bi-collection-fill text-white fs-2"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-white-50 mb-1 small fw-semibold">TOTAL</p>
                            <h3 class="mb-0 fw-bold">{{ $stats['total'] }}</h3>
                            <small class="text-white-50">
                                <i class="bi bi-collection"></i> Tous les lots
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= Filters ================= --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="mb-0 fw-bold">
                <i class="bi bi-funnel-fill text-primary me-2"></i>Filtres de recherche
            </h5>
        </div>
        <div class="card-body">
            <form id="filter-form" method="GET">
                <div class="row g-3">
                    {{-- Établissement --}}
                    <div class="col-lg-4 col-md-6">
                        <label class="form-label fw-semibold small text-muted">
                            <i class="bi bi-building me-1"></i>Établissement
                        </label>
                        <select name="etablissement_id" id="etablissement" class="form-select">
                            <option value="">Tous les établissements</option>
                            @foreach(App\Models\Etablissement::all() as $etab)
                                <option value="{{ $etab->id }}" @selected(request('etablissement_id')==$etab->id)>
                                    {{ $etab->libelle }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Département --}}
                    <div class="col-lg-4 col-md-6">
                        <label class="form-label fw-semibold small text-muted">
                            <i class="bi bi-diagram-3 me-1"></i>Département
                        </label>
                        <select name="departement_id" id="departement" class="form-select">
                            <option value="">Tous les départements</option>
                            @if(request('etablissement_id'))
                                @foreach(App\Models\Departement::where('etablissement_id', request('etablissement_id'))->get() as $dep)
                                    <option value="{{ $dep->id }}" @selected(request('departement_id')==$dep->id)>
                                        {{ $dep->libelle }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    {{-- Option --}}
                    <div class="col-lg-4 col-md-6">
                        <label class="form-label fw-semibold small text-muted">
                            <i class="bi bi-mortarboard me-1"></i>Option
                        </label>
                        <select name="option_id" id="option" class="form-select">
                            <option value="">Toutes les options</option>
                            @if(request('departement_id'))
                                @foreach(App\Models\Option::where('departement_id', request('departement_id'))->get() as $opt)
                                    <option value="{{ $opt->id }}" @selected(request('option_id')==$opt->id)>
                                        {{ $opt->libelle_option }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    {{-- Session --}}
                    <div class="col-lg-4 col-md-6">
                        <label class="form-label fw-semibold small text-muted">
                            <i class="bi bi-calendar-event me-1"></i>Session
                        </label>
                        <select name="session_id" id="session" class="form-select">
                            <option value="">Toutes les sessions</option>
                            @if(request('option_id'))
                                @foreach(App\Models\SessionExamen::whereHas('options', fn($q)=>$q->where('id', request('option_id')))->get() as $sess)
                                    <option value="{{ $sess->id }}" @selected(request('session_id')==$sess->id)>
                                        {{ $sess->type }} - {{ $sess->annee_academique }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    {{-- Semestre --}}
                    <div class="col-lg-4 col-md-6">
                        <label class="form-label fw-semibold small text-muted">
                            <i class="bi bi-bookmark-fill me-1"></i>Semestre
                        </label>
                        <select name="semestre_id" id="semestre" class="form-select">
                            <option value="">Tous les semestres</option>
                            @foreach(App\Models\Semestre::all() as $sem)
                                <option value="{{ $sem->id }}" @selected(request('semestre_id')==$sem->id)>
                                    {{ $sem->libelle }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Année académique --}}
                    <div class="col-lg-4 col-md-6">
                        <label class="form-label fw-semibold small text-muted">
                            <i class="bi bi-calendar3 me-1"></i>Année académique
                        </label>
                        <select name="annee_academique" class="form-select">
                            <option value="">Toutes les années</option>
                            @foreach(['2023/2024','2024/2025'] as $annee)
                                <option value="{{ $annee }}" @selected(request('annee_academique')==$annee)>
                                    {{ $annee }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-3">
                    <button class="btn btn-primary px-4" type="submit">
                        <i class="bi bi-search me-2"></i>Filtrer
                    </button>
                    <a href="{{ url()->current() }}" class="btn btn-outline-secondary px-4">
                        <i class="bi bi-x-circle me-2"></i>Réinitialiser
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- ================= Charts Row 1 ================= --}}
    <div class="row g-3 mb-4">
        {{-- Donut Chart --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-pie-chart-fill text-primary me-2"></i>Répartition des lots
                    </h5>
                    <small class="text-muted">Distribution par statut</small>
                </div>
                <div class="card-body">
                    <div id="lotsDonutChart"></div>
                </div>
            </div>
        </div>

        {{-- Bar Chart --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-bar-chart-fill text-success me-2"></i>Lots par département
                    </h5>
                    <small class="text-muted">Comparaison entre départements</small>
                </div>
                <div class="card-body">
                    <div id="lotsBarChart"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= Charts Row 2 ================= --}}
    <div class="row g-3 mb-4">
        {{-- Line Chart --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-graph-up text-info me-2"></i>Évolution des lots
                    </h5>
                    <small class="text-muted">Progression dans le temps</small>
                </div>
                <div class="card-body">
                    <div id="lotsLineChart"></div>
                </div>
            </div>
        </div>

        {{-- Radial Chart --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-speedometer2 text-warning me-2"></i>Taux de complétion
                    </h5>
                    <small class="text-muted">Progression globale</small>
                </div>
                <div class="card-body">
                    <div id="completionRadialChart"></div>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
.hover-lift {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
.apexcharts-tooltip {
    background: #fff !important;
    border: 1px solid #e3e3e3 !important;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    
    // ================= Vérification des données =================
    const stats = @json($stats);
    const chartData = @json($chartData);
    
    console.log('Stats:', stats);
    console.log('Chart Data:', chartData);

    // ================= 1. Donut Chart - Répartition des lots =================
    var donutOptions = {
        chart: { 
            type: 'donut', 
            height: 320,
            fontFamily: 'inherit',
            animations: {
                enabled: true,
                speed: 800,
                animateGradually: { enabled: true, delay: 150 }
            }
        },
        series: [stats.en_cours || 0, stats.valide || 0, stats.retard || 0],
        labels: ['En cours', 'Validés', 'En retard'],
        colors: ['#FFC107', '#28A745', '#DC3545'],
        legend: { 
            position: 'bottom',
            fontSize: '14px',
            markers: { width: 12, height: 12, radius: 12 }
        },
        plotOptions: {
            pie: {
                donut: {
                    size: '70%',
                    labels: {
                        show: true,
                        total: {
                            show: true,
                            label: 'Total',
                            fontSize: '16px',
                            fontWeight: 600,
                            color: '#373d3f'
                        },
                        value: {
                            fontSize: '28px',
                            fontWeight: 700,
                            color: '#373d3f'
                        }
                    }
                }
            }
        },
        dataLabels: {
            enabled: true,
            formatter: function(val, opts) {
                return opts.w.config.series[opts.seriesIndex];
            },
            style: {
                fontSize: '14px',
                fontWeight: 'bold'
            }
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: { height: 280 },
                legend: { position: 'bottom' }
            }
        }]
    };
    
    var donutChart = new ApexCharts(document.querySelector("#lotsDonutChart"), donutOptions);
    donutChart.render();

    // ================= 2. Bar Chart - Lots par département =================
    const barLabels = chartData.map(item => item.label || item.departement || item.date || 'N/A');
    const barTotals = chartData.map(item => parseInt(item.total) || 0);
    
    var barOptions = {
        chart: { 
            type: 'bar', 
            height: 320,
            fontFamily: 'inherit',
            toolbar: { show: true }
        },
        series: [{
            name: 'Nombre de lots',
            data: barTotals
        }],
        xaxis: { 
            categories: barLabels,
            labels: {
                style: { fontSize: '12px' },
                rotate: -45,
                rotateAlways: barLabels.length > 5
            }
        },
        yaxis: {
            labels: { style: { fontSize: '12px' } }
        },
        colors: ['#4E73DF'],
        plotOptions: {
            bar: {
                borderRadius: 8,
                columnWidth: '60%',
                dataLabels: { position: 'top' }
            }
        },
        dataLabels: {
            enabled: true,
            offsetY: -20,
            style: {
                fontSize: '12px',
                fontWeight: 600,
                colors: ['#304758']
            }
        },
        grid: {
            borderColor: '#e7e7e7',
            strokeDashArray: 4
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return val + " lot(s)";
                }
            }
        }
    };
    
    var barChart = new ApexCharts(document.querySelector("#lotsBarChart"), barOptions);
    barChart.render();

    // ================= 3. Line Chart - Évolution temporelle =================
    const lineLabels = chartData.map(item => item.date || item.label || 'N/A');
    const lineTotals = chartData.map(item => parseInt(item.total) || 0);
    
    var lineOptions = {
        chart: { 
            type: 'line', 
            height: 320,
            fontFamily: 'inherit',
            toolbar: { show: true },
            zoom: { enabled: true }
        },
        series: [{
            name: 'Lots',
            data: lineTotals
        }],
        xaxis: { 
            categories: lineLabels,
            labels: {
                style: { fontSize: '12px' },
                rotate: -45
            }
        },
        yaxis: {
            labels: { style: { fontSize: '12px' } }
        },
        stroke: { 
            curve: 'smooth',
            width: 3
        },
        markers: { 
            size: 6, 
            colors: '#17A2B8',
            strokeWidth: 2,
            hover: { size: 8 }
        },
        colors: ['#17A2B8'],
        grid: {
            borderColor: '#e7e7e7',
            strokeDashArray: 4
        },
        tooltip: {
            shared: true,
            intersect: false,
            y: {
                formatter: function(val) {
                    return val + " lot(s)";
                }
            }
        },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.4,
                opacityTo: 0.1
            }
        }
    };
    
    var lineChart = new ApexCharts(document.querySelector("#lotsLineChart"), lineOptions);
    lineChart.render();

    // ================= 4. Radial Chart - Taux de complétion =================
    const total = stats.total || 1;
    const valide = stats.valide || 0;
    const completionRate = Math.round((valide / total) * 100);
    
    var radialOptions = {
        chart: {
            type: 'radialBar',
            height: 280,
            fontFamily: 'inherit'
        },
        series: [completionRate],
        plotOptions: {
            radialBar: {
                hollow: { size: '60%' },
                track: {
                    background: '#f2f2f2',
                    strokeWidth: '100%'
                },
                dataLabels: {
                    show: true,
                    name: {
                        offsetY: -10,
                        fontSize: '14px',
                        color: '#888'
                    },
                    value: {
                        fontSize: '32px',
                        fontWeight: 700,
                        color: '#28A745',
                        formatter: function(val) {
                            return val + '%';
                        }
                    }
                }
            }
        },
        colors: ['#28A745'],
        labels: ['Complété'],
        stroke: {
            lineCap: 'round'
        }
    };
    
    var radialChart = new ApexCharts(document.querySelector("#completionRadialChart"), radialOptions);
    radialChart.render();

    // ================= Filtres dynamiques =================
    document.getElementById('etablissement')?.addEventListener('change', function() {
        const etablissementId = this.value;
        const departementSelect = document.getElementById('departement');
        
        // Reset département et option
        departementSelect.innerHTML = '<option value="">Tous les départements</option>';
        document.getElementById('option').innerHTML = '<option value="">Toutes les options</option>';
        
        if (etablissementId) {
            // Soumettre automatiquement ou charger via AJAX
            // Pour l'instant, on peut soumettre le formulaire
            // document.getElementById('filter-form').submit();
        }
    });

});
</script>
@endsection