@extends('layouts.app')

@section('title', 'eBazar - Dashboard')

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">Ajouter une session d’examen</h4>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('session_examens.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Année académique</label>
                    <input type="text"
                           name="annee_academique"
                           class="form-control @error('annee_academique') is-invalid @enderror"
                           value="{{ old('annee_academique') }}"
                           placeholder="Ex : 2025 - 2026"
                           required>
                    @error('annee_academique')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Type de session</label>
                    <select name="type"
                            class="form-select @error('type') is-invalid @enderror"
                            required>
                        <option value="">-- Choisir un type --</option>
                        @foreach(\App\Models\SessionExamen::TYPES as $type)
                            <option value="{{ $type }}"
                                @selected(old('type') === $type)>
                                {{ ucfirst($type) }}
                            </option>
                        @endforeach
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Semestre</label>
                    <select name="semestre_id"
                            class="form-select @error('semestre_id') is-invalid @enderror"
                            required>
                        <option value="">-- Choisir un semestre --</option>
                        @foreach($semestres as $semestre)
                            <option value="{{ $semestre->id }}"
                                @selected(old('semestre_id') == $semestre->id)>
                                {{ $semestre->libelle }}
                            </option>
                        @endforeach
                    </select>
                    @error('semestre_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('session_examens.index') }}"
                       class="btn btn-secondary me-2">
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
