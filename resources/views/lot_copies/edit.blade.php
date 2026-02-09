@extends('layouts.app')

@section('title', 'eBazar - Modifier un lot de copies')

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">Modifier le lot de copies</h4>

    <form method="POST" action="{{ route('lot-copies.update', $lot_copy) }}">
        @csrf
        @method('PUT')

        <div class="row">
            {{-- Sélection du module --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Module</label>
                <select name="module_id" id="module_id"
                        class="form-select @error('module_id') is-invalid @enderror"
                        required>
                    <option value="">-- Choisir --</option>
                    @foreach($modules as $module)
                        <option value="{{ $module->id }}"
                            data-enseignant="{{ $module->enseignant->nom_utilisateur ?? '' }} {{ $module->enseignant->prenom_utilisateur ?? '' }}"
                            data-enseignant-id="{{ $module->enseignant->id ?? '' }}"
                            @selected($module->id === $lot_copy->module_id)>
                            {{ $module->nom }} ({{ $module->code }})
                        </option>
                    @endforeach
                </select>
                @error('module_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Affichage de l'enseignant (readonly) --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Enseignant</label>
                <input type="text" id="enseignant" class="form-control" readonly
                    value="{{ optional($lot_copy->module->enseignant)->nom_utilisateur }} {{ optional($lot_copy->module->enseignant)->prenom_utilisateur }}">
                <input type="hidden" name="enseignant_id" id="enseignant_id_hidden"
                    value="{{ old('enseignant_id', $lot_copy->module->enseignant->id ?? '') }}">
            </div>

            {{-- Nombre de copies --}}
            <div class="col-md-4 mb-3">
                <label class="form-label">Nombre de copies</label>
                <input type="number" name="nombre_copies"
                       class="form-control @error('nombre_copies') is-invalid @enderror"
                       required
                       value="{{ old('nombre_copies', $lot_copy->nombre_copies) }}">
                @error('nombre_copies')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Date de dépôt --}}
            <div class="col-md-4 mb-3">
                <label class="form-label">Date de dépôt</label>
                <input type="date" name="date_disponible"
                       id="date_depot"
                       class="form-control @error('date_disponible') is-invalid @enderror"
                       required
                       value="{{ old('date_disponible', $lot_copy->date_disponible?->format('Y-m-d')) }}">
                @error('date_disponible')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Dates provisoires (readonly) --}}
            <div class="col-md-4 mb-3">
                <label class="form-label">Date provisoire de récupération</label>
                <input type="date" id="date_recuperation_prov" class="form-control" readonly>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Date provisoire de remise</label>
                <input type="date" id="date_remise_prov" class="form-control" readonly>
            </div>

            {{-- Dates réelles (utilisateur peut modifier) --}}
            <div class="col-md-4 mb-3">
                <label class="form-label">Date réelle de récupération</label>
                <input type="date" name="date_recuperation"
                       id="date_recuperation"
                       class="form-control @error('date_recuperation') is-invalid @enderror"
                       value="{{ old('date_recuperation', $lot_copy->date_recuperation?->format('Y-m-d')) }}">
                @error('date_recuperation')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Date réelle de remise</label>
                <input type="date" name="date_remise"
                       id="date_remise"
                       class="form-control @error('date_remise') is-invalid @enderror"
                       value="{{ old('date_remise', $lot_copy->date_remise?->format('Y-m-d')) }}">
                @error('date_remise')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <a href="{{ route('lot-copies.index') }}" class="btn btn-secondary me-2">
                Annuler
            </a>
            <button class="btn btn-primary">Mettre à jour</button>
        </div>
    </form>
</div>

<script>
document.getElementById('module_id').addEventListener('change', function () {
    let selected = this.options[this.selectedIndex];

    let enseignantName = selected.dataset.enseignant || '';
    let enseignantId   = selected.dataset.enseignantId || '';

    document.getElementById('enseignant').value = enseignantName;
    document.getElementById('enseignant_id_hidden').value = enseignantId;
});

// Recalcul automatique des dates provisoires quand on modifie la date de dépôt
function updateProvisionalDates() {
    let depot = new Date(document.getElementById('date_depot').value);
    if (!isNaN(depot)) {
        let recupProv = new Date(depot);
        recupProv.setDate(recupProv.getDate() + 2);
        document.getElementById('date_recuperation_prov').valueAsDate = recupProv;

        let remiseProv = new Date(recupProv);
        remiseProv.setDate(remiseProv.getDate() + 3);
        document.getElementById('date_remise_prov').valueAsDate = remiseProv;
    } else {
        document.getElementById('date_recuperation_prov').value = '';
        document.getElementById('date_remise_prov').value = '';
    }
}

// Initialisation au chargement de la page
updateProvisionalDates();

document.getElementById('date_depot').addEventListener('change', updateProvisionalDates);
</script>
@endsection
