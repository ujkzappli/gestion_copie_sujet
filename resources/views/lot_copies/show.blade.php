@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-3">
        <h4>Détails du Lot de Copies</h4>
        <a href="{{ route('lot-copies.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Retour à la liste
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped">
                <tr>
                    <th>Module</th>
                    <td>{{ $lot->module->nom }} ({{ $lot->module->code }})</td>
                </tr>
                <tr>
                    <th>Enseignant</th>
                    <td>{{ $lot->module->enseignant->nom_utilisateur ?? '-' }} {{ $lot->module->enseignant->prenom_utilisateur ?? '' }}</td>
                </tr>
                <tr>
                    <th>Nombre de copies</th>
                    <td>{{ $lot->nombre_copies }}</td>
                </tr>
                <tr>
                    <th>Date disponible</th>
                    <td>{{ $lot->date_disponible->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <th>Date récupération</th>
                    <td>{{ $lot->date_recuperation ? $lot->date_recuperation->format('d/m/Y') : '-' }}</td>
                </tr>
                <tr>
                    <th>Date remise</th>
                    <td>{{ $lot->date_remise ? $lot->date_remise->format('d/m/Y') : '-' }}</td>
                </tr>
                <tr>
                    <th>Statut</th>
                    <td>
                        <span class="badge {{ $lot->statut === 'Valider' ? 'bg-success' : 'bg-danger' }}">
                            {{ $lot->statut }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Créé le</th>
                    <td>{{ $lot->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                <tr>
                    <th>Dernière mise à jour</th>
                    <td>{{ $lot->updated_at->format('d/m/Y H:i') }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection
