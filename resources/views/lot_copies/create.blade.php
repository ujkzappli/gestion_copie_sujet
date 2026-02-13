@extends('layouts.app')

@section('title', 'Créer un lot de copies')

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">Créer un lot de copies</h4>

    <form action="{{ route('lot-copies.store') }}" method="POST">
        @csrf

        <div class="row">
            {{-- Année académique --}}
            <div class="col-md-3 mb-3">
                <label>Année académique</label>
                <select name="annee_academique" class="form-control" required>
                    @foreach($annees as $annee)
                        <option value="{{ $annee }}">{{ $annee }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Session d'examen --}}
            <div class="col-md-3 mb-3">
                <label>Session d'examen</label>
                <select name="session_type" class="form-control" required>
                    @foreach($sessions as $session)
                        <option value="{{ $session }}">{{ ucfirst($session) }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Semestre --}}
            <div class="col-md-3 mb-3">
                <label>Niveau</label>
                <select name="semestre_id" class="form-control" required>
                    @foreach($semestres as $semestre)
                        <option value="{{ $semestre->id }}">{{ $semestre->code }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Option --}}
            <div class="col-md-3 mb-3">
                <label>Parcours</label>
                <select name="option_id" id="option_id" class="form-control" required>
                    <option value="">-- Choisir un parcours --</option>
                    @foreach($options as $option)
                        <option value="{{ $option->id }}">{{ $option->libelle_option }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Module --}}
        <div class="mb-3">
            <label>Module</label>
            <select name="module_id" id="module_id" class="form-control" required>
                <option value="">-- Choisir un module --</option>
                {{-- Options seront remplies dynamiquement via JS --}}
            </select>
        </div>

        {{-- Enseignant (readonly) --}}
        <div class="mb-3">
            <label>Enseignant</label>
            <input type="text" id="enseignant" class="form-control" readonly>
            <input type="hidden" name="enseignant_id" id="enseignant_id_hidden">
        </div>

        <div class="row">
            {{-- Nombre de copies --}}
            <div class="col-md-4 mb-3">
                <label>Nombre de copies</label>
                <input type="number" name="nombre_copies" class="form-control" required value="{{ old('nombre_copies') }}">
            </div>

            {{-- Date disponible --}}
            <div class="col-md-4 mb-3">
                <label>Date disponible</label>
                <input type="date" name="date_disponible" class="form-control" required value="{{ old('date_disponible') }}">
            </div>
        </div>

        <div class="mt-3 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Créer le lot</button>
            <a href="{{ route('lot-copies.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>

<script>
    // Modules envoyés depuis le controller
    const modules = @json($modules);
    const optionSelect = document.getElementById('option_id');
    const moduleSelect = document.getElementById('module_id');
    const enseignantInput = document.getElementById('enseignant');
    const enseignantHidden = document.getElementById('enseignant_id_hidden');

    // Filtrage des modules selon l'option sélectionnée
    optionSelect.addEventListener('change', function() {
        const optionId = parseInt(this.value);
        moduleSelect.innerHTML = '<option value="">-- Choisir un module --</option>';
        enseignantInput.value = '';
        enseignantHidden.value = '';

        modules.forEach(mod => {
            // Vérifie si le module appartient à l'option sélectionnée
            if (mod.semestre.options.some(o => o.id === optionId)) {
                const opt = document.createElement('option');
                opt.value = mod.id;
                opt.textContent = mod.nom + (mod.code ? ` (${mod.code})` : '');
                opt.dataset.enseignant = mod.enseignant ? `${mod.enseignant.nom_utilisateur} ${mod.enseignant.prenom_utilisateur} - ${mod.enseignant.matricule_utilisateur}` : '';
                opt.dataset.enseignantId = mod.enseignant ? mod.enseignant.id : '';
                moduleSelect.appendChild(opt);
            }
        });
    });

    // Remplissage automatique de l'enseignant selon le module choisi
    moduleSelect.addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        enseignantInput.value = selected.dataset.enseignant || '';
        enseignantHidden.value = selected.dataset.enseignantId || '';
    });
</script>
@endsection
