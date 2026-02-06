@extends('layouts.app')

@section('title', 'eBazar - Dashboard')

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">Modifier le module</h4>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('modules.update', $module) }}">
                @csrf
                @method('PUT')

                {{-- Code du module --}}
                <div class="mb-3">
                    <label class="form-label">Code du module</label>
                    <input type="text"
                           name="code"
                           value="{{ old('code', $module->code) }}"
                           class="form-control @error('code') is-invalid @enderror"
                           required>
                    @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Nom du module --}}
                <div class="mb-3">
                    <label class="form-label">Nom du module</label>
                    <input type="text"
                           name="nom"
                           value="{{ old('nom', $module->nom) }}"
                           class="form-control @error('nom') is-invalid @enderror"
                           required>
                    @error('nom')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Semestre --}}
                <div class="mb-3">
                    <label class="form-label">Semestre</label>
                    <select name="semestre_id"
                            class="form-select @error('semestre_id') is-invalid @enderror"
                            required>
                        <option value="">-- Choisir un semestre --</option>
                        @foreach($semestres as $semestre)
                            <option value="{{ $semestre->id }}"
                                @selected(old('semestre_id', $module->semestre_id) == $semestre->id)>
                                {{ $semestre->libelle }}
                            </option>
                        @endforeach
                    </select>
                    @error('semestre_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Enseignant --}}
                <div class="mb-3">
                    <label class="form-label">Enseignant</label>
                    <select name="enseignant_id"
                            class="form-select @error('enseignant_id') is-invalid @enderror"
                            required>
                        <option value="">-- Choisir un enseignant --</option>
                        @foreach($enseignants as $enseignant)
                            <option value="{{ $enseignant->id }}"
                                @selected(old('enseignant_id', $module->enseignant_id) == $enseignant->id)>
                                {{ $enseignant->nom_utilisateur }} {{ $enseignant->prenom_utilisateur }}
                            </option>
                        @endforeach
                    </select>
                    @error('enseignant_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Boutons --}}
                <div class="d-flex justify-content-end">
                    <a href="{{ route('modules.index') }}" class="btn btn-secondary me-2">
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
