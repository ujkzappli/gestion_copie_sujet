@extends('layouts.app')

@section('title', 'eBazar - Dashboard')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">Modifier la session</div>
        <div class="card-body">
            <form method="POST" action="{{ route('session_examens.update', $session_examen) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Année académique</label>
                    <input type="text"
                           name="annee_academique"
                           class="form-control @error('annee_academique') is-invalid @enderror"
                           value="{{ old('annee_academique', $session_examen->annee_academique) }}"
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
                        @foreach(\App\Models\SessionExamen::TYPES as $type)
                            <option value="{{ $type }}"
                                @selected(old('type', $session_examen->type) === $type)>
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
                        @foreach($semestres as $semestre)
                            <option value="{{ $semestre->id }}"
                                @selected(old('semestre_id', $session_examen->semestre_id) == $semestre->id)>
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
                        Retour
                    </a>
                    <button class="btn btn-primary">
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
