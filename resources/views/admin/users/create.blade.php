@extends('layouts.app')

@section('title', 'Créer un utilisateur')

@section('content')
<div class="container-fluid py-4">
    <h4 class="mb-3">Créer un utilisateur</h4>

    <div class="card shadow-sm">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session('success') }}</strong> a été créé avec succès !
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf

                {{-- Nom --}}
                <div class="mb-3">
                    <label class="form-label">Nom</label>
                    <input type="text" name="nom_utilisateur"
                           class="form-control @error('nom_utilisateur') is-invalid @enderror"
                           value="{{ old('nom_utilisateur') }}" required>
                    @error('nom_utilisateur')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Prénom --}}
                <div class="mb-3">
                    <label class="form-label">Prénom</label>
                    <input type="text" name="prenom_utilisateur"
                           class="form-control @error('prenom_utilisateur') is-invalid @enderror"
                           value="{{ old('prenom_utilisateur') }}" required>
                    @error('prenom_utilisateur')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Matricule --}}
                <div class="mb-3">
                    <label class="form-label">Matricule</label>
                    <input type="text" name="matricule_utilisateur"
                           class="form-control @error('matricule_utilisateur') is-invalid @enderror"
                           value="{{ old('matricule_utilisateur') }}" required>
                    @error('matricule_utilisateur')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Type --}}
                <div class="mb-3">
                    <label class="form-label">Type de compte</label>
                    <select name="type" id="type"
                            class="form-select @error('type') is-invalid @enderror"
                            onchange="handleTypeChange()" required>
                        <option value="">-- Sélectionner un type --</option>
                        <option value="DA" @selected(old('type')=='DA')>DA</option>
                        <option value="CS" @selected(old('type')=='CS')>CS</option>
                        <option value="CD" @selected(old('type')=='CD')>CD</option>
                        <option value="Enseignant" @selected(old('type')=='Enseignant')>Enseignant</option>
                        <option value="President" @selected(old('type')=='President')>President</option>
                        <option value="Admin" @selected(old('type')=='Admin')>Admin</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Établissement --}}
                <div class="mb-3" id="etablissement-field" style="display:none;">
                    <label class="form-label">Établissement</label>
                    <select name="etablissement_id" id="etablissement-select"
                            class="form-select @error('etablissement_id') is-invalid @enderror"
                            onchange="filterDepartements()">
                        <option value="">-- Sélectionner un établissement --</option>
                        @foreach($etablissements as $etablissement)
                            <option value="{{ $etablissement->id }}"
                                @selected(old('etablissement_id') == $etablissement->id)>
                                {{ $etablissement->sigle }} - {{ $etablissement->nom }}
                            </option>
                        @endforeach
                    </select>
                    @error('etablissement_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Département --}}
                <div class="mb-3" id="departement-field" style="display:none;">
                    <label class="form-label">Département</label>
                    <select name="departement_id" id="departement-select"
                            class="form-select @error('departement_id') is-invalid @enderror">
                        <option value="">-- Sélectionner un département --</option>
                        @foreach($departements as $departement)
                            <option value="{{ $departement->id }}"
                                data-etablissement="{{ $departement->etablissement_id }}"
                                @selected(old('departement_id') == $departement->id)>
                                {{ $departement->sigle }} - {{ $departement->nom }}
                            </option>
                        @endforeach
                    </select>
                    @error('departement_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.users.create') }}" class="btn btn-secondary me-2">Annuler</a>
                    <button type="submit" class="btn btn-primary">Créer l'utilisateur</button>
                </div>

                <div class="mb-3">
                    <a href="{{ route('admin.users.import.form') }}" class="btn btn-success">
                        Importer des utilisateurs (CSV)
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function handleTypeChange() {
    const type = document.getElementById('type').value;

    const etablissementField = document.getElementById('etablissement-field');
    const departementField = document.getElementById('departement-field');

    const etablissementInput = document.getElementById('etablissement-select');
    const departementInput = document.getElementById('departement-select');

    // Reset total
    etablissementField.style.display = 'none';
    departementField.style.display = 'none';

    etablissementInput.required = false;
    departementInput.required = false;

    // DA / CS → seulement établissement
    if (type === 'DA' || type === 'CS') {
        etablissementField.style.display = 'block';
        etablissementInput.required = true;
    }

    // CD / Enseignant → établissement d'abord
    if (type === 'CD' || type === 'Enseignant') {
        etablissementField.style.display = 'block';
        etablissementInput.required = true;

        // département seulement si établissement choisi
        if (etablissementInput.value) {
            departementField.style.display = 'block';
            departementInput.required = true;
        }
    }

    filterDepartements();
}

function filterDepartements() {
    const etablissementId = document.getElementById('etablissement-select').value;
    const departementField = document.getElementById('departement-field');
    const departementSelect = document.getElementById('departement-select');
    const type = document.getElementById('type').value;

    // Filtrer les départements
    departementSelect.querySelectorAll('option').forEach(option => {
        if (!option.value) return;
        option.style.display =
            option.dataset.etablissement === etablissementId ? 'block' : 'none';
    });

    // Afficher le département uniquement pour CD / Enseignant
    if ((type === 'CD' || type === 'Enseignant') && etablissementId) {
        departementField.style.display = 'block';
        departementSelect.required = true;
    } else {
        departementField.style.display = 'none';
        departementSelect.required = false;
        departementSelect.value = '';
    }
}

// Au chargement (old values)
document.addEventListener('DOMContentLoaded', () => {
    handleTypeChange();
});
</script>

@endsection
