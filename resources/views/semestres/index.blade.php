@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Semestres</h4>
        <a href="{{ route('semestres.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Nouveau semestre
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Numéro</th>
                        <th>Libellé</th>
                        <th width="140">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($semestres as $semestre)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <span class="badge bg-secondary">
                                    S{{ $semestre->numero }}
                                </span>
                            </td>
                            <td>{{ $semestre->libelle }}</td>
                            <td class="text-center">
                                <!-- Voir -->
                                <a href="{{ route('semestres.show', $semestre) }}"
                                   class="btn btn-sm btn-outline-info"
                                   title="Voir">
                                    <i class="bi bi-eye-fill"></i>
                                </a>

                                <!-- Modifier -->
                                <a href="{{ route('semestres.edit', $semestre) }}"
                                   class="btn btn-sm btn-outline-warning"
                                   title="Modifier">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('semestres.destroy', $semestre) }}"
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
                            <td colspan="4" class="text-center text-muted">
                                Aucun semestre enregistré
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
