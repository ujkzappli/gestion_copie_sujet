@extends('layouts.app')

@section('title', 'eBazar - Dashboard')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Liste des départements</h4>
        <a href="{{ route('departements.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Nouveau département
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
                        <th>Code</th>
                        <th>Sigle</th>
                        <th>Libellé</th>
                        <th>Établissement</th>
                        <th width="160">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($departements as $departement)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $departement->code }}</td>
                            <td>{{ $departement->sigle }}</td>
                            <td>{{ $departement->libelle }}</td>
                            <td>
                                <span class="badge bg-info">
                                    {{ $departement->etablissement->sigle }}
                                </span>
                            </td>
                            <td class="text-center">
                                <!-- Voir -->
                                <a href="{{ route('departements.show', $departement) }}"
                                   class="btn btn-sm btn-outline-info"
                                   title="Voir">
                                    <i class="bi bi-eye-fill"></i>
                                </a>

                                <!-- Modifier -->
                                <a href="{{ route('departements.edit', $departement) }}"
                                   class="btn btn-sm btn-outline-warning"
                                   title="Modifier">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <!-- Supprimer -->
                                <form action="{{ route('departements.destroy', $departement) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Supprimer ce département ?')">
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
                            <td colspan="6" class="text-center text-muted">
                                Aucun département enregistré
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
