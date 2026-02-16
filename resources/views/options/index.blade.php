@extends('layouts.app')

@section('title', 'Gestion des parcours')

@push('styles')
<style>
.status-tabs {
    background: white;
    border-radius: 15px;
    padding: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}
.status-tabs .nav-link {
    border: none;
    border-radius: 10px;
    padding: 12px 24px;
    font-weight: 600;
    color: #6c757d;
    transition: all 0.3s ease;
    position: relative;
}
.status-tabs .nav-link:hover {
    background: rgba(102, 126, 234, 0.1);
    color: #667eea;
}
.status-tabs .nav-link.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}
.status-tabs .badge {
    font-size: 0.7rem;
    padding: 3px 8px;
    border-radius: 12px;
    margin-left: 8px;
}
.card-modern {
    border: none;
    border-radius: 15px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
}
.card-modern:hover {
    box-shadow: 0 4px 20px rgba(0,0,0,0.12);
}
.table-modern {
    border-collapse: separate;
    border-spacing: 0;
}
.table-modern thead th {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border: none;
    color: #495057;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
    padding: 15px 12px;
    position: sticky;
    top: 0;
    z-index: 10;
}
.table-modern tbody tr {
    transition: all 0.2s ease;
}
.table-modern tbody tr:hover {
    background: rgba(102, 126, 234, 0.05);
    transform: scale(1.01);
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}
.table-modern tbody td {
    padding: 12px;
    vertical-align: middle;
    border-bottom: 1px solid #f1f3f5;
}
.btn-action {
    padding: 8px 12px;
    border-radius: 8px;
    transition: all 0.2s ease;
}
.btn-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}
.stats-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    border-left: 4px solid;
    transition: all 0.3s ease;
}
.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.1);
}
.empty-state {
    padding: 60px 20px;
    text-align: center;
}
.empty-state i {
    font-size: 4rem;
    color: #dee2e6;
    margin-bottom: 20px;
}
.parcours-logo {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 1.2rem;
    color: white;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
</style>
@endpush

@section('content')
<div class="container-fluid py-4">

    {{-- Header avec statistiques --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h2 class="mb-1 fw-bold text-primary">
                        <i class="bi bi-ui-checks-grid me-2"></i>Gestion des parcours
                    </h2>
                    <p class="text-muted mb-0">Gérez tous les parcours académiques</p>
                </div>
                <a href="{{ route('options.create') }}" class="btn btn-primary btn-lg shadow-sm">
                    <i class="bi bi-plus-circle me-2"></i>Nouveau parcours
                </a>
            </div>
        </div>
    </div>

    {{-- Statistiques rapides --}}
    <div class="row g-3 mb-4">
        @php
            $totalParcours = $options->count();
            
            // Grouper par département
            $parDepartement = $options->groupBy('departement_id');
            $nbDepartements = $parDepartement->count();
            
            // Grouper par semestre
            $parSemestre = $options->groupBy('semestre_id');
            $nbSemestres = $parSemestre->count();
            
            // Grouper par établissement
            $parEtablissement = $options->groupBy(function($option) {
                return $option->departement->etablissement_id ?? 0;
            });
            $nbEtablissements = $parEtablissement->count();
        @endphp

        <div class="col-xl-3 col-md-6">
            <div class="stats-card" style="border-color: #667eea;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small fw-semibold">TOTAL PARCOURS</p>
                        <h3 class="mb-0 fw-bold text-primary">{{ $totalParcours }}</h3>
                    </div>
                    <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                        <i class="bi bi-ui-checks-grid text-primary fs-2"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stats-card" style="border-color: #28a745;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small fw-semibold">DÉPARTEMENTS</p>
                        <h3 class="mb-0 fw-bold text-success">{{ $nbDepartements }}</h3>
                    </div>
                    <div class="bg-success bg-opacity-10 rounded-circle p-3">
                        <i class="bi bi-diagram-3-fill text-success fs-2"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stats-card" style="border-color: #ffc107;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small fw-semibold">ÉTABLISSEMENTS</p>
                        <h3 class="mb-0 fw-bold" style="color: #ffc107;">{{ $nbEtablissements }}</h3>
                    </div>
                    <div class="rounded-circle p-3" style="background: rgba(255, 193, 7, 0.1);">
                        <i class="bi bi-building-fill fs-2" style="color: #ffc107;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stats-card" style="border-color: #17a2b8;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small fw-semibold">SEMESTRES</p>
                        <h3 class="mb-0 fw-bold text-info">{{ $nbSemestres }}</h3>
                    </div>
                    <div class="bg-info bg-opacity-10 rounded-circle p-3">
                        <i class="bi bi-calendar-range-fill text-info fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Message succès --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill fs-4 me-3"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Onglets de filtrage par département --}}
    <div class="card-modern mb-4">
        <div class="card-body p-3">
            <ul class="nav nav-pills status-tabs justify-content-start flex-wrap" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" data-bs-toggle="pill" data-filter="tout" type="button">
                        <i class="bi bi-grid me-2"></i>Tous
                        <span class="badge bg-white bg-opacity-25">{{ $totalParcours }}</span>
                    </button>
                </li>
                @foreach($parDepartement->take(5) as $deptId => $parcours)
                    @php
                        $dept = $parcours->first()->departement ?? null;
                    @endphp
                    @if($dept)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="pill" data-filter="dept-{{ $deptId }}" type="button">
                                <i class="bi bi-diagram-3 me-2"></i>{{ $dept->sigle }}
                                <span class="badge bg-white bg-opacity-25">{{ $parcours->count() }}</span>
                            </button>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>

    {{-- Tableau des parcours --}}
    <div class="card card-modern">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="optionsTable" class="table table-modern mb-0">
                    <thead>
                        <tr>
                            <th width="60">ID</th>
                            <th width="80"></th>
                            <th>Code</th>
                            <th>Libellé</th>
                            <th>Département</th>
                            <th>Établissement</th>
                            <th>Semestre</th>
                            <th width="150" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($options as $option)
                            <tr data-filter="dept-{{ $option->departement_id }}">
                                <td class="fw-bold text-primary">#{{ $option->id }}</td>
                                <td>
                                    <div class="parcours-logo">
                                        {{ strtoupper(substr($option->code, 0, 2)) }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-secondary fs-6">{{ $option->code }}</span>
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ $option->libelle_option }}</div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-diagram-3-fill text-dark me-2"></i>
                                        <span class="badge bg-dark">{{ $option->departement->sigle ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-building-fill text-info me-2"></i>
                                        <span class="badge bg-info">{{ $option->departement->etablissement->sigle ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-calendar-check-fill text-success me-2"></i>
                                        <span class="badge bg-success">{{ $option->semestre->libelle ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-1 justify-content-center">
                                        <a href="{{ route('options.show', $option) }}"
                                           class="btn btn-sm btn-info btn-action"
                                           title="Voir"
                                           data-bs-toggle="tooltip">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>

                                        <a href="{{ route('options.edit', $option) }}"
                                           class="btn btn-sm btn-warning btn-action"
                                           title="Modifier"
                                           data-bs-toggle="tooltip">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form action="{{ route('options.destroy', $option) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce parcours ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-sm btn-danger btn-action"
                                                    title="Supprimer"
                                                    data-bs-toggle="tooltip">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="empty-row">
                                <td colspan="8">
                                    <div class="empty-state">
                                        <i class="bi bi-ui-checks-grid"></i>
                                        <h5 class="text-muted mb-2">Aucun parcours</h5>
                                        <p class="text-muted">Commencez par créer votre premier parcours</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    
    // ================= Initialisation DataTable =================
    const table = $('#optionsTable').DataTable({
        responsive: false,
        pageLength: 25,
        order: [[0, 'desc']],
        language: {
            search: "Rechercher :",
            lengthMenu: "Afficher _MENU_ entrées",
            info: "Affichage de _START_ à _END_ sur _TOTAL_ entrées",
            infoEmpty: "Aucune entrée à afficher",
            infoFiltered: "(filtré sur _MAX_ entrées)",
            zeroRecords: "Aucun résultat trouvé",
            emptyTable: "Aucune donnée disponible",
            paginate: {
                first: "Premier",
                last: "Dernier",
                next: "Suivant",
                previous: "Précédent"
            }
        },
        dom: '<"row"<"col-sm-6"l><"col-sm-6"f>>rtip',
        drawCallback: function() {
            // Réinitialiser les tooltips après chaque redraw
            $('[data-bs-toggle="tooltip"]').tooltip();
        }
    });

    // ================= Filtrage par département =================
    $('.status-tabs button[data-filter]').on('click', function() {
        const filter = $(this).data('filter');
        
        // Retirer la classe active de tous les boutons
        $('.status-tabs .nav-link').removeClass('active');
        $(this).addClass('active');
        
        // Appliquer le filtre
        if(filter === 'tout') {
            // Afficher toutes les lignes
            table.rows().every(function() {
                $(this.node()).show();
            });
            table.draw();
        } else {
            // Filtrer par département
            table.rows().every(function() {
                const row = $(this.node());
                if(row.data('filter') === filter) {
                    row.show();
                } else {
                    row.hide();
                }
            });
            table.draw();
        }
    });

    // ================= Tooltips Bootstrap =================
    $('[data-bs-toggle="tooltip"]').tooltip();

    // ================= Animation de chargement =================
    $('.stats-card').each(function(index) {
        $(this).css('animation-delay', (index * 0.1) + 's');
        $(this).addClass('animate__animated animate__fadeInUp');
    });

});
</script>
@endsection