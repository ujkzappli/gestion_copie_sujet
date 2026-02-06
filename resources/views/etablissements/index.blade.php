@extends('layouts.app')

@section('title', 'eBazar - Dashboard')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Liste des établissements</h4>
        <a href="{{ route('etablissements.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nouvel établissement
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
                        <th>Sigle</th>
                        <th>Libellé</th>
                        <th width="180">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($etablissements as $etablissement)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $etablissement->sigle }}</td>
                            <td>{{ $etablissement->libelle }}</td>
                            

                            <td class="text-center">
                                <a href="{{ route('etablissements.show', $etablissement) }}"
                                class="btn btn-sm btn-outline-primary"
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
                                    onsubmit="return confirm('Confirmer la suppression ?')">
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
