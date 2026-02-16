@extends('layouts.app')

@section('title', 'Gestion des lots de copies')

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
.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    gap: 6px;
}
.status-disponible {
    background: #e3f2fd;
    color: #1976d2;
}
.status-recupere {
    background: #fff3e0;
    color: #f57c00;
}
.status-termine {
    background: #e8f5e9;
    color: #388e3c;
}
.status-retard {
    background: #ffebee;
    color: #d32f2f;
}
.progress-modern {
    height: 8px;
    border-radius: 10px;
    background: #e9ecef;
    overflow: hidden;
}
.progress-modern .progress-bar {
    transition: width 0.6s ease;
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
                        <i class="bi bi-archive-fill me-2"></i>Gestion des lots de copies
                    </h2>
                    <p class="text-muted mb-0">Suivez et gérez tous vos lots de copies en temps réel</p>
                </div>
                @php
                    $user = auth()->user();
                @endphp
                @if(!in_array($user->type, ['Enseignant']))
                    <a href="{{ route('lot-copies.create') }}" class="btn btn-primary btn-lg shadow-sm">
                        <i class="bi bi-plus-circle me-2"></i>Nouveau lot
                    </a>
                @endif
            </div>
        </div>
    </div>

    {{-- Statistiques rapides --}}
    <div class="row g-3 mb-4">
        @php
            $stats = [
                'disponible' => $lotCopies->where('date_recuperation', null)->count(),
                'recupere' => $lotCopies->whereNotNull('date_recuperation')->where('date_remise', null)->count(),
                'termine' => $lotCopies->whereNotNull('date_remise')->count(),
                'retard' => 0 // Sera calculé ci-dessous
            ];
            
            // Calcul des retards UNIQUEMENT pour la remise
            foreach($lotCopies as $lot) {
                $dateLimiteRecup = $lot->date_disponible ? $lot->date_disponible->copy()->addDays(2) : null;
                $dateLimiteRemise = $dateLimiteRecup ? $dateLimiteRecup->copy()->addDays(12) : null;
                
                // Retard UNIQUEMENT si la date de remise dépasse la limite de remise
                if($lot->date_remise && $dateLimiteRemise && $lot->date_remise > $dateLimiteRemise) {
                    $stats['retard']++;
                }
            }
        @endphp

        <div class="col-xl-3 col-md-6">
            <div class="stats-card" style="border-color: #1976d2;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small fw-semibold">DISPONIBLES</p>
                        <h3 class="mb-0 fw-bold text-primary">{{ $stats['disponible'] }}</h3>
                    </div>
                    <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                        <i class="bi bi-inbox-fill text-primary fs-2"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stats-card" style="border-color: #f57c00;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small fw-semibold">RÉCUPÉRÉS</p>
                        <h3 class="mb-0 fw-bold" style="color: #f57c00;">{{ $stats['recupere'] }}</h3>
                    </div>
                    <div class="rounded-circle p-3" style="background: rgba(245, 124, 0, 0.1);">
                        <i class="bi bi-pencil-square fs-2" style="color: #f57c00;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stats-card" style="border-color: #388e3c;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small fw-semibold">TERMINÉS</p>
                        <h3 class="mb-0 fw-bold text-success">{{ $stats['termine'] }}</h3>
                    </div>
                    <div class="bg-success bg-opacity-10 rounded-circle p-3">
                        <i class="bi bi-check-circle-fill text-success fs-2"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stats-card" style="border-color: #d32f2f;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small fw-semibold">EN RETARD</p>
                        <h3 class="mb-0 fw-bold text-danger">{{ $stats['retard'] }}</h3>
                    </div>
                    <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                        <i class="bi bi-exclamation-triangle-fill text-danger fs-2"></i>
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

    {{-- Onglets de filtrage --}}
    <div class="card-modern mb-4">
        <div class="card-body p-3">
            <ul class="nav nav-pills status-tabs justify-content-start" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" data-bs-toggle="pill" data-filter="disponible" type="button">
                        <i class="bi bi-inbox me-2"></i>Disponibles
                        <span class="badge bg-white bg-opacity-25">{{ $stats['disponible'] }}</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="pill" data-filter="recupere" type="button">
                        <i class="bi bi-pencil-square me-2"></i>Récupérés
                        <span class="badge bg-white bg-opacity-25">{{ $stats['recupere'] }}</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="pill" data-filter="termine" type="button">
                        <i class="bi bi-check-circle me-2"></i>Terminés
                        <span class="badge bg-white bg-opacity-25">{{ $stats['termine'] }}</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="pill" data-filter="retard" type="button">
                        <i class="bi bi-exclamation-triangle me-2"></i>En retard
                        <span class="badge bg-white bg-opacity-25">{{ $stats['retard'] }}</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="pill" data-filter="tout" type="button">
                        <i class="bi bi-grid me-2"></i>Tout afficher
                        <span class="badge bg-white bg-opacity-25">{{ $lotCopies->count() }}</span>
                    </button>
                </li>
            </ul>
        </div>
    </div>

    {{-- Tableau des lots --}}
    <div class="card card-modern">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="lotCopiesTable" class="table table-modern mb-0">
                    <thead>
                        <tr>
                            <th width="60">ID</th>
                            <th>Module</th>
                            <th>Enseignant</th>
                            <th width="80">Copies</th>
                            <th width="110">Date dispo.</th>
                            <th width="110">Limite récup.</th>
                            <th width="110">Récup. réelle</th>
                            <th width="110">Limite remise</th>
                            <th width="110">Remise réelle</th>
                            <th width="150">Statut</th>
                            <th width="120" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lotCopies as $lot)
                            @php
                                // Calcul des dates limites
                                $dateLimiteRecup = $lot->date_disponible ? $lot->date_disponible->copy()->addDays(2) : null;
                                $dateLimiteRemise = $dateLimiteRecup ? $dateLimiteRecup->copy()->addDays(12) : null;

                                // Détermination du statut
                                $statut = 'disponible';
                                $isRetard = false;
                                
                                if($lot->date_remise) {
                                    $statut = 'termine';
                                    // Retard UNIQUEMENT si la date de remise dépasse la limite de remise
                                    if($dateLimiteRemise && $lot->date_remise > $dateLimiteRemise) {
                                        $isRetard = true;
                                    }
                                } elseif($lot->date_recuperation) {
                                    $statut = 'recupere';
                                }
                                
                                // Progression
                                $progress = 0;
                                if($lot->date_recuperation) $progress += 50;
                                if($lot->date_remise) $progress += 50;
                            @endphp

                            <tr data-status="{{ $statut }}" data-retard="{{ $isRetard ? '1' : '0' }}">
                                <td class="fw-bold text-primary">#{{ $lot->id }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $lot->module->nom ?? 'N/A' }}</div>
                                    <small class="text-muted">{{ $lot->module->code ?? '' }}</small>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar rounded-circle bg-primary bg-opacity-10 text-primary me-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                            <i class="bi bi-person"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $lot->module->enseignant?->prenom_utilisateur }} {{ $lot->module->enseignant?->nom_utilisateur }}</div>
                                            <small class="text-muted">{{ $lot->module->enseignant?->matricule_utilisateur }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info">{{ $lot->nombre_copies }}</span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <i class="bi bi-calendar-check me-1"></i>
                                        {{ $lot->date_disponible?->format('d/m/Y') }}
                                    </small>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <i class="bi bi-clock me-1"></i>
                                        {{ $dateLimiteRecup?->format('d/m/Y') }}
                                    </small>
                                </td>
                                <td>
                                    @if($lot->date_recuperation)
                                        <small class="text-success">
                                            <i class="bi bi-check-circle me-1"></i>
                                            {{ $lot->date_recuperation->format('d/m/Y') }}
                                        </small>
                                    @else
                                        <small class="text-muted">-</small>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <i class="bi bi-clock me-1"></i>
                                        {{ $dateLimiteRemise?->format('d/m/Y') }}
                                    </small>
                                </td>
                                <td>
                                    @if($lot->date_remise)
                                        <small class="{{ $dateLimiteRemise && $lot->date_remise > $dateLimiteRemise ? 'text-danger fw-bold' : 'text-success' }}">
                                            <i class="bi bi-{{ $dateLimiteRemise && $lot->date_remise > $dateLimiteRemise ? 'exclamation-triangle-fill' : 'check-circle' }} me-1"></i>
                                            {{ $lot->date_remise->format('d/m/Y') }}
                                        </small>
                                    @else
                                        <small class="text-muted">-</small>
                                    @endif
                                </td>
                                <td>
                                    @if($isRetard)
                                        <span class="status-badge status-retard">
                                            <i class="bi bi-exclamation-circle-fill"></i>
                                            En retard
                                        </span>
                                    @elseif($statut === 'termine')
                                        <span class="status-badge status-termine">
                                            <i class="bi bi-check-circle-fill"></i>
                                            Terminé
                                        </span>
                                    @elseif($statut === 'recupere')
                                        <span class="status-badge status-recupere">
                                            <i class="bi bi-pencil-fill"></i>
                                            En correction
                                        </span>
                                    @else
                                        <span class="status-badge status-disponible">
                                            <i class="bi bi-inbox-fill"></i>
                                            Disponible
                                        </span>
                                    @endif
                                    
                                    <div class="progress progress-modern mt-2">
                                        <div class="progress-bar bg-primary" style="width: {{ $progress }}%"></div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-1 justify-content-center">
                                        <a href="{{ route('lot-copies.edit', $lot) }}"
                                           class="btn btn-sm btn-warning btn-action"
                                           title="Modifier"
                                           data-bs-toggle="tooltip">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        @if(!in_array($user->type, ['Enseignant']))
                                            <form action="{{ route('lot-copies.destroy', $lot) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce lot ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-sm btn-danger btn-action"
                                                        title="Supprimer"
                                                        data-bs-toggle="tooltip">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="empty-row">
                                <td colspan="11">
                                    <div class="empty-state">
                                        <i class="bi bi-inbox"></i>
                                        <h5 class="text-muted mb-2">Aucun lot de copies</h5>
                                        <p class="text-muted">Commencez par créer votre premier lot</p>
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
    const table = $('#lotCopiesTable').DataTable({
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

    // ================= Filtrage par statut =================
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
        } else if(filter === 'retard') {
            // Filtrer les lignes en retard
            table.rows().every(function() {
                const row = $(this.node());
                if(row.data('retard') === '1') {
                    row.show();
                } else {
                    row.hide();
                }
            });
            table.draw();
        } else {
            // Filtrer par statut
            table.rows().every(function() {
                const row = $(this.node());
                if(row.data('status') === filter) {
                    row.show();
                } else {
                    row.hide();
                }
            });
            table.draw();
        }
    });

    // ================= Déclencher le filtre "disponible" au chargement =================
    $('.status-tabs button[data-filter="disponible"]').trigger('click');

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