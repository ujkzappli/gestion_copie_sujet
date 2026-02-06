@extends('layouts.app')

@section('title', 'eBazar - Dashboard')

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">Ajouter un module</h4>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('modules.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Code du module</label>
                    <input type="text"
                           name="code"
                           class="form-control @error('code') is-invalid @enderror"
                           value="{{ old('code') }}"
                           required>
                    @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Nom du module</label>
                    <input type="text"
                           name="nom"
                           class="form-control @error('nom') is-invalid @enderror"
                           value="{{ old('nom') }}"
                           required>
                    @error('nom')
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

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Enseignant</label>
                        <select name="enseignant_id" id="enseignant_id" class="form-select" required>
                            <option value="">-- Choisir --</option>
                            @foreach($enseignants as $enseignant)
                                <option value="{{ $enseignant->id }}">
                                    {{ $enseignant->nom_utilisateur }} {{ $enseignant->prenom_utilisateur }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('modules.index') }}" class="btn btn-secondary me-2">
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

<script>
    const moduleSelect = document.getElementById('module_id');
    const enseignantSelect = document.getElementById('enseignant_id');

    moduleSelect.addEventListener('change', function() {
        const selectedOption = moduleSelect.options[moduleSelect.selectedIndex];
        const enseignantId = selectedOption.getAttribute('data-enseignant-id');

        // Si le module a un enseignant, on le sélectionne dans le select enseignant
        if (enseignantId) {
            enseignantSelect.value = enseignantId;
        } else {
            enseignantSelect.value = '';
        }
    });
</script>
@endsection
