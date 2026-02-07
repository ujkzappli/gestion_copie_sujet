@extends('layouts.app')

@section('title', 'Détails de l\'utilisateur')

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">Détails de l'utilisateur</h4>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-borderless">
                <tr>
                    <th width="180">Nom :</th>
                    <td>{{ $user->nom_utilisateur }}</td>
                </tr>
                <tr>
                    <th>Prénom :</th>
                    <td>{{ $user->prenom_utilisateur }}</td>
                </tr>
                <tr>
                    <th>Email :</th>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <th>Matricule :</th>
                    <td>{{ $user->matricule_utilisateur }}</td>
                </tr>
                <tr>
                    <th>Type :</th>
                    <td>{{ $user->type }}</td>
                </tr>
                <tr>
                    <th>Établissement :</th>
                    <td>
                        @if($user->etablissement)
                            <span class="badge bg-info">
                                {{ $user->etablissement->sigle }}
                            </span>
                            — {{ $user->etablissement->libelle }}
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Département :</th>
                    <td>
                        @if($user->departement)
                            <span class="badge bg-secondary">
                                {{ $user->departement->sigle }}
                            </span>
                            — {{ $user->departement->libelle }}
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Créé le :</th>
                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                </tr>
            </table>

            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary me-2">Retour</a>
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">Modifier</a>
            </div>
        </div>
    </div>
</div>
@endsection
