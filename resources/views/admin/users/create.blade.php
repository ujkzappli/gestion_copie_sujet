@extends('layouts.app')

@section('title', 'Créer un utilisateur')

@push('styles')
<style>
.page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 15px;
    padding: 25px;
    color: white;
    margin-bottom: 25px;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
}
.form-card {
    background: white;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
}
.form-card:hover {
    box-shadow: 0 4px 20px rgba(0,0,0,0.12);
}
.section-divider {
    border-top: 2px solid #f1f3f5;
    margin: 25px 0;
    position: relative;
}
.section-divider-title {
    position: absolute;
    top: -12px;
    left: 20px;
    background: white;
    padding: 0 10px;
    font-weight: 600;
    color: #667eea;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    gap: 8px;
}
.form-control-modern,
.form-select-modern {
    border: 2px solid #e9ecef;
    border-radius: 10px;
    padding: 10px 12px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}
.form-control-modern:focus,
.form-select-modern:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.1);
}
.icon-label {
    display: flex;
    align-items: center;
    gap: 6px;
    font-weight: 600;
    color: #495057;
    margin-bottom: 6px;
    font-size: 0.85rem;
}
.icon-label i {
    color: #667eea;
    font-size: 0.9rem;
}
.btn-modern {
    padding: 10px 30px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
    font-size: 0.9rem;
}
.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
.btn-primary-modern {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}
.info-text {
    font-size: 0.8rem;
    color: #6c757d;
    margin-top: 3px;
}
.import-card {
    background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
    border-radius: 10px;
    padding: 15px;
    border-left: 4px solid #4caf50;
}
</style>
@endpush

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="mb-1 fw-bold">
                    <i class="bi bi-person-plus-fill me-2"></i>Créer un utilisateur
                </h3>
                <small class="opacity-75">Ajoutez un nouvel utilisateur au système</small>
            </div>
            <div>
                <a href="{{ route('admin.users.index') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-arrow-left me-1"></i>Retour à la liste
                </a>
            </div>
        </div>
    </div>

    {{-- Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <strong>{{ session('success') }}</strong> a été créé avec succès !
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-3" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <strong>Erreurs:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-3">
        
        {{-- Formulaire principal --}}
        <div class="col-lg-8">
            <div class="form-card">
                <form method="POST" action="{{ route('admin.users.store') }}" id="userForm">
                    @csrf

                    {{-- Informations personnelles --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="icon-label">
                                <i class="bi bi-person"></i>Nom
                            </label>
                            <input type="text" name="nom_utilisateur"
                                   class="form-control form-control-modern @error('nom_utilisateur') is-invalid @enderror"
                                   value="{{ old('nom_utilisateur') }}" 
                                   placeholder="Ex: Traoré"
                                   required>
                            @error('nom_utilisateur')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="icon-label">
                                <i class="bi bi-person"></i>Prénom
                            </label>
                            <input type="text" name="prenom_utilisateur"
                                   class="form-control form-control-modern @error('prenom_utilisateur') is-invalid @enderror"
                                   value="{{ old('prenom_utilisateur') }}"
                                   placeholder="Ex: Abdoulaye"
                                   required>
                            @error('prenom_utilisateur')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="icon-label">
                                <i class="bi bi-envelope"></i>Email
                            </label>
                            <input type="email" name="email"
                                   class="form-control form-control-modern @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}"
                                   placeholder="exemple@ujkz.bf"
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="info-text"><i class="bi bi-info-circle"></i> L'email doit être unique</small>
                        </div>

                        <div class="col-md-6">
                            <label class="icon-label">
                                <i class="bi bi-hash"></i>Matricule
                            </label>
                            <input type="text" name="matricule_utilisateur"
                                   class="form-control form-control-modern @error('matricule_utilisateur') is-invalid @enderror"
                                   value="{{ old('matricule_utilisateur') }}"
                                   placeholder="Ex: MAT001"
                                   required>
                            @error('matricule_utilisateur')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="info-text"><i class="bi bi-info-circle"></i> Le matricule doit être unique</small>
                        </div>
                    </div>

                    {{-- Divider --}}
                    <div class="section-divider">
                        <span class="section-divider-title">
                            <i class="bi bi-gear-fill"></i>Configuration du compte
                        </span>
                    </div>

                    {{-- Type et affectation --}}
                    <div class="row g-3 mb-3">
                        <div class="col-12">
                            <label class="icon-label">
                                <i class="bi bi-person-badge"></i>Type de compte
                            </label>
                            <select name="type" id="type"
                                    class="form-select form-select-modern @error('type') is-invalid @enderror"
                                    onchange="handleTypeChange()" required>
                                <option value="" selected disabled>-- Sélectionner un type --</option>
                                <option value="DA" @selected(old('type')=='DA')>DA - Directeur Adjoint</option>
                                <option value="CS" @selected(old('type')=='CS')>CS - Chef de Scolarité</option>
                                <option value="CD" @selected(old('type')=='CD')>CD - Chef de Département</option>
                                <option value="Enseignant" @selected(old('type')=='Enseignant')>Enseignant</option>
                                <option value="President" @selected(old('type')=='President')>Président</option>
                                <option value="Admin" @selected(old('type')=='Admin')>Administrateur</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="info-text"><i class="bi bi-info-circle"></i> Le type détermine les permissions de l'utilisateur</small>
                        </div>

                        {{-- Établissement (conditionnel) --}}
                        <div class="col-md-6" id="etablissement-field" style="display:none;">
                            <label class="icon-label">
                                <i class="bi bi-building"></i>Établissement
                            </label>
                            <select name="etablissement_id" id="etablissement-select"
                                    class="form-select form-select-modern @error('etablissement_id') is-invalid @enderror"
                                    onchange="filterDepartements()">
                                <option value="" selected disabled>-- Sélectionner un établissement --</option>
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

                        {{-- Département (conditionnel) --}}
                        <div class="col-md-6" id="departement-field" style="display:none;">
                            <label class="icon-label">
                                <i class="bi bi-diagram-3"></i>Département
                            </label>
                            <select name="departement_id" id="departement-select"
                                    class="form-select form-select-modern @error('departement_id') is-invalid @enderror">
                                <option value="" selected disabled>-- Sélectionner un département --</option>
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
                    </div>

                    {{-- Boutons --}}
                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-modern">
                            <i class="bi bi-x-circle me-1"></i>Annuler
                        </a>
                        <div class="d-flex gap-2">
                            <button type="reset" class="btn btn-outline-warning btn-modern">
                                <i class="bi bi-arrow-clockwise me-1"></i>Réinitialiser
                            </button>
                            <button type="submit" class="btn btn-primary-modern btn-modern">
                                <i class="bi bi-check-circle me-1"></i>Créer l'utilisateur
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

        {{-- Colonne latérale : Info et import --}}
        <div class="col-lg-4">
            
            {{-- Card aide --}}
            <div class="form-card mb-3">
                <h6 class="fw-bold mb-3">
                    <i class="bi bi-info-circle text-primary me-2"></i>
                    Informations importantes
                </h6>
                <ul class="list-unstyled mb-0" style="font-size: 0.85rem;">
                    <li class="mb-2">
                        <i class="bi bi-check2-circle text-success me-2"></i>
                        Tous les champs sont obligatoires
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check2-circle text-success me-2"></i>
                        L'email et le matricule doivent être uniques
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check2-circle text-success me-2"></i>
                        Un mot de passe sera généré automatiquement
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check2-circle text-success me-2"></i>
                        L'utilisateur recevra ses identifiants par email
                    </li>
                </ul>
            </div>

            {{-- Card types de comptes --}}
            <div class="form-card mb-3">
                <h6 class="fw-bold mb-3">
                    <i class="bi bi-people text-primary me-2"></i>
                    Types de comptes
                </h6>
                <div class="mb-2">
                    <strong class="text-primary" style="font-size: 0.85rem;">DA / CS</strong>
                    <p class="mb-2" style="font-size: 0.8rem; color: #6c757d;">Nécessite un établissement</p>
                </div>
                <div class="mb-2">
                    <strong class="text-warning" style="font-size: 0.85rem;">CD / Enseignant</strong>
                    <p class="mb-2" style="font-size: 0.8rem; color: #6c757d;">Nécessite un établissement et un département</p>
                </div>
                <div>
                    <strong class="text-info" style="font-size: 0.85rem;">Président / Admin</strong>
                    <p class="mb-0" style="font-size: 0.8rem; color: #6c757d;">Aucune affectation nécessaire</p>
                </div>
            </div>

            {{-- Card import CSV --}}
            <div class="import-card">
                <h6 class="fw-bold mb-2">
                    <i class="bi bi-file-earmark-spreadsheet me-2"></i>
                    Import en masse
                </h6>
                <p class="mb-3" style="font-size: 0.85rem; color: #2e7d32;">
                    Importez plusieurs utilisateurs via un fichier CSV
                </p>
                <a href="{{ route('admin.users.import.form') }}" class="btn btn-success btn-modern w-100">
                    <i class="bi bi-upload me-2"></i>Importer des utilisateurs
                </a>
            </div>

        </div>

    </div>

</div>
@endsection

@section('scripts')
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

    // CD / Enseignant → établissement + département
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

    // Filtrer les départements selon l'établissement
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

// Confirmation reset
document.querySelector('button[type="reset"]')?.addEventListener('click', function(e) {
    e.preventDefault();
    if (confirm('Réinitialiser le formulaire ? Toutes les données seront effacées.')) {
        document.getElementById('userForm').reset();
        handleTypeChange();
    }
});

// Validation avant soumission
document.getElementById('userForm').addEventListener('submit', function(e) {
    const type = document.getElementById('type').value;
    const etablissement = document.getElementById('etablissement-select').value;
    const departement = document.getElementById('departement-select').value;

    // Validation pour DA/CS
    if ((type === 'DA' || type === 'CS') && !etablissement) {
        e.preventDefault();
        alert('Veuillez sélectionner un établissement pour ce type de compte');
        return false;
    }

    // Validation pour CD/Enseignant
    if ((type === 'CD' || type === 'Enseignant') && (!etablissement || !departement)) {
        e.preventDefault();
        alert('Veuillez sélectionner un établissement et un département pour ce type de compte');
        return false;
    }
});
</script>
@endsection