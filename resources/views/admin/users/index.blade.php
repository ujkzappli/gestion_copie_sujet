@extends('layouts.app')

@section('title', 'Gestion des utilisateurs')

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
.user-avatar {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #e9ecef;
}
.badge-modern {
    padding: 5px 10px;
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
</style>
@endpush

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="mb-1 fw-bold">
                    <i class="bi bi-people-fill me-2"></i>Gestion des utilisateurs
                </h3>
                <small class="opacity-75">Liste complète des utilisateurs du système</small>
            </div>
            @php $authUser = auth()->user(); @endphp
            @if(in_array($authUser->type, ['Admin', 'President']))
                <a href="{{ route('admin.users.create') }}" class="btn btn-light btn-lg">
                    <i class="bi bi-plus-circle me-2"></i>Nouvel utilisateur
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
            $stats = [
                'total' => $users->count(),
                'admins' => $users->whereIn('type', ['Admin', 'President'])->count(),
                'enseignants' => $users->where('type', 'Enseignant')->count(),
                'autres' => $users->whereNotIn('type', ['Admin', 'President', 'Enseignant'])->count(),
            ];
        @endphp

        <div class="col-xl-3 col-md-6">
            <div class="stats-card" style="border-color: #667eea;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">TOTAL</p>
                        <h4 class="mb-0 fw-bold" style="color: #667eea;">{{ $stats['total'] }}</h4>
                    </div>
                    <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                        <i class="bi bi-people-fill text-primary fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stats-card" style="border-color: #dc3545;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">ADMINS</p>
                        <h4 class="mb-0 fw-bold text-danger">{{ $stats['admins'] }}</h4>
                    </div>
                    <div class="bg-danger bg-opacity-10 rounded-circle p-2">
                        <i class="bi bi-shield-fill-check text-danger fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stats-card" style="border-color: #28a745;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">ENSEIGNANTS</p>
                        <h4 class="mb-0 fw-bold text-success">{{ $stats['enseignants'] }}</h4>
                    </div>
                    <div class="bg-success bg-opacity-10 rounded-circle p-2">
                        <i class="bi bi-mortarboard-fill text-success fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stats-card" style="border-color: #ffc107;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">AUTRES</p>
                        <h4 class="mb-0 fw-bold text-warning">{{ $stats['autres'] }}</h4>
                    </div>
                    <div class="bg-warning bg-opacity-10 rounded-circle p-2">
                        <i class="bi bi-person-fill text-warning fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tableau --}}
    <div class="table-card">
        <div class="table-responsive">
            <table id="usersTable" class="table table-modern mb-0">
                <thead>
                    <tr>
                        <th width="50">ID</th>
                        <th>Utilisateur</th>
                        <th>Email</th>
                        <th width="100">Type</th>
                        <th width="120">Établissement</th>
                        <th width="120">Département</th>
                        <th width="130" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td class="fw-bold text-primary">#{{ $user->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('assets/images/lg/avatar4.svg') }}"
                                         class="user-avatar me-2"
                                         alt="Avatar">
                                    <div>
                                        <div class="fw-semibold">{{ $user->nom_utilisateur }} {{ $user->prenom_utilisateur }}</div>
                                        <small class="text-muted">{{ $user->matricule_utilisateur }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <i class="bi bi-envelope text-muted me-1"></i>
                                <small>{{ $user->email }}</small>
                            </td>
                            <td>
                                @php
                                    $typeColors = [
                                        'Admin' => 'danger',
                                        'President' => 'danger',
                                        'Enseignant' => 'success',
                                        'DA' => 'primary',
                                        'CS' => 'info',
                                        'CD' => 'warning',
                                    ];
                                    $color = $typeColors[$user->type] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $color }} badge-modern">{{ $user->type }}</span>
                            </td>
                            <td>
                                @if($user->etablissement)
                                    <span class="badge bg-secondary badge-modern" title="{{ $user->etablissement->nom }}">
                                        {{ $user->etablissement->sigle }}
                                    </span>
                                @else
                                    <small class="text-muted">-</small>
                                @endif
                            </td>
                            <td>
                                @if($user->departement)
                                    <span class="badge bg-secondary badge-modern" title="{{ $user->departement->nom }}">
                                        {{ $user->departement->sigle }}
                                    </span>
                                @else
                                    <small class="text-muted">-</small>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <a href="{{ route('admin.users.show', $user) }}"
                                       class="btn btn-sm btn-info btn-action"
                                       title="Voir"
                                       data-bs-toggle="tooltip">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>

                                    <a href="{{ route('admin.users.edit', $user) }}"
                                       class="btn btn-sm btn-warning btn-action"
                                       title="Modifier"
                                       data-bs-toggle="tooltip">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    @if($user->id !== $authUser->id)
                                        <form action="{{ route('admin.users.destroy', $user) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer {{ $user->prenom_utilisateur }} {{ $user->nom_utilisateur }} ?')">
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
                                                title="Vous ne pouvez pas vous supprimer"
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
                            <td colspan="7" class="text-center py-5">
                                <i class="bi bi-people text-muted fs-1 mb-3 d-block"></i>
                                <p class="text-muted mb-0">Aucun utilisateur enregistré</p>
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
    const table = $('#usersTable').DataTable({
        responsive: true,
        pageLength: 25,
        order: [[0, 'asc']],
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