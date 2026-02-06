@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Liste des options</h4>
        <a href="{{ route('options.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Nouvelle option
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
                        <th>Libellé</th>
                        <th>Département</th>
                        <th>Établissement</th>
                        <th>Semestre</th>
                        <th width="160">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($options as $option)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $option->code }}</td>
                            <td>{{ $option->libelle_option }}</td>
                            <td>
                                <span class="badge bg-secondary">
                                    {{ $option->departement->sigle }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-info">
                                    {{ $option->departement->etablissement->sigle }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-success">
                                    {{ $option->semestre->libelle }}
                                </span>
                            </td>
                            <td class="text-center">
                                <!-- Voir -->
                                <a href="{{ route('options.show', $option) }}"
                                   class="btn btn-sm btn-outline-info"
                                   title="Voir">
                                    <i class="bi bi-eye-fill"></i>
                                </a>

                                <!-- Modifier -->
                                <a href="{{ route('options.edit', $option) }}"
                                   class="btn btn-sm btn-outline-warning"
                                   title="Modifier">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <!-- Supprimer -->
                                <form action="{{ route('options.destroy', $option) }}"
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
                            <td colspan="7" class="text-center text-muted">
                                Aucune option enregistrée
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
