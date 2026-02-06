@extends('layouts.app')

@section('title', 'eBazar - Dashboard')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">Modifier l’option</div>
        <div class="card-body">
            <form action="{{ route('options.update', $option) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Code</label>
                        <input type="number" name="code"
                               class="form-control @error('code') is-invalid @enderror"
                               value="{{ old('code', $option->code) }}" required>
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-8 mb-3">
                        <label class="form-label">Libellé de l’option</label>
                        <input type="text" name="libelle_option"
                               class="form-control @error('libelle_option') is-invalid @enderror"
                               value="{{ old('libelle_option', $option->libelle_option) }}" required>
                        @error('libelle_option')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Département</label>
                    <select name="departement_id"
                            class="form-select @error('departement_id') is-invalid @enderror" required>
                        @foreach($departements as $departement)
                            <option value="{{ $departement->id }}"
                                @selected($option->departement_id == $departement->id)>
                                {{ $departement->sigle }} — {{ $departement->libelle }}
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
                            class="form-select @error('semestre_id') is-invalid @enderror" required>
                        @foreach($semestres as $semestre)
                            <option value="{{ $semestre->id }}"
                                @selected($option->semestre_id == $semestre->id)>
                                {{ $semestre->libelle }}
                            </option>
                        @endforeach
                    </select>
                    @error('semestre_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('options.index') }}" class="btn btn-secondary me-2">Retour</a>
                    <button class="btn btn-primary">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
