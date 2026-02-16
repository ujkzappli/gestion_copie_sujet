@extends('layouts.app')

@section('title', 'Créer un lot de copies')

@push('styles')
<style>
.form-step {
    background: white;
    border-radius: 15px;
    padding: 25px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    transition: all 0.3s ease;
}
.form-step:hover {
    box-shadow: 0 4px 16px rgba(0,0,0,0.1);
}
.step-header {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f1f3f5;
}
.step-number {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 1.1rem;
    margin-right: 15px;
}
.step-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
    margin: 0;
}
.form-floating-custom {
    position: relative;
    margin-bottom: 1.5rem;
}
.form-floating-custom label {
    position: absolute;
    top: 12px;
    left: 15px;
    color: #6c757d;
    font-size: 0.9rem;
    font-weight: 500;
    pointer-events: none;
    transition: all 0.3s ease;
    background: white;
    padding: 0 5px;
}
.form-floating-custom .form-control:focus ~ label,
.form-floating-custom .form-control:not(:placeholder-shown) ~ label,
.form-floating-custom .form-select:not([value=""]) ~ label,
.form-floating-custom .form-select:focus ~ label {
    top: -8px;
    left: 10px;
    font-size: 0.75rem;
    color: #667eea;
}
.form-control-modern,
.form-select-modern {
    border: 2px solid #e9ecef;
    border-radius: 10px;
    padding: 12px 15px;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}
