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
                <label>Module</label>
                <select name="module_id" id="module_id" class="form-select" required>
                    <option value="">-- Choisir --</option>
                    @foreach($modules as $module)
                        <option value="{{ $module->id }}"
                            data-enseignant="{{ $module->enseignant->nom_utilisateur }} {{ $module->enseignant->prenom_utilisateur }}"
                            data-enseignant-id="{{ $module->enseignant->id }}">
                            {{ $module->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Affichage de l'enseignant (readonly) et champ caché pour l'envoi --}}
            <div class="col-md-6 mb-3">
                <label>Enseignant</label>
                <input type="text" id="enseignant" class="form-control" readonly>
                <input type="hidden" name="enseignant_id" id="enseignant_id_hidden">
            </div>

            {{-- Nombre de copies --}}
            <div class="col-md-4 mb-3">
                <label>Nombre de copies</label>
                <input type="number" name="nombre_copies" class="form-control" required value="{{ old('nombre_copies') }}">
            </div>

            {{-- Date de dépôt --}}
            <div class="col-md-4 mb-3">
                <label>Date de dépôt</label>
                <input type="date" name="date_disponible" id="date_depot" class="form-control" required value="{{ old('date_disponible') }}">
            </div>

            {{-- Date de récupération --}}
            <div class="col-md-4 mb-3">
                <label>Date de récupération</label>
                <input type="date" name="date_recuperation" id="date_recuperation" class="form-control" value="{{ old('date_recuperation') }}">
            </div>

            {{-- Date de remise --}}
            <div class="col-md-4 mb-3">
                <label>Date de remise</label>
                <input type="date" name="date_remise" id="date_remise" class="form-control" value="{{ old('date_remise') }}">
            </div>
        </div>

        <button class="btn btn-primary">Enregistrer</button>
    </form>
</div>

<script>
document.getElementById('module_id').addEventListener('change', function () {
    let selectedOption = this.options[this.selectedIndex];

    // Remplissage automatique du champ enseignant
    let enseignantName = selectedOption.dataset.enseignant || '';
    let enseignantId = selectedOption.dataset.enseignantId || '';

    document.getElementById('enseignant').value = enseignantName;
    document.getElementById('enseignant_id_hidden').value = enseignantId;
});

// Calcul automatique des dates de récupération et remise
document.getElementById('date_depot').addEventListener('change', function () {
    let depot = new Date(this.value);
    if (!isNaN(depot)) {
        let recup = new Date(depot);
        recup.setDate(recup.getDate() + 2);

        let remise = new Date(recup);
        remise.setDate(remise.getDate() + 3);

        document.getElementById('date_recuperation').valueAsDate = recup;
        document.getElementById('date_remise').valueAsDate = remise;
    }
});
</script>
@endsection
