@extends('layouts.app')

@section('title', 'eBazar - Dashboard')

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">Détails du semestre</h4>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-borderless">
                <tr>
                    <th width="150">Libellé :</th>
                    <td>{{ $semestre->libelle }}</td>
                </tr>
                <tr>
                    <th>Numéro :</th>
                    <td>{{ $semestre->numero }}</td>
                </tr>
                <tr>
                    <th>Créé le :</th>
                    <td>{{ $semestre->created_at->format('d/m/Y') }}</td>
                </tr>
            </table>

            <div class="d-flex justify-content-end">
                <a href="{{ route('semestres.index') }}" class="btn btn-secondary me-2">
                    Retour
                </a>
                <a href="{{ route('semestres.edit', $semestre) }}" class="btn btn-warning">
                    Modifier
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
