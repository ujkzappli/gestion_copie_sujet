@extends('layouts.app')

@section('title', 'eBazar - Dashboard')

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">Détails du département</h4>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-borderless">
                <tr>
                    <th width="180">Code :</th>
                    <td>{{ $departement->code }}</td>
                </tr>
                <tr>
                    <th>Sigle :</th>
                    <td>{{ $departement->sigle }}</td>
                </tr>
                <tr>
                    <th>Libellé :</th>
                    <td>{{ $departement->libelle }}</td>
                </tr>
                <tr>
                    <th>Établissement :</th>
                    <td>
                        <span class="badge bg-info">
                            {{ $departement->etablissement->sigle }}
                        </span>
                        — {{ $departement->etablissement->libelle }}
                    </td>
                </tr>
                <tr>
                    <th>Créé le :</th>
                    <td>{{ $departement->created_at->format('d/m/Y') }}</td>
                </tr>
            </table>

            <div class="d-flex justify-content-end">
                <a href="{{ route('departements.index') }}"
                   class="btn btn-secondary me-2">Retour</a>
                <a href="{{ route('departements.edit', $departement) }}"
                   class="btn btn-warning">Modifier</a>
            </div>
        </div>
    </div>
</div>
@endsection
