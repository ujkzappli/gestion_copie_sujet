@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">Ajouter une option</h4>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('options.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Code</label>
                        <input type="number" name="code"
                               class="form-control @error('code') is-invalid @enderror"
                               value="{{ old('code') }}">
                        @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-8 mb-3">
                        <label class="form-label">Libellé de l’option</label>
                        <input type="text" name="libelle_option"
                               class="form-control @error('libelle_option') is-invalid @enderror"
                               value="{{ old('libelle_option') }}">
                        @error('libelle_option')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Département</label>
                    <select name="departement_id"
                            class="form-select @error('departement_id') is-invalid @enderror">
                        <option value="">-- Choisir un département --</option>
                        @foreach($departements as $departement)
                            <option value="{{ $departement->id }}"
                                {{ old('departement_id') == $departement->id ? 'selected' : '' }}>
                                {{ $departement->sigle }}
                                — {{ $departement->libelle }}
                                ({{ $departement->etablissement->sigle }})
                            </option>
                        @endforeach
                    </select>
                    @error('departement_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Semestre</label>
                    <select name="semestre_id"
                            class="form-select @error('semestre_id') is-invalid @enderror">
                        <option value="">-- Choisir un semestre --</option>
                        @foreach($semestres as $semestre)
                            <option value="{{ $semestre->id }}"
                                {{ old('semestre_id') == $semestre->id ? 'selected' : '' }}>
                                {{ $semestre->libelle }}
                            </option>
                        @endforeach
                    </select>
                    @error('semestre_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('options.index') }}"
                       class="btn btn-secondary me-2">Annuler</a>
                    <button class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
