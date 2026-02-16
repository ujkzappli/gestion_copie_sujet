@extends('layouts.app')

@section('title', 'Modifier un lot de copies')

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
.date-card {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 15px;
    border-left: 4px solid #28a745;
}
.date-card.provisional {
    border-left-color: #17a2b8;
}
.date-card.late {
    border-left-color: #dc3545;
    background: #fff5f5;
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
.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    gap: 6px;
}
.status-disponible {
    background: #e3f2fd;
    color: #1976d2;
}
.status-en-cours {
    background: #fff3e0;
    color: #f57c00;
}
.status-termine {
    background: #e8f5e9;
    color: #388e3c;
}
.status-retard {
    background: #ffebee;
    color: #d32f2f;
}
.timeline {
    position: relative;
    padding-left: 30px;
}
.timeline::before {
    content: '';
    position: absolute;
    left: 8px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}
.timeline-item {
    position: relative;
    padding-bottom: 20px;
}
.timeline-item::before {
    content: '';
    position: absolute;
    left: -25px;
    top: 5px;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background: white;
    border: 3px solid #667eea;
}
.timeline-item.completed::before {
    background: #28a745;
    border-color: #28a745;
}
.timeline-item.late::before {
    background: #dc3545;
    border-color: #dc3545;
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
                        <i class="bi bi-pencil-square me-2"></i>Modifier le lot de copies #{{ $lot_copy->id }}
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
                            <li class="breadcrumb-item active">Modifier #{{ $lot_copy->id }}</li>
                        </ol>
                    </nav>
                </div>
                
                {{-- Badge de statut --}}
                @php
                    $dateLimiteRecup = $lot_copy->date_disponible ? $lot_copy->date_disponible->copy()->addDays(2) : null;
                    $dateLimiteRemise = $dateLimiteRecup ? $dateLimiteRecup->copy()->addDays(12) : null;
                    
                    $statut = 'disponible';
                    $isRetard = false;
                    
                    if($lot_copy->date_remise) {
                        $statut = 'termine';
                        if($dateLimiteRemise && $lot_copy->date_remise > $dateLimiteRemise) {
                            $isRetard = true;
                        }
                    } elseif($lot_copy->date_recuperation) {
                        $statut = 'en-cours';
                    }
                @endphp
                
                <div>
                    @if($isRetard)
                        <span class="status-badge status-retard">
                            <i class="bi bi-exclamation-circle-fill"></i>
                            En retard
                        </span>
                    @elseif($statut === 'termine')
                        <span class="status-badge status-termine">
                            <i class="bi bi-check-circle-fill"></i>
                            Terminé
                        </span>
                    @elseif($statut === 'en-cours')
                        <span class="status-badge status-en-cours">
                            <i class="bi bi-pencil-fill"></i>
                            En correction
                        </span>
                    @else
                        <span class="status-badge status-disponible">
                            <i class="bi bi-inbox-fill"></i>
                            Disponible
                        </span>
                    @endif
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

    <form method="POST" action="{{ route('lot-copies.update', $lot_copy) }}" id="editLotForm">
        @csrf
        @method('PUT')

        <div class="row">
            {{-- Colonne principale --}}
            <div class="col-lg-8">
                
                {{-- Section 1 : Module et enseignant --}}
                <div class="form-step">
                    <div class="step-header">
                        <div class="step-number">1</div>
                        <h5 class="step-title">Module et enseignant</h5>
                    </div>

                    {{-- Module --}}
                    <div class="mb-4">
                        <label class="icon-label">
                            <i class="bi bi-book"></i>
                            Module
                        </label>
                        <select name="module_id" id="module_id"
                                class="form-select form-select-modern @error('module_id') is-invalid @enderror"
                                required>
                            <option value="">-- Choisir un module --</option>
                            @foreach($modules as $module)
                                <option value="{{ $module->id }}"
                                    data-enseignant-nom="{{ $module->enseignant->nom_utilisateur ?? '' }}"
                                    data-enseignant-prenom="{{ $module->enseignant->prenom_utilisateur ?? '' }}"
                                    data-enseignant-matricule="{{ $module->enseignant->matricule_utilisateur ?? '' }}"
                                    data-enseignant-id="{{ $module->enseignant->id ?? '' }}"
                                    @selected($module->id === $lot_copy->module_id)>
                                    {{ $module->nom }} @if($module->code)({{ $module->code }})@endif
                                </option>
                            @endforeach
                        </select>
                        @error('module_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Enseignant card --}}
                    <div>
                        <label class="icon-label mb-3">
                            <i class="bi bi-person-badge"></i>
                            Enseignant responsable
                        </label>
                        <div class="enseignant-card">
                            <div class="enseignant-avatar">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold text-dark" id="enseignant-name">
                                    {{ $lot_copy->module->enseignant->prenom_utilisateur ?? '' }} 
                                    {{ $lot_copy->module->enseignant->nom_utilisateur ?? '' }}
                                </div>
                                <small class="text-muted" id="enseignant-matricule">
                                    Matricule: {{ $lot_copy->module->enseignant->matricule_utilisateur ?? '-' }}
                                </small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle me-1"></i>Assigné
                                </span>
                            </div>
                        </div>
                        <input type="hidden" name="enseignant_id" id="enseignant_id_hidden"
                            value="{{ old('enseignant_id', $lot_copy->module->enseignant->id ?? '') }}">
                    </div>
                </div>

                {{-- Section 2 : Détails du lot --}}
                <div class="form-step">
                    <div class="step-header">
                        <div class="step-number">2</div>
                        <h5 class="step-title">Détails du lot</h5>
                    </div>

                    <div class="row">
                        {{-- Nombre de copies --}}
                        <div class="col-md-6 mb-3">
                            <label class="icon-label">
                                <i class="bi bi-file-earmark-text"></i>
                                Nombre de copies
                            </label>
                            <input type="number" name="nombre_copies"
                                   class="form-control form-control-modern @error('nombre_copies') is-invalid @enderror"
                                   placeholder="Ex: 50"
                                   min="1"
                                   required
                                   value="{{ old('nombre_copies', $lot_copy->nombre_copies) }}">
                            @error('nombre_copies')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                <i class="bi bi-info-circle"></i> Nombre total de copies à corriger
                            </small>
                        </div>

                        {{-- Date de disponibilité --}}
                        <div class="col-md-6 mb-3">
                            <label class="icon-label">
                                <i class="bi bi-calendar-check"></i>
                                Date de disponibilité
                            </label>
                            <input type="date" name="date_disponible"
                                   id="date_depot"
                                   class="form-control form-control-modern @error('date_disponible') is-invalid @enderror"
                                   required
                                   value="{{ old('date_disponible', $lot_copy->date_disponible?->format('Y-m-d')) }}">
                            @error('date_disponible')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                <i class="bi bi-info-circle"></i> Date de mise à disposition des copies
                            </small>
                        </div>
                    </div>
                </div>

                {{-- Section 3 : Dates de suivi --}}
                <div class="form-step">
                    <div class="step-header">
                        <div class="step-number">3</div>
                        <h5 class="step-title">Suivi et dates réelles</h5>
                    </div>

                    <div class="row">
                        {{-- Date réelle de récupération --}}
                        <div class="col-md-6 mb-3">
                            <label class="icon-label">
                                <i class="bi bi-box-arrow-down"></i>
                                Date réelle de récupération
                            </label>
                            <input type="date" name="date_recuperation"
                                   id="date_recuperation"
                                   class="form-control form-control-modern @error('date_recuperation') is-invalid @enderror"
                                   value="{{ old('date_recuperation', $lot_copy->date_recuperation?->format('Y-m-d')) }}">
                            @error('date_recuperation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                <i class="bi bi-clock-history"></i> Date limite: <span id="limite_recuperation">{{ $dateLimiteRecup?->format('d/m/Y') }}</span>
                            </small>
                        </div>

                        {{-- Date réelle de remise --}}
                        <div class="col-md-6 mb-3">
                            <label class="icon-label">
                                <i class="bi bi-box-arrow-up"></i>
                                Date réelle de remise
                            </label>
                            <input type="date" name="date_remise"
                                   id="date_remise"
                                   class="form-control form-control-modern @error('date_remise') is-invalid @enderror"
                                   value="{{ old('date_remise', $lot_copy->date_remise?->format('Y-m-d')) }}">
                            @error('date_remise')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                <i class="bi bi-clock-history"></i> Date limite: <span id="limite_remise">{{ $dateLimiteRemise?->format('d/m/Y') }}</span>
                            </small>
                        </div>
                    </div>

                    {{-- Info délais --}}
                    <div class="alert alert-info border-0 bg-light" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-info-circle-fill fs-4 me-3 text-info"></i>
                            <div>
                                <strong>Rappel des délais :</strong>
                                <ul class="mb-0 mt-2">
                                    <li>Récupération : <strong>2 jours</strong> après la date de disponibilité</li>
                                    <li>Remise : <strong>12 jours</strong> après la date limite de récupération</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Colonne latérale : Timeline --}}
            <div class="col-lg-4">
                <div class="form-step">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-clock-history text-primary me-2"></i>
                        Chronologie du lot
                    </h6>
                    
                    <div class="timeline">
                        {{-- Disponibilité --}}
                        <div class="timeline-item completed">
                            <div class="date-card">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <strong class="text-success">
                                        <i class="bi bi-check-circle-fill me-1"></i>
                                        Disponible
                                    </strong>
                                    <span class="badge bg-success">Fait</span>
                                </div>
                                <div class="text-muted small">
                                    {{ $lot_copy->date_disponible?->format('d/m/Y') }}
                                </div>
                            </div>
                        </div>

                        {{-- Récupération --}}
                        <div class="timeline-item {{ $lot_copy->date_recuperation ? 'completed' : '' }}">
                            <div class="date-card {{ $lot_copy->date_recuperation ? '' : 'provisional' }}">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <strong class="{{ $lot_copy->date_recuperation ? 'text-success' : 'text-info' }}">
                                        <i class="bi bi-{{ $lot_copy->date_recuperation ? 'check-circle-fill' : 'clock' }} me-1"></i>
                                        Récupération
                                    </strong>
                                    @if($lot_copy->date_recuperation)
                                        <span class="badge bg-success">Fait</span>
                                    @else
                                        <span class="badge bg-info">En attente</span>
                                    @endif
                                </div>
                                <div class="text-muted small">
                                    <div>Limite: {{ $dateLimiteRecup?->format('d/m/Y') }}</div>
                                    @if($lot_copy->date_recuperation)
                                        <div class="mt-1">Réelle: {{ $lot_copy->date_recuperation->format('d/m/Y') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Remise --}}
                        <div class="timeline-item {{ $lot_copy->date_remise ? ($isRetard ? 'late' : 'completed') : '' }}">
                            <div class="date-card {{ $lot_copy->date_remise ? ($isRetard ? 'late' : '') : 'provisional' }}">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <strong class="{{ $lot_copy->date_remise ? ($isRetard ? 'text-danger' : 'text-success') : 'text-info' }}">
                                        <i class="bi bi-{{ $lot_copy->date_remise ? ($isRetard ? 'exclamation-triangle-fill' : 'check-circle-fill') : 'clock' }} me-1"></i>
                                        Remise
                                    </strong>
                                    @if($lot_copy->date_remise)
                                        @if($isRetard)
                                            <span class="badge bg-danger">En retard</span>
                                        @else
                                            <span class="badge bg-success">Fait</span>
                                        @endif
                                    @else
                                        <span class="badge bg-info">En attente</span>
                                    @endif
                                </div>
                                <div class="text-muted small">
                                    <div>Limite: {{ $dateLimiteRemise?->format('d/m/Y') }}</div>
                                    @if($lot_copy->date_remise)
                                        <div class="mt-1">Réelle: {{ $lot_copy->date_remise->format('d/m/Y') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Progression --}}
                    <div class="mt-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-semibold">Progression</span>
                            <span class="fw-bold text-primary">{{ $lot_copy->date_remise ? '100' : ($lot_copy->date_recuperation ? '50' : '0') }}%</span>
                        </div>
                        <div class="progress" style="height: 10px; border-radius: 10px;">
                            <div class="progress-bar bg-primary" 
                                 style="width: {{ $lot_copy->date_remise ? '100' : ($lot_copy->date_recuperation ? '50' : '0') }}%">
                            </div>
                        </div>
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
                        <i class="bi bi-check-circle me-2"></i>Mettre à jour
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

    // ================= Changement de module =================
    $('#module_id').on('change', function() {
        const selected = this.options[this.selectedIndex];
        
        const nom = selected.dataset.enseignantNom || '';
        const prenom = selected.dataset.enseignantPrenom || '';
        const matricule = selected.dataset.enseignantMatricule || '';
        const enseignantId = selected.dataset.enseignantId || '';

        if (nom && prenom) {
            $('#enseignant-name').text(`${prenom} ${nom}`);
            $('#enseignant-matricule').text(`Matricule: ${matricule}`);
            $('#enseignant_id_hidden').val(enseignantId);
        }
    });

    // ================= Calcul automatique des dates limites =================
    function updateProvisionalDates() {
        const depotInput = document.getElementById('date_depot');
        const depot = new Date(depotInput.value);
        
        if (!isNaN(depot)) {
            // Date limite de récupération (+2 jours)
            let recupProv = new Date(depot);
            recupProv.setDate(recupProv.getDate() + 2);
            
            // Date limite de remise (+12 jours après récup)
            let remiseProv = new Date(recupProv);
            remiseProv.setDate(remiseProv.getDate() + 12);
            
            // Mise à jour des affichages
            $('#limite_recuperation').text(formatDate(recupProv));
            $('#limite_remise').text(formatDate(remiseProv));
        }
    }

    // Format date DD/MM/YYYY
    function formatDate(date) {
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();
        return `${day}/${month}/${year}`;
    }

    // Initialisation au chargement
    updateProvisionalDates();

    // Mise à jour lors du changement de date
    $('#date_depot').on('change', updateProvisionalDates);

    // ================= Validation du formulaire =================
    $('#editLotForm').on('submit', function(e) {
        let isValid = true;
        let firstError = null;

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
            
            if (firstError) {
                $('html, body').animate({
                    scrollTop: firstError.closest('.form-step').offset().top - 100
                }, 500);
                firstError.focus();
            }

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: 'Veuillez remplir tous les champs obligatoires',
                    confirmButtonColor: '#dc3545'
                });
            }
        }
    });

    // ================= Confirmation avant reset =================
    $('button[type="reset"]').on('click', function(e) {
        e.preventDefault();
        
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: "Toutes les modifications seront perdues",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ffc107',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Oui, réinitialiser',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                }
            });
        } else {
            if (confirm('Êtes-vous sûr de vouloir réinitialiser le formulaire ?')) {
                location.reload();
            }
        }
    });

});
</script>

{{-- SweetAlert2 pour les notifications --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection