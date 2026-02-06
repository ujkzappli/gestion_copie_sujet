@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">Détails de l’option</h4>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-borderless">
                <tr>
                    <th width="200">Code :</th>
                    <td>{{ $option->code }}</td>
                </tr>
                <tr>
                    <th>Libellé :</th>
                    <td>{{ $option->libelle_option }}</td>
                </tr>
                <tr>
                    <th>Département :</th>
                    <td>
                        <span class="badge bg-secondary">
                            {{ $option->departement->sigle }}
                        </span>
                        — {{ $option->departement->libelle }}
                    </td>
                </tr>
                <tr>
                    <th>Établissement :</th>
                    <td>
                        <span class="badge bg-info">
                            {{ $option->departement->etablissement->sigle }}
                        </span>
                        — {{ $option->departement->etablissement->libelle }}
                    </td>
                </tr>
                <tr>
                    <th>Semestre :</th>
                    <td>
                        <span class="badge bg-success">
                            {{ $option->semestre->libelle }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Créée le :</th>
                    <td>{{ $option->created_at->format('d/m/Y') }}</td>
                </tr>
            </table>

            <div class="d-flex justify-content-end">
                <a href="{{ route('options.index') }}"
                   class="btn btn-secondary me-2">Retour</a>
                <a href="{{ route('options.edit', $option) }}"
                   class="btn btn-warning">Modifier</a>
            </div>
        </div>
    </div>
</div>
@endsection
