@extends('layouts.app')

@section('title', 'eBazar - Dashboard')

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">Détails du module</h4>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-borderless">
                <tr>
                    <th width="150">Code :</th>
                    <td>{{ $module->code }}</td>
                </tr>
                <tr>
                    <th>Nom :</th>
                    <td>{{ $module->nom }}</td>
                </tr>
                <tr>
                    <th>Semestre :</th>
                    <td>{{ $module->semestre->libelle }}</td>
                </tr>
                <tr>
                    <th>Créé le :</th>
                    <td>{{ $module->created_at->format('d/m/Y') }}</td>
                </tr>
            </table>

            <div class="d-flex justify-content-end">
                <a href="{{ route('modules.index') }}" class="btn btn-secondary me-2">
                    Retour
                </a>
                <a href="{{ route('modules.edit', $module) }}" class="btn btn-warning">
                    Modifier
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
