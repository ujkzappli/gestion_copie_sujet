@extends('layouts.app')

@section('title', 'Gestion des lots de copies')

@section('content')
<div class="container-fluid">

    {{-- Titre + bouton --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Liste des lots de copies</h4>

        @php
            $user = auth()->user();
        @endphp

        @if(!in_array($user->type, ['Enseignant']))
            <a href="{{ route('lot-copies.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nouveau lot
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
            <table id="lotCopiesTable" class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Module</th>
                        <th>Enseignant</th>
                        <th>Copies</th>
                        <th>Date disponible</th>
                        <th>Date limite récupération</th>
                        <th>Date réelle récupération</th>
                        <th>Date limite remise</th>
                        <th>Date réelle remise</th>
                        <th>Progression</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lotCopies as $lot)
                        @php
                            // Dates limites calculées
                            $dateLimiteRecup = $lot->date_disponible ? $lot->date_disponible->copy()->addDays(2) : null;
                            $dateLimiteRemise = $dateLimiteRecup ? $dateLimiteRecup->copy()->addDays(3) : null;

                            // Statut pour couleurs
                            $statutRecup = $lot->date_recuperation
                                ? ($lot->date_recuperation <= $dateLimiteRecup ? 'on-time' : 'late')
                                : 'pending';
                            $statutRemise = $lot->date_remise
                                ? ($lot->date_remise <= $dateLimiteRemise ? 'on-time' : 'late')
                                : 'pending';

                            // Progression barres
                            $progressRecup = $lot->date_recuperation ? 50 : 0;
                            $progressRemise = $lot->date_remise ? 50 : 0;
                        @endphp

                        <tr>
                            <td>{{ $lot->id }}</td>
                            <td>{{ $lot->module->nom ?? '' }}</td>
                            <td>{{ $lot->module->enseignant?->prenom_utilisateur }} {{ $lot->module->enseignant?->nom_utilisateur }} - {{ $lot->module->enseignant?->matricule_utilisateur }}</td>
                            <td>{{ $lot->nombre_copies }}</td>
                            <td>{{ $lot->date_disponible?->format('d/m/Y') }}</td>
                            <td>{{ $dateLimiteRecup?->format('d/m/Y') }}</td>
                            <td>{{ $lot->date_recuperation?->format('d/m/Y') ?? '' }}</td>
                            <td>{{ $dateLimiteRemise?->format('d/m/Y') }}</td>
                            <td>{{ $lot->date_remise?->format('d/m/Y') ?? '' }}</td>
                            <td style="width:200px;">
                                <div class="progress" style="height:20px;">
                                    {{-- Barre récupération --}}
                                    <div class="progress-bar @if($statutRecup=='on-time') bg-primary
                                                               @elseif($statutRecup=='late') bg-danger
                                                               @else bg-secondary @endif"
                                         role="progressbar"
                                         style="width: {{ $progressRecup }}%">
                                    </div>

                                    {{-- Barre remise --}}
                                    <div class="progress-bar @if($statutRemise=='on-time') bg-success
                                                               @elseif($statutRemise=='late') bg-danger
                                                               @else bg-secondary @endif"
                                         role="progressbar"
                                         style="width: {{ $progressRemise }}%">
                                    </div>
                                </div>
                                <small>
                                    @if($statutRecup=='pending' || $statutRemise=='pending')
                                        En cours
                                    @elseif($statutRecup=='on-time' && $statutRemise=='on-time')
                                        Terminé
                                    @else
                                        Retard
                                    @endif
                                </small>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('lot-copies.edit', $lot) }}"
                                   class="btn btn-sm btn-outline-warning"
                                   title="Modifier">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                @if(!in_array($user->type, ['Enseignant']))
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
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center text-muted">
                                Aucun lot enregistré
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
