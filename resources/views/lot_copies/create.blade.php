@extends('layouts.app')

@section('title', 'eBazar - Créer un lot de copies')

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">Créer un lot de copies</h4>

    <form action="{{ route('lot-copies.store') }}" method="POST">
        @csrf

        <div class="row">
            {{-- Sélection du module --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Module</label>
                <select name="module_id" id="module_id" class="form-select" required>
                    <option value="">-- Choisir --</option>
                    @foreach($modules as $module)
                        <option value="{{ $module->id }}"
                            data-enseignant="{{ $module->enseignant?->nom_utilisateur }} {{ $module->enseignant?->prenom_utilisateur }}"
                            data-enseignant-id="{{ $module->enseignant?->id }}">
                            {{ $module->nom }} ({{ $module->code ?? '' }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Enseignant (readonly) --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Enseignant</label>
                <input type="text" id="enseignant" class="form-control" readonly>
                <input type="hidden" name="enseignant_id" id="enseignant_id_hidden">
            </div>

            {{-- Nombre de copies --}}
            <div class="col-md-4 mb-3">
                <label class="form-label">Nombre de copies</label>
                <input type="number" name="nombre_copies" class="form-control" required value="{{ old('nombre_copies') }}">
            </div>

            {{-- Date de dépôt --}}
            <div class="col-md-4 mb-3">
                <label class="form-label">Date de dépôt</label>
                <input type="date" name="date_disponible" id="date_depot" class="form-control" required value="{{ old('date_disponible') }}">
            </div>
        </div>

        <div class="mt-3 d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                Enregistrer
            </button>

            <a href="{{ route('lot-copies.index') }}" class="btn btn-secondary">
                Annuler
            </a>
        </div>

    </form>
</div>

<script>
    // Remplissage automatique de l'enseignant
    document.getElementById('module_id').addEventListener('change', function () {
        let selectedOption = this.options[this.selectedIndex];
        document.getElementById('enseignant').value = selectedOption.dataset.enseignant || '';
        document.getElementById('enseignant_id_hidden').value = selectedOption.dataset.enseignantId || '';
    });
</script>
@endsection
