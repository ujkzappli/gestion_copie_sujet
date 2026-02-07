@extends('layouts.app')

@section('title', 'Gestion des établissements')

@section('content')
<div class="container-fluid">

    {{-- Titre + bouton --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Liste des établissements</h4>
        @php $user = auth()->user(); @endphp

        @if(in_array($user->type, ['Admin', 'President']))
            <a href="{{ route('etablissements.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nouvel établissement
            </a>
        @endif

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
            <table id="etablissementTable" class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Sigle</th>
                        <th>Libellé</th>
                        <th width="180">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($etablissements as $etablissement)
                        <tr>
                            <td>{{ $etablissement->id }}</td>
                            <td>
                                <span class="badge bg-info">
                                    {{ $etablissement->sigle }}
                                </span>
                            </td>
                            <td>{{ $etablissement->libelle }}</td>
                            <td class="text-center">

                                <a href="{{ route('etablissements.show', $etablissement) }}"
                                   class="btn btn-sm btn-outline-info"
                                   title="Voir">
                                    <i class="bi bi-eye-fill"></i>
                                </a>

                                <a href="{{ route('etablissements.edit', $etablissement) }}"
                                   class="btn btn-sm btn-outline-warning"
                                   title="Modifier">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('etablissements.destroy', $etablissement) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Supprimer cet établissement ?')">
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
                            <td colspan="4" class="text-center text-muted">
                                Aucun établissement enregistré
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
    $('#etablissementTable').DataTable({
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
