@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Modules</h4>
        <a href="{{ route('modules.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Nouveau module
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Code</th>
                        <th>Nom</th>
                        <th>Semestre</th>
                        <th width="140">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($modules as $module)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $module->code }}</td>
                            <td>{{ $module->nom }}</td>
                            <td>
                                <span class="badge bg-success">
                                    {{ $module->semestre->libelle }}
                                </span>
                            </td>
                            <td class="text-center">
                                <!-- Voir -->
                                <a href="{{ route('modules.show', $module) }}"
                                   class="btn btn-sm btn-outline-info"
                                   title="Voir">
                                    <i class="bi bi-eye-fill"></i>
                                </a>

                                <!-- Modifier -->
                                <a href="{{ route('modules.edit', $module) }}"
                                   class="btn btn-sm btn-outline-warning"
                                   title="Modifier">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('modules.destroy', $module) }}"
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
                                Aucun module enregistré
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
