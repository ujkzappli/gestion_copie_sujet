@extends('layouts.app')

@section('title', 'eBazar - Dashboard')

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">Modifier l’établissement</h4>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('etablissements.update', $etablissement) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Sigle</label>
                    <input type="text"
                           name="sigle"
                           class="form-control @error('sigle') is-invalid @enderror"
                           value="{{ old('sigle', $etablissement->sigle) }}">
                    @error('sigle')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Libellé</label>
                    <input type="text"
                           name="libelle"
                           class="form-control @error('libelle') is-invalid @enderror"
                           value="{{ old('libelle', $etablissement->libelle) }}">
                    @error('libelle')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('etablissements.index') }}" class="btn btn-secondary me-2">
                        Retour
                    </a>
                    <button class="btn btn-warning">
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
