@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Sessions d’examen</h4>
        <a href="{{ route('session_examens.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Nouvelle session
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Année</th>
                        <th>Type</th>
                        <th>Semestre</th>
                        <th width="140">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sessions as $session)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $session->annee_academique }}</td>
                            <td>{{ ucfirst($session->type) }}</td>
                            <td>
                                <span class="badge bg-success">
                                    {{ $session->semestre->libelle }}
                                </span>
                            </td>
                            <td class="text-center">
                                <!-- Voir -->
                                <a href="{{ route('session_examens.show', $session) }}"
                                   class="btn btn-sm btn-outline-info"
                                   title="Voir">
                                    <i class="bi bi-eye-fill"></i>
                                </a>

                                <!-- Modifier -->
                                <a href="{{ route('session_examens.edit', $session) }}"
                                   class="btn btn-sm btn-outline-warning"
                                   title="Modifier">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('session_examens.destroy', $session) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Supprimer cette option ?')">
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
                            <td colspan="5" class="text-center text-muted">
                                Aucune session enregistrée
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
