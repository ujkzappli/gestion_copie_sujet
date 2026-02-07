@extends('layouts.app')

@section('title', 'Gestion des lots de copies')

@section('content')
<div class="container-fluid">

    {{-- Titre + bouton --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Liste des lots de copies</h4>
        <a href="{{ route('lot-copies.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nouveau lot
        </a>
    </div>

    {{-- Message succès --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tableau --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <table id="lotCopiesTable" class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Module</th>
                        <th>Enseignant</th>
                        <th>Copies</th>
                        <th>Disponible</th>
                        <th>Récupération</th>
                        <th>Remise</th>
                        <th>Statut</th>
                        <th width="180">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lots as $lot)
                        <tr>
                            <td>{{ $lot->id }}</td>

                            <td>
                                <strong>{{ $lot->module->nom }}</strong><br>
                                <span class="text-muted">{{ $lot->module->code }}</span>
                            </td>

                            <td>
                                {{ $lot->module->enseignant->nom_utilisateur ?? '-' }}
                                {{ $lot->module->enseignant->prenom_utilisateur ?? '' }}
                            </td>

                            <td>
                                <span class="badge bg-secondary">
                                    {{ $lot->nombre_copies }}
                                </span>
                            </td>

                            <td>{{ $lot->date_disponible->format('d/m/Y') }}</td>
                            <td>{{ $lot->date_recuperation?->format('d/m/Y') ?? '-' }}</td>
                            <td>{{ $lot->date_remise?->format('d/m/Y') ?? '-' }}</td>

                            <td>
                                <span class="badge {{ $lot->statut === 'Valider' ? 'bg-success' : 'bg-warning' }}">
                                    {{ $lot->statut }}
                                </span>
                            </td>

                            <td class="text-center">
                                <a href="{{ route('lot-copies.show', $lot) }}"
                                   class="btn btn-sm btn-outline-info"
                                   title="Voir">
                                    <i class="bi bi-eye-fill"></i>
                                </a>

                                <a href="{{ route('lot-copies.edit', $lot) }}"
                                   class="btn btn-sm btn-outline-warning"
                                   title="Modifier">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('lot-copies.destroy', $lot) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Supprimer ce lot ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-sm btn-outline-danger"
                                            title="Supprimer">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">
                                Aucun lot de copies enregistré
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
    $('#lotCopiesTable').DataTable({
        responsive: false,
        pageLength: 25,
        order: [[0, 'desc']],
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
