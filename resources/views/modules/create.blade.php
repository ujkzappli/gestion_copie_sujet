@extends('layouts.app')

@section('title', 'Ajouter un module')

@push('styles')
<style>
.form-floating-modern {
    position: relative;
}
.form-floating-modern .form-control:focus ~ label,
.form-floating-modern .form-control:not(:placeholder-shown) ~ label,
.form-floating-modern .form-select:focus ~ label,
.form-floating-modern .form-select:not([value=""]) ~ label {
    transform: translateY(-1.5rem) scale(0.85);
    color: var(--bs-primary);
}
.icon-input {
    position: relative;
}
.icon-input i {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    z-index: 10;
}
.icon-input .form-control,
.icon-input .form-select {
    padding-left: 45px;
}
.card-modern {
    border: none;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.card-modern:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.12);
}
.select2-container--bootstrap-5 .select2-selection {
    min-height: 48px;
    padding: 0.5rem 0.75rem;
    border-radius: 8px;
}
.select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
    line-height: 36px;
}
.btn-modern {
    padding: 12px 30px;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
}
.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    
    {{-- Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1 fw-bold text-primary">
                        <i class="bi bi-journal-plus me-2"></i>Ajouter un module
                    </h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('modules.index') }}" class="text-decoration-none">Modules</a>
                            </li>
                            <li class="breadcrumb-item active">Nouveau module</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    {{-- Messages de succès --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill fs-4 me-3"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Erreurs globales --}}
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
            <div class="d-flex align-items-start">
                <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
                <div>
                    <strong>Erreurs détectées :</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Formulaire principal --}}
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card card-modern">
                <div class="card-header bg-gradient bg-primary text-white border-0 py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-pencil-square me-2"></i>Informations du module
                    </h5>
                    <small class="opacity-75">Remplissez tous les champs obligatoires</small>
                </div>
                
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('modules.store') }}" id="moduleForm">
                        @csrf

                        {{-- Code du module --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-upc-scan text-primary me-1"></i>
                                Code du module 
                                <span class="text-danger">*</span>
                            </label>
                            <div class="icon-input">
                                <i class="bi bi-hash"></i>
                                <input 
                                    type="text"
                                    name="code"
                                    class="form-control form-control-lg @error('code') is-invalid @enderror"
                                    value="{{ old('code') }}"
                                    placeholder="Ex: INFO-101"
                                    required>
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="text-muted">
                                <i class="bi bi-info-circle"></i> Code unique du module (ex: 2INF25)
                            </small>
                        </div>

                        {{-- Nom du module --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-book text-success me-1"></i>
                                Nom du module 
                                <span class="text-danger">*</span>
                            </label>
                            <div class="icon-input">
                                <i class="bi bi-bookmark"></i>
                                <input 
                                    type="text"
                                    name="nom"
                                    class="form-control form-control-lg @error('nom') is-invalid @enderror"
                                    value="{{ old('nom') }}"
                                    placeholder="Ex: Programmation Web Avancée"
                                    required>
                                @error('nom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="text-muted">
                                <i class="bi bi-info-circle"></i> Nom complet du module
                            </small>
                        </div>

                        {{-- Semestre --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-calendar3 text-warning me-1"></i>
                                Semestre 
                                <span class="text-danger">*</span>
                            </label>
                            <div class="icon-input">
                                <i class="bi bi-calendar-check"></i>
                                <select 
                                    name="semestre_id"
                                    class="form-select form-select-lg @error('semestre_id') is-invalid @enderror"
                                    required>
                                    <option value="" selected disabled>-- Sélectionner un semestre --</option>
                                    @foreach($semestres as $semestre)
                                        <option 
                                            value="{{ $semestre->id }}"
                                            @selected(old('semestre_id') == $semestre->id)>
                                            {{ $semestre->code }} - {{ $semestre->libelle ?? '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('semestre_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Enseignant avec recherche --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-person-badge text-info me-1"></i>
                                Enseignant responsable 
                                <span class="text-danger">*</span>
                            </label>
                            <select 
                                name="enseignant_id" 
                                id="enseignant_id" 
                                class="form-select form-select-lg select2-enseignant @error('enseignant_id') is-invalid @enderror" 
                                required>
                                <option value="" selected disabled>-- Rechercher un enseignant --</option>
                                @foreach($enseignants as $enseignant)
                                    <option 
                                        value="{{ $enseignant->id }}"
                                        data-matricule="{{ $enseignant->matricule_utilisateur }}"
                                        @selected(old('enseignant_id') == $enseignant->id)>
                                        {{ $enseignant->nom_utilisateur }} {{ $enseignant->prenom_utilisateur }} - {{ $enseignant->matricule_utilisateur }}
                                    </option>
                                @endforeach
                            </select>
                            @error('enseignant_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                <i class="bi bi-search"></i> Tapez pour rechercher un enseignant par nom, prénom ou matricule
                            </small>
                        </div>

                        {{-- Boutons d'action --}}
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <a href="{{ route('modules.index') }}" class="btn btn-outline-secondary btn-modern">
                                <i class="bi bi-arrow-left me-2"></i>Retour
                            </a>
                            <div class="d-flex gap-2">
                                <button type="reset" class="btn btn-outline-warning btn-modern">
                                    <i class="bi bi-arrow-clockwise me-2"></i>Réinitialiser
                                </button>
                                <button type="submit" class="btn btn-primary btn-modern">
                                    <i class="bi bi-check-circle me-2"></i>Enregistrer
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Carte d'information --}}
            <div class="card card-modern mt-4 border-start border-primary border-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-info-circle text-primary me-2"></i>Informations importantes
                    </h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="bi bi-check2-circle text-success me-2"></i>
                            Les champs marqués d'un <span class="text-danger">*</span> sont obligatoires
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check2-circle text-success me-2"></i>
                            Le code du module doit être unique dans le système
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check2-circle text-success me-2"></i>
                            Un enseignant peut être responsable de plusieurs modules
                        </li>
                        <li class="mb-0">
                            <i class="bi bi-check2-circle text-success me-2"></i>
                            Utilisez la barre de recherche pour trouver rapidement un enseignant
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    
    // ================= Initialisation Select2 pour l'enseignant =================
    $('.select2-enseignant').select2({
        theme: 'bootstrap-5',
        width: '100%',
        placeholder: '-- Rechercher un enseignant --',
        allowClear: true,
        language: {
            noResults: function() {
                return "Aucun enseignant trouvé";
            },
            searching: function() {
                return "Recherche en cours...";
            },
            inputTooShort: function() {
                return "Tapez pour rechercher";
            }
        },
        // Recherche personnalisée
        matcher: function(params, data) {
            // Si rien n'est tapé, afficher tous les résultats
            if ($.trim(params.term) === '') {
                return data;
            }

            // Ne pas afficher l'option par défaut dans les résultats
            if (data.id === '') {
                return null;
            }

            var term = params.term.toLowerCase();
            var text = data.text.toLowerCase();
            
            // Recherche dans le texte complet (nom, prénom, matricule)
            if (text.indexOf(term) > -1) {
                return data;
            }

            // Recherche par matricule depuis l'attribut data
            var matricule = $(data.element).data('matricule');
            if (matricule && matricule.toString().toLowerCase().indexOf(term) > -1) {
                return data;
            }

            return null;
        },
        // Template pour l'affichage dans la liste déroulante
        templateResult: function(data) {
            if (data.loading || data.id === '') {
                return data.text;
            }

            var $result = $(
                '<div class="d-flex align-items-center">' +
                    '<div class="avatar-circle bg-primary text-white me-3">' +
                        '<i class="bi bi-person"></i>' +
                    '</div>' +
                    '<div>' +
                        '<div class="fw-semibold">' + data.text.split(' - ')[0] + '</div>' +
                        '<small class="text-muted">Matricule: ' + $(data.element).data('matricule') + '</small>' +
                    '</div>' +
                '</div>'
            );

            return $result;
        },
        // Template pour l'affichage de la sélection
        templateSelection: function(data) {
            if (data.id === '') {
                return data.text;
            }
            return data.text;
        }
    });

    // ================= Animation au focus des inputs =================
    $('.form-control, .form-select').on('focus', function() {
        $(this).parent().addClass('shadow-sm');
    }).on('blur', function() {
        $(this).parent().removeClass('shadow-sm');
    });

    // ================= Validation du formulaire =================
    $('#moduleForm').on('submit', function(e) {
        var isValid = true;
        var firstError = null;

        // Vérifier tous les champs requis
        $(this).find('[required]').each(function() {
            if (!$(this).val()) {
                isValid = false;
                $(this).addClass('is-invalid');
                if (!firstError) {
                    firstError = $(this);
                }
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        if (!isValid) {
            e.preventDefault();
            
            // Scroll vers le premier champ en erreur
            if (firstError) {
                $('html, body').animate({
                    scrollTop: firstError.offset().top - 100
                }, 500);
                firstError.focus();
            }

            // Afficher une notification
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: 'Veuillez remplir tous les champs obligatoires',
                confirmButtonColor: '#dc3545'
            });
        }
    });

    // ================= Confirmation avant reset =================
    $('button[type="reset"]').on('click', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: "Tous les champs seront réinitialisés",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ffc107',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Oui, réinitialiser',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#moduleForm')[0].reset();
                $('.select2-enseignant').val(null).trigger('change');
                
                Swal.fire({
                    icon: 'success',
                    title: 'Réinitialisé',
                    text: 'Le formulaire a été réinitialisé',
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        });
    });

    // ================= Tooltip Bootstrap =================
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

});
</script>

{{-- Styles pour Select2 personnalisés --}}
<style>
.avatar-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}
.select2-container--bootstrap-5 .select2-dropdown {
    border-radius: 8px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.15);
}
.select2-container--bootstrap-5 .select2-results__option {
    padding: 10px 15px;
}
.select2-container--bootstrap-5 .select2-results__option--highlighted {
    background-color: #0d6efd;
    color: white;
}
</style>

{{-- SweetAlert2 pour les notifications (optionnel) --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection