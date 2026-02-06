@extends('layouts.app')

@section('title', 'eBazar - Dashboard')

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">Détails de l’établissement</h4>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-borderless">
                <tr>
                    <th width="150">Sigle :</th>
                    <td>{{ $etablissement->sigle }}</td>
                </tr>
                <tr>
                    <th>Libellé :</th>
                    <td>{{ $etablissement->libelle }}</td>
                </tr>
                <tr>
                    <th>Créé le :</th>
                    <td>{{ $etablissement->created_at->format('d/m/Y') }}</td>
                </tr>
            </table>

            <div class="d-flex justify-content-end">
                <a href="{{ route('etablissements.index') }}" class="btn btn-secondary me-2">
                    Retour
                </a>
                <a href="{{ route('etablissements.edit', $etablissement) }}" class="btn btn-warning">
                    Modifier
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
