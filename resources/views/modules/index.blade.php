@extends('layouts.app')

@section('title', 'Gestion des modules')

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
.table-card {
    background: white;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
}
.table-modern {
    border-collapse: separate;
    border-spacing: 0;
    font-size: 0.9rem;
}
.table-modern thead th {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border: none;
    color: #495057;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
    padding: 12px 10px;
    white-space: nowrap;
}
.table-modern tbody tr {
    transition: all 0.2s ease;
    border-bottom: 1px solid #f1f3f5;
}
.table-modern tbody tr:hover {
    background: rgba(102, 126, 234, 0.05);
    transform: scale(1.01);
}
.table-modern tbody td {
    padding: 12px 10px;
    vertical-align: middle;
    border: none;
}
.badge-modern {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}
.btn-action {
    padding: 6px 10px;
    border-radius: 8px;
    transition: all 0.2s ease;
    font-size: 0.85rem;
}
.btn-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}
.stats-card {
    background: white;
    border-radius: 12px;
    padding: 15px;
    border-left: 4px solid;
    transition: all 0.3s ease;
}
.stats-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 12px rgba(0,0,0,0.1);
}
.module-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
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
                    <i class="bi bi-book-fill me-2"></i>Gestion des modules
                </h3>
                <small class="opacity-75">Liste complète des modules d'enseignement</small>
            </div>
            @php $user = auth()->user(); @endphp
            @if(!in_array($user->type, ['Enseignant']))
                <a href="{{ route('modules.create') }}" class="btn btn-light btn-lg">
                    <i class="bi bi-plus-circle me-2"></i>Nouveau module
                </a>
            @endif
        </div>
    </div>

    {{-- Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Statistiques rapides --}}
    <div class="row g-3 mb-3">
        @php
            $allModules = $modules ?? collect();
            $stats = [
                'total' => $allModules->count(),
                'semestre1' => $allModules->filter(function($m) { 
                    return $m->semestre && (str_contains(strtolower($m->semestre->code ?? ''), 's1') || str_contains(strtolower($m->semestre->libelle ?? ''), 'semestre 1'));
                })->count(),
                'semestre2' => $allModules->filter(function($m) { 
                    return $m->semestre && (str_contains(strtolower($m->semestre->code ?? ''), 's2') || str_contains(strtolower($m->semestre->libelle ?? ''), 'semestre 2'));
                })->count(),
                'sans_enseignant' => $allModules->whereNull('enseignant_id')->count(),
            ];
        @endphp

        <div class="col-xl-3 col-md-6">
            <div class="stats-card" style="border-color: #667eea;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">TOTAL MODULES</p>
                        <h4 class="mb-0 fw-bold" style="color: #667eea;">{{ $stats['total'] }}</h4>
                    </div>
                    <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                        <i class="bi bi-book-fill text-primary fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stats-card" style="border-color: #28a745;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">SEMESTRE 1</p>
                        <h4 class="mb-0 fw-bold text-success">{{ $stats['semestre1'] }}</h4>
                    </div>
                    <div class="bg-success bg-opacity-10 rounded-circle p-2">
                        <i class="bi bi-1-circle-fill text-success fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stats-card" style="border-color: #17a2b8;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">SEMESTRE 2</p>
                        <h4 class="mb-0 fw-bold text-info">{{ $stats['semestre2'] }}</h4>
                    </div>
                    <div class="bg-info bg-opacity-10 rounded-circle p-2">
                        <i class="bi bi-2-circle-fill text-info fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stats-card" style="border-color: #ffc107;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">SANS ENSEIGNANT</p>
                        <h4 class="mb-0 fw-bold text-warning">{{ $stats['sans_enseignant'] }}</h4>
                    </div>
                    <div class="bg-warning bg-opacity-10 rounded-circle p-2">
                        <i class="bi bi-person-x-fill text-warning fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tableau --}}
    <div class="table-card">
        <div class="table-responsive">
            <table id="modulesTable" class="table table-modern mb-0">
                <thead>
                    <tr>
                        <th width="50">ID</th>
                        <th width="100">Code</th>
                        <th>Nom du module</th>
                        <th width="120">Semestre</th>
                        <th>Enseignant responsable</th>
                        <th width="130" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($allModules as $module)
                        <tr>
                            <td class="fw-bold text-primary">#{{ $module->id }}</td>
                            
                            <td>
                                <span class="badge bg-secondary badge-modern">
                                    {{ $module->code ?? 'N/A' }}
                                </span>
                            </td>

                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="module-icon bg-primary bg-opacity-10 text-primary me-2">
                                        <i class="bi bi-journal-text"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $module->nom }}</div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                @if($module->semestre)
                                    <span class="badge bg-success badge-modern">
                                        <i class="bi bi-bookmark-fill me-1"></i>
                                        {{ $module->semestre->code ?? $module->semestre->libelle }}
                                    </span>
                                @else
                                    <small class="text-muted">Non défini</small>
                                @endif
                            </td>

                            <td>
                                @if($module->enseignant)
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 bg-info bg-opacity-10 rounded-circle p-2 me-2">
                                            <i class="bi bi-person text-info"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold" style="font-size: 0.85rem;">
                                                {{ $module->enseignant->prenom_utilisateur }} {{ $module->enseignant->nom_utilisateur }}
                                            </div>
                                            <small class="text-muted">{{ $module->enseignant->matricule_utilisateur }}</small>
                                        </div>
                                    </div>
                                @else
                                    <span class="badge bg-warning badge-modern">
                                        <i class="bi bi-exclamation-triangle me-1"></i>
                                        Non assigné
                                    </span>
                                @endif
                            </td>

                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    {{-- Voir --}}
                                    <a href="{{ route('modules.show', $module) }}"
                                       class="btn btn-sm btn-info btn-action"
                                       title="Voir les détails"
                                       data-bs-toggle="tooltip">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>

                                    {{-- Modifier / Supprimer seulement si pas Enseignant --}}
                                    @if(!in_array($user->type, ['Enseignant']))
                                        <a href="{{ route('modules.edit', $module) }}"
                                           class="btn btn-sm btn-warning btn-action"
                                           title="Modifier"
                                           data-bs-toggle="tooltip">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form action="{{ route('modules.destroy', $module) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer le module {{ $module->nom }} ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-sm btn-danger btn-action"
                                                    title="Supprimer"
                                                    data-bs-toggle="tooltip">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    @else
                                        <button type="button"
                                                class="btn btn-sm btn-secondary btn-action"
                                                title="Actions non autorisées"
                                                data-bs-toggle="tooltip"
                                                disabled>
                                            <i class="bi bi-lock-fill"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-book text-muted fs-1 mb-3 d-block"></i>
                                <p class="text-muted mb-0">Aucun module enregistré</p>
                                @if(!in_array($user->type, ['Enseignant']))
                                    <a href="{{ route('modules.create') }}" class="btn btn-primary btn-sm mt-3">
                                        <i class="bi bi-plus-circle me-1"></i>Créer un module
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    
    // ================= DataTable =================
    const table = $('#modulesTable').DataTable({
        responsive: false,
        pageLength: 25,
        order: [[0, 'desc']], // Ordre descendant pour voir les nouveaux modules en premier
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

    // ================= Tooltips Bootstrap =================
    $('[data-bs-toggle="tooltip"]').tooltip();

    // ================= Animation au chargement =================
    $('.stats-card').each(function(index) {
        $(this).css('animation-delay', (index * 0.1) + 's');
        $(this).addClass('animate__animated animate__fadeInUp');
    });

});
</script>

{{-- Animate.css pour les animations --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@endsection