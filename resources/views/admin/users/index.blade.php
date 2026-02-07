@extends('layouts.app')

@section('title', 'Gestion des utilisateurs')

@section('content')
<div class="container-fluid">

    {{-- Titre + bouton --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Liste des utilisateurs</h4>
        @php $authUser = auth()->user(); @endphp

        @if(in_array($authUser->type, ['Admin', 'President']))
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nouvel utilisateur
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
            <table id="usersTable" class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Type</th>
                        <th>Établissement</th>
                        <th>Département</th>
                        <th width="180">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->nom_utilisateur }}</td>
                            <td>{{ $user->prenom_utilisateur }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge bg-info">{{ $user->type }}</span>
                            </td>
                            <td>
                                @if($user->etablissement)
                                    <span class="badge bg-secondary">{{ $user->etablissement->sigle }}</span>
                                @endif
                            </td>
                            <td>
                                @if($user->departement)
                                    <span class="badge bg-secondary">{{ $user->departement->sigle }}</span>
                                @endif
                            </td>
                            <td class="text-center">

                                <a href="{{ route('admin.users.show', $user) }}"
                                   class="btn btn-sm btn-outline-info"
                                   title="Voir">
                                    <i class="bi bi-eye-fill"></i>
                                </a>

                                <a href="{{ route('admin.users.edit', $user) }}"
                                   class="btn btn-sm btn-outline-warning"
                                   title="Modifier">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('admin.users.destroy', $user) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Supprimer cet utilisateur ?')">
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
                            <td colspan="8" class="text-center text-muted">
                                Aucun utilisateur enregistré
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
    $('#usersTable').DataTable({
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
