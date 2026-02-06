@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Liste des Lots de Copies</h4>
        <a href="{{ route('lot-copies.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nouveau lot
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Module</th>
                        <th>Enseignant</th>
                        <th>Nombre de copies</th>
                        <th>Date disponible</th>
                        <th>Date récupération</th>
                        <th>Date remise</th>
                        <th>Statut</th>
                        <th width="180">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lots as $lot)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $lot->module->nom }} ({{ $lot->module->code }})</td>
                            <td>{{ $lot->module->enseignant->nom_utilisateur ?? '-' }} {{ $lot->module->enseignant->prenom_utilisateur ?? '' }}</td>
                            <td>{{ $lot->nombre_copies }}</td>
                            <td>{{ $lot->date_disponible->format('d/m/Y') }}</td>
                            <td>{{ $lot->date_recuperation ? $lot->date_recuperation->format('d/m/Y') : '-' }}</td>
                            <td>{{ $lot->date_remise ? $lot->date_remise->format('d/m/Y') : '-' }}</td>
                            <td>
                                <span class="badge {{ $lot->statut === 'Valider' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $lot->statut }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('lot-copies.show', $lot) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                <a href="{{ route('lot-copies.edit', $lot) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('lot-copies.destroy', $lot) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">Aucun lot de copies enregistré</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
