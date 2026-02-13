@extends('layouts.app')

@section('title', 'Gestion des modules')

@section('content')
<div class="container-fluid">

    {{-- Titre + bouton (visible seulement pour ceux qui peuvent créer) --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Liste des modules</h4>

        @php
            $user = auth()->user();
        @endphp

        @if(!in_array($user->type, ['Enseignant']))
            <a href="{{ route('modules.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nouveau module
            </a>
        @endif
    </div>

    {{-- Message succès --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Tableau --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <table id="modulesTable" class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Code</th>
                        <th>Nom</th>
                        <th>Semestre</th>
                        <th>Enseignant</th>
                        <th width="180">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($modules as $module)
                        <tr>
                            <td>{{ $module->id }}</td>

                            <td>
                                <span class="badge bg-secondary">{{ $module->code }}</span>
                            </td>

                            <td>{{ $module->nom }}</td>

                            <td>
                                <span class="badge bg-success">
                                    {{ $module->semestre?->libelle ?? '-' }}
                                </span>
                            </td>

                            <td>
                                {{ $module->enseignant?->prenom_utilisateur }} {{ $module->enseignant?->nom_utilisateur }} - {{ $module->enseignant?->matricule_utilisateur }}
                            </td>

                            <td class="text-center">
                                {{-- Voir --}}
                                <a href="{{ route('modules.show', $module) }}"
                                   class="btn btn-sm btn-outline-info"
                                   title="Voir">
                                    <i class="bi bi-eye-fill"></i>
                                </a>

                                {{-- Modifier / Supprimer seulement si pas Enseignant --}}
                                @if(!in_array($user->type, ['Enseignant']))
                                    <a href="{{ route('modules.edit', $module) }}"
                                       class="btn btn-sm btn-outline-warning"
                                       title="Modifier">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <form action="{{ route('modules.destroy', $module) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Supprimer ce module ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                title="Supprimer">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                Aucun module enregistré
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
<script>
$(document).ready(function () {
    $('#modulesTable').DataTable({
        responsive: false,
        pageLength: 25,
        order: [[0, 'asc']],
        language: {
            search: "Recherche :",
            lengthMenu: "Afficher _MENU_ entrées",
            info: "Affichage de _START_ à _END_ sur _TOTAL_ entrées",
            paginate: {
                first: "Premier",
                last: "Dernier",
                next: "Suivant",
                previous: "Précédent"
            }
        }
    });
});
</script>
@endpush
