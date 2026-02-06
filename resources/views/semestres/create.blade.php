@extends('layouts.app')

@section('title', 'eBazar - Dashboard')

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">Ajouter un semestre</h4>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('semestres.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Numéro</label>
                    <input type="number"
                           name="numero"
                           class="form-control @error('numero') is-invalid @enderror"
                           value="{{ old('numero') }}"
                           required>
                    @error('numero')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Libellé</label>
                    <input type="text"
                           name="libelle"
                           class="form-control @error('libelle') is-invalid @enderror"
                           value="{{ old('libelle') }}"
                           placeholder="Ex : Semestre 1"
                           required>
                    @error('libelle')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('semestres.index') }}" class="btn btn-secondary me-2">
                        Annuler
                    </a>
                    <button class="btn btn-primary">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