.form-control-modern:focus,
.form-select-modern:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.1);
}
.form-control-modern:disabled,
.form-control-modern:read-only {
    background-color: #f8f9fa;
    border-color: #dee2e6;
    cursor: not-allowed;
}
.icon-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 600;
    color: #495057;
    margin-bottom: 8px;
    font-size: 0.9rem;
}
.icon-label i {
    color: #667eea;
}
.info-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    background: #e7f3ff;
    border-radius: 20px;
    color: #0066cc;
    font-size: 0.85rem;
    font-weight: 500;
}
.enseignant-card {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 10px;
    padding: 15px;
    border-left: 4px solid #667eea;
    display: flex;
    align-items: center;
    gap: 15px;
}
.enseignant-avatar {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
}
.btn-modern {
    padding: 12px 30px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
}
.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
.btn-primary-modern {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}
.btn-secondary-modern {
    background: #6c757d;
    color: white;
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
                        <i class="bi bi-plus-circle-fill me-2"></i>Créer un lot de copies
                    </h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}" class="text-decoration-none">
                                    <i class="bi bi-house-door"></i> Accueil
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('lot-copies.index') }}" class="text-decoration-none">Lots de copies</a>
                            </li>
                            <li class="breadcrumb-item active">Nouveau lot</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    {{-- Messages d'erreur --}}
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
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

    <form action="{{ route('lot-copies.store') }}" method="POST" id="lotCopiesForm">
        @csrf

        {{-- Étape 1 : Informations de la session --}}
        <div class="form-step">
            <div class="step-header">
                <div class="step-number">1</div>
                <h5 class="step-title">Informations de la session d'examen</h5>
            </div>

            <div class="row">
                {{-- Année académique --}}
                <div class="col-lg-3 col-md-6 mb-3">
                    <label class="icon-label">
                        <i class="bi bi-calendar3"></i>
                        Année académique
                    </label>
                    <select name="annee_academique" class="form-select form-select-modern" required>
                        <option value="" selected disabled>Sélectionner...</option>
                        @foreach($annees as $annee)
                            <option value="{{ $annee }}" {{ old('annee_academique') == $annee ? 'selected' : '' }}>
                                {{ $annee }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Session d'examen --}}
                <div class="col-lg-3 col-md-6 mb-3">
                    <label class="icon-label">
                        <i class="bi bi-bookmark-check"></i>
                        Session d'examen
                    </label>
                    <select name="session_type" class="form-select form-select-modern" required>
                        <option value="" selected disabled>Sélectionner...</option>
                        @foreach($sessions as $session)
                            <option value="{{ $session }}" {{ old('session_type') == $session ? 'selected' : '' }}>
                                {{ ucfirst($session) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Semestre --}}
                <div class="col-lg-3 col-md-6 mb-3">
                    <label class="icon-label">
                        <i class="bi bi-layers"></i>
                        Niveau
                    </label>
                    <select name="semestre_id" class="form-select form-select-modern" required>
                        <option value="" selected disabled>Sélectionner...</option>
                        @foreach($semestres as $semestre)
                            <option value="{{ $semestre->id }}" {{ old('semestre_id') == $semestre->id ? 'selected' : '' }}>
                                {{ $semestre->code }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Option --}}
                <div class="col-lg-3 col-md-6 mb-3">
                    <label class="icon-label">
                        <i class="bi bi-mortarboard"></i>
                        Parcours
                    </label>
                    <select name="option_id" id="option_id" class="form-select form-select-modern" required>
                        <option value="" selected disabled>Sélectionner...</option>
                        @foreach($options as $option)
                            <option value="{{ $option->id }}" {{ old('option_id') == $option->id ? 'selected' : '' }}>
                                {{ $option->libelle_option }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="info-badge">
                <i class="bi bi-info-circle-fill"></i>
                Sélectionnez d'abord le parcours pour voir les modules disponibles
            </div>
        </div>

        {{-- Étape 2 : Module et enseignant --}}
        <div class="form-step">
            <div class="step-header">
                <div class="step-number">2</div>
                <h5 class="step-title">Module et enseignant responsable</h5>
            </div>

            {{-- Module --}}
            <div class="mb-4">
                <label class="icon-label">
                    <i class="bi bi-book"></i>
                    Module
                </label>
                <select name="module_id" id="module_id" class="form-select form-select-modern" required>
                    <option value="" selected disabled>-- Choisir un module --</option>
                    {{-- Options seront remplies dynamiquement via JS --}}
                </select>
                <small class="text-muted">
                    <i class="bi bi-lightbulb"></i> Les modules affichés correspondent au parcours sélectionné
                </small>
            </div>

            {{-- Enseignant (readonly) --}}
            <div id="enseignant-card" style="display: none;">
                <label class="icon-label mb-3">
                    <i class="bi bi-person-badge"></i>
                    Enseignant responsable
                </label>
                <div class="enseignant-card">
                    <div class="enseignant-avatar">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-semibold text-dark" id="enseignant-name">-</div>
                        <small class="text-muted" id="enseignant-matricule">-</small>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-success">
                            <i class="bi bi-check-circle me-1"></i>Assigné
                        </span>
                    </div>
                </div>
                <input type="hidden" name="enseignant_id" id="enseignant_id_hidden">
            </div>
        </div>

        {{-- Étape 3 : Détails du lot --}}
        <div class="form-step">
            <div class="step-header">
                <div class="step-number">3</div>
                <h5 class="step-title">Détails du lot de copies</h5>
            </div>

            <div class="row">
                {{-- Nombre de copies --}}
                <div class="col-md-6 mb-3">
                    <label class="icon-label">
                        <i class="bi bi-file-earmark-text"></i>
                        Nombre de copies
                    </label>
                    <input 
                        type="number" 
                        name="nombre_copies" 
                        class="form-control form-control-modern" 
                        placeholder="Ex: 50"
                        min="1"
                        required 
                        value="{{ old('nombre_copies') }}">
                    <small class="text-muted">
                        <i class="bi bi-info-circle"></i> Nombre total de copies à corriger
                    </small>
                </div>

                {{-- Date disponible --}}
                <div class="col-md-6 mb-3">
                    <label class="icon-label">
                        <i class="bi bi-calendar-check"></i>
                        Date de disponibilité
                    </label>
                    <input 
                        type="date" 
                        name="date_disponible" 
                        class="form-control form-control-modern" 
                        required 
                        value="{{ old('date_disponible', date('Y-m-d')) }}">
                    <small class="text-muted">
                        <i class="bi bi-info-circle"></i> Date à laquelle les copies seront disponibles
                    </small>
                </div>
            </div>

            {{-- Informations calculées --}}
            <div class="alert alert-info border-0 bg-light mt-3" role="alert">
                <div class="d-flex align-items-start">
                    <i class="bi bi-clock-history fs-4 me-3 text-info"></i>
                    <div>
                        <strong>Délais automatiques :</strong>
                        <ul class="mb-0 mt-2">
                            <li>Récupération : <strong>2 jours</strong> après la date de disponibilité</li>
                            <li>Remise : <strong>12 jours</strong> après la date limite de récupération</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- Boutons d'action --}}
        <div class="form-step">
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('lot-copies.index') }}" class="btn btn-secondary-modern btn-modern">
                    <i class="bi bi-arrow-left me-2"></i>Retour
                </a>
                <div class="d-flex gap-2">
                    <button type="reset" class="btn btn-outline-warning btn-modern">
                        <i class="bi bi-arrow-clockwise me-2"></i>Réinitialiser
                    </button>
                    <button type="submit" class="btn btn-primary-modern btn-modern">
                        <i class="bi bi-check-circle me-2"></i>Créer le lot
                    </button>
                </div>
            </div>
        </div>

    </form>

</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    
    // Modules envoyés depuis le controller
    const modules = @json($modules);
    const optionSelect = document.getElementById('option_id');
    const moduleSelect = document.getElementById('module_id');
    const enseignantCard = document.getElementById('enseignant-card');
    const enseignantName = document.getElementById('enseignant-name');
    const enseignantMatricule = document.getElementById('enseignant-matricule');
    const enseignantHidden = document.getElementById('enseignant_id_hidden');

    // ================= Filtrage des modules selon l'option sélectionnée =================
    optionSelect.addEventListener('change', function() {
        const optionId = parseInt(this.value);
        moduleSelect.innerHTML = '<option value="" selected disabled>-- Choisir un module --</option>';
        enseignantCard.style.display = 'none';
        enseignantName.textContent = '-';
        enseignantMatricule.textContent = '-';
        enseignantHidden.value = '';

        let modulesFound = 0;
        modules.forEach(mod => {
            // Vérifie si le module appartient à l'option sélectionnée
            if (mod.semestre.options.some(o => o.id === optionId)) {
                const opt = document.createElement('option');
                opt.value = mod.id;
                opt.textContent = mod.nom + (mod.code ? ` (${mod.code})` : '');
                opt.dataset.enseignantNom = mod.enseignant ? mod.enseignant.nom_utilisateur : '';
                opt.dataset.enseignantPrenom = mod.enseignant ? mod.enseignant.prenom_utilisateur : '';
                opt.dataset.enseignantMatricule = mod.enseignant ? mod.enseignant.matricule_utilisateur : '';
                opt.dataset.enseignantId = mod.enseignant ? mod.enseignant.id : '';
                moduleSelect.appendChild(opt);
                modulesFound++;
            }
        });

        // Si aucun module trouvé
        if (modulesFound === 0) {
            const opt = document.createElement('option');
            opt.value = '';
            opt.textContent = 'Aucun module disponible pour ce parcours';
            opt.disabled = true;
            moduleSelect.appendChild(opt);
        }

        // Animation de l'étape 2
        $('.form-step').eq(1).addClass('animate__animated animate__fadeIn');
    });

    // ================= Remplissage automatique de l'enseignant selon le module choisi =================
    moduleSelect.addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        
        if (selected.value) {
            const nom = selected.dataset.enseignantNom || '';
            const prenom = selected.dataset.enseignantPrenom || '';
            const matricule = selected.dataset.enseignantMatricule || '';
            const enseignantId = selected.dataset.enseignantId || '';

            if (nom && prenom) {
                enseignantName.textContent = `${prenom} ${nom}`;
                enseignantMatricule.textContent = `Matricule: ${matricule}`;
                enseignantHidden.value = enseignantId;
                enseignantCard.style.display = 'block';
                
                // Animation
                $(enseignantCard).addClass('animate__animated animate__fadeInUp');
            } else {
                enseignantCard.style.display = 'none';
                enseignantHidden.value = '';
            }
        } else {
            enseignantCard.style.display = 'none';
            enseignantHidden.value = '';
        }
    });

    // ================= Validation du formulaire =================
    $('#lotCopiesForm').on('submit', function(e) {
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
                    scrollTop: firstError.closest('.form-step').offset().top - 100
                }, 500);
                firstError.focus();
            }

            // Afficher une notification
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: 'Veuillez remplir tous les champs obligatoires',
                    confirmButtonColor: '#dc3545'
                });
            } else {
                alert('Veuillez remplir tous les champs obligatoires');
            }
        }
    });

    // ================= Confirmation avant reset =================
    $('button[type="reset"]').on('click', function(e) {
        e.preventDefault();
        
        if (typeof Swal !== 'undefined') {
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
                    $('#lotCopiesForm')[0].reset();
                    enseignantCard.style.display = 'none';
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Réinitialisé',
                        text: 'Le formulaire a été réinitialisé',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            });
        } else {
            if (confirm('Êtes-vous sûr de vouloir réinitialiser le formulaire ?')) {
                $('#lotCopiesForm')[0].reset();
                enseignantCard.style.display = 'none';
            }
        }
    });

    // ================= Animation au focus des inputs =================
    $('.form-control-modern, .form-select-modern').on('focus', function() {
        $(this).closest('.form-step').addClass('shadow-sm');
    }).on('blur', function() {
        $(this).closest('.form-step').removeClass('shadow-sm');
    });

});
</script>

{{-- SweetAlert2 pour les notifications (optionnel) --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection