@extends('layouts.app')

@section('title', 'eBazar - Dashboard')

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">Détails de la session d’examen</h4>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-borderless">
                <tr>
                    <th width="180">Année académique :</th>
                    <td>{{ $session_examen->annee_academique }}</td>
                </tr>
                <tr>
                    <th>Type :</th>
                    <td>{{ ucfirst($session_examen->type) }}</td>
                </tr>
                <tr>
                    <th>Semestre :</th>
                    <td>{{ $session_examen->semestre->libelle }}</td>
                </tr>
                <tr>
                    <th>Créée le :</th>
                    <td>{{ $session_examen->created_at->format('d/m/Y') }}</td>
                </tr>
            </table>

            <div class="d-flex justify-content-end">
                <a href="{{ route('session_examens.index') }}" class="btn btn-secondary me-2">
                    Retour
                </a>
                <a href="{{ route('session_examens.edit', $session_examen) }}" class="btn btn-warning">
                    Modifier
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
