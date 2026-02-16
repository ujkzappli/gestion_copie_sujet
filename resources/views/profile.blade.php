@extends('layouts.app')

@section('title', 'Mon Profil')

@push('styles')
<style>
.profile-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 15px;
    padding: 25px;
    color: white;
    margin-bottom: 25px;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
}
.profile-card-modern {
    background: white;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
}
.profile-card-modern:hover {
    box-shadow: 0 4px 20px rgba(0,0,0,0.12);
}
.profile-avatar-container {
    position: relative;
    width: 150px;
    height: 150px;
    margin: 0 auto 15px;
}
.profile-avatar {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid white;
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    transition: all 0.3s ease;
}
.profile-avatar:hover {
    transform: scale(1.05);
}
.avatar-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background: rgba(0,0,0,0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.3s ease;
    cursor: pointer;
}
.profile-avatar-container:hover .avatar-overlay {
    opacity: 1;
}
.avatar-overlay i {
    font-size: 2rem;
    color: white;
}
.upload-photo-btn {
    position: absolute;
    bottom: 5px;
    right: 5px;
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    transition: all 0.3s ease;
}
.upload-photo-btn:hover {
    transform: scale(1.1);
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
.form-control-modern:disabled,
.form-control-modern:read-only {
    background-color: #f8f9fa;
    border-color: #dee2e6;
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
.password-toggle {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #6c757d;
}
.info-text {
    font-size: 0.8rem;
    color: #6c757d;
    margin-top: 3px;
}
.profile-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 12px;
    background: rgba(255,255,255,0.2);
    border-radius: 20px;
    font-size: 0.8rem;
    margin: 3px;
}
</style>
@endpush

@section('content')
<div class="container-fluid py-4">

    {{-- Header compact --}}
    <div class="profile-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="mb-1 fw-bold">
                    <i class="bi bi-person-circle me-2"></i>Mon Profil
                </h3>
                <small class="opacity-75">Gérez vos informations personnelles</small>
            </div>
            <div class="profile-badge">
                <i class="bi bi-shield-check"></i>
                Compte sécurisé
            </div>
        </div>
    </div>

    {{-- Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-3" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <strong>Erreurs:</strong> {{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" id="profileForm">
        @csrf
        @method('PUT')

        {{-- Card unique --}}
        <div class="profile-card-modern">
            
            <div class="row g-4">
                
                {{-- Avatar et infos de base --}}
                <div class="col-lg-3">
                    <div class="text-center">
                        <div class="profile-avatar-container">
                            <img id="profileImage" 
                                 src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('assets/images/lg/avatar4.svg') }}"
                                 class="profile-avatar"
                                 alt="Photo">
                            
                            <label for="photoInput" class="avatar-overlay">
                                <i class="bi bi-camera-fill"></i>
                            </label>
                            
                            <label for="photoInput" class="upload-photo-btn">
                                <i class="bi bi-camera"></i>
                            </label>
                            
                            <input type="file" name="photo" id="photoInput" class="d-none" accept="image/*">
                        </div>

                        <h5 class="fw-bold mb-1">
                            {{ Auth::user()->prenom_utilisateur }} {{ Auth::user()->nom_utilisateur }}
                        </h5>
                        <p class="text-muted mb-2" style="font-size: 0.85rem;">
                            <i class="bi bi-briefcase me-1"></i>{{ Auth::user()->type }}
                        </p>
                        <div class="mb-2">
                            <span class="badge bg-info" style="font-size: 0.75rem;">
                                <i class="bi bi-hash"></i> {{ Auth::user()->matricule_utilisateur }}
                            </span>
                        </div>
                        <small class="text-muted d-block" style="font-size: 0.75rem;">
                            <i class="bi bi-info-circle me-1"></i>Cliquez pour changer
                        </small>
                    </div>
                </div>

                {{-- Formulaire --}}
                <div class="col-lg-9">
                    
                    {{-- Infos personnelles --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="icon-label">
                                <i class="bi bi-person"></i>Nom
                            </label>
                            <input type="text" name="nom_utilisateur" class="form-control form-control-modern"
                                   value="{{ old('nom_utilisateur', Auth::user()->nom_utilisateur) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="icon-label">
                                <i class="bi bi-person"></i>Prénom
                            </label>
                            <input type="text" name="prenom_utilisateur" class="form-control form-control-modern"
                                   value="{{ old('prenom_utilisateur', Auth::user()->prenom_utilisateur) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="icon-label">
                                <i class="bi bi-envelope"></i>Email
                            </label>
                            <input type="email" class="form-control form-control-modern" 
                                   value="{{ Auth::user()->email }}" disabled>
                            <small class="info-text"><i class="bi bi-lock-fill"></i> Non modifiable</small>
                        </div>

                        <div class="col-md-6">
                            <label class="icon-label">
                                <i class="bi bi-hash"></i>Matricule
                            </label>
                            <input 
                                type="text" 
                                name="matricule_utilisateur"
                                class="form-control form-control-modern"
                                value="{{ old('matricule_utilisateur', Auth::user()->matricule_utilisateur) }}" 
                                readonly>
                            <small class="info-text"><i class="bi bi-lock-fill"></i> Non modifiable</small>
                        </div>
                    </div>

                    {{-- Divider Contact --}}
                    <div class="section-divider">
                        <span class="section-divider-title">
                            <i class="bi bi-telephone-fill"></i>Contact
                        </span>
                    </div>

                    {{-- Contact --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="icon-label">
                                <i class="bi bi-globe"></i>Pays
                            </label>
                            <select class="form-select form-select-modern" id="country" onchange="updateCountryCode()">
                                <option value="+226" {{ (old('phone_country_code', Auth::user()->phone_country_code) == '+226') ? 'selected' : '' }}>🇧🇫 Burkina Faso</option>
                                <option value="+221" {{ (old('phone_country_code', Auth::user()->phone_country_code) == '+221') ? 'selected' : '' }}>🇸🇳 Sénégal</option>
                                <option value="+225" {{ (old('phone_country_code', Auth::user()->phone_country_code) == '+225') ? 'selected' : '' }}>🇨🇮 Côte d'Ivoire</option>
                                <option value="+33" {{ (old('phone_country_code', Auth::user()->phone_country_code) == '+33') ? 'selected' : '' }}>🇫🇷 France</option>
                                <option value="+1" {{ (old('phone_country_code', Auth::user()->phone_country_code) == '+1') ? 'selected' : '' }}>🇺🇸 USA</option>
                                <option value="+223" {{ (old('phone_country_code', Auth::user()->phone_country_code) == '+223') ? 'selected' : '' }}>🇲🇱 Mali</option>
                                <option value="+227" {{ (old('phone_country_code', Auth::user()->phone_country_code) == '+227') ? 'selected' : '' }}>🇳🇪 Niger</option>
                                <option value="+237" {{ (old('phone_country_code', Auth::user()->phone_country_code) == '+237') ? 'selected' : '' }}>🇨🇲 Cameroun</option>
                            </select>
                        </div>

                        <div class="col-md-8">
                            <label class="icon-label">
                                <i class="bi bi-phone"></i>Téléphone
                            </label>
                            <div class="input-group">
                                <span class="input-group-text" id="phone-code-display" style="border-radius: 10px 0 0 10px; border: 2px solid #e9ecef; border-right: none;">
                                    {{ old('phone_country_code', Auth::user()->phone_country_code ?? '+226') }}
                                </span>
                                <input type="hidden" id="phone_country_code" name="phone_country_code"
                                       value="{{ old('phone_country_code', Auth::user()->phone_country_code ?? '+226') }}">
                                <input type="text" name="phone_number" class="form-control form-control-modern"
                                       style="border-radius: 0 10px 10px 0;" placeholder="70 12 34 56"
                                       value="{{ old('phone_number', Auth::user()->phone_number) }}">
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="icon-label">
                                <i class="bi bi-geo-alt"></i>Adresse
                            </label>
                            <textarea name="adresse" class="form-control form-control-modern" rows="2"
                                      placeholder="Votre adresse complète">{{ old('adresse', Auth::user()->adresse) }}</textarea>
                        </div>
                    </div>

                    {{-- Divider Sécurité --}}
                    <div class="section-divider">
                        <span class="section-divider-title">
                            <i class="bi bi-shield-lock-fill"></i>Sécurité
                        </span>
                    </div>

                    {{-- Sécurité & Infos compte --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="icon-label">
                                <i class="bi bi-key"></i>Mot de passe
                            </label>
                            <div class="position-relative">
                                <input type="password" name="password" id="password" class="form-control form-control-modern"
                                       placeholder="Laisser vide si pas de changement">
                                <span class="password-toggle" onclick="togglePassword('password', this)">
                                    <i class="bi bi-eye"></i>
                                </span>
                            </div>
                            <small class="info-text"><i class="bi bi-info-circle"></i> Optionnel</small>
                        </div>

                        <div class="col-md-4">
                            <label class="icon-label">
                                <i class="bi bi-person-badge"></i>Type de compte
                            </label>
                            <input type="text"
                                name="type"
                                class="form-control form-control-modern"
                                value="{{ old('type', Auth::user()->type) }}"
                                readonly>
                        </div>

                        @if(Auth::user()->departement_id)
                        <div class="col-md-4">
                            <label class="icon-label">
                                <i class="bi bi-diagram-3"></i>Département
                            </label>
                            <input type="text" class="form-control form-control-modern"
                                   value="{{ Auth::user()->departement->nom ?? Auth::user()->departement_id }}" readonly>
                        </div>
                        @endif

                        @if(Auth::user()->etablissement_id)
                        <div class="col-md-4">
                            <label class="icon-label">
                                <i class="bi bi-building"></i>Établissement
                            </label>
                            <input type="text" class="form-control form-control-modern"
                                   value="{{ Auth::user()->etablissement->nom ?? Auth::user()->etablissement_id }}" readonly>
                        </div>
                        @endif
                    </div>

                    {{-- Boutons --}}
                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                        <button type="button" class="btn btn-outline-secondary btn-modern" onclick="window.history.back()">
                            <i class="bi bi-arrow-left me-1"></i>Retour
                        </button>
                        <div class="d-flex gap-2">
                            <button type="reset" class="btn btn-outline-warning btn-modern">
                                <i class="bi bi-arrow-clockwise me-1"></i>Réinitialiser
                            </button>
                            <button type="submit" class="btn btn-primary-modern btn-modern">
                                <i class="bi bi-check-circle me-1"></i>Enregistrer
                            </button>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </form>

</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {

    // ================= Aperçu photo =================
    $('#photoInput').on('change', function(e) {
        const file = e.target.files[0];
        
        if (file) {
            if (!file.type.match('image.*')) {
                alert('Veuillez sélectionner une image valide');
                this.value = '';
                return;
            }

            if (file.size > 2 * 1024 * 1024) {
                alert('La taille de l\'image ne doit pas dépasser 2 MB');
                this.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(event) {
                $('#profileImage').attr('src', event.target.result);
                $('#profileImage').addClass('animate__animated animate__pulse');
                setTimeout(() => {
                    $('#profileImage').removeClass('animate__animated animate__pulse');
                }, 1000);
            };
            reader.readAsDataURL(file);
        }
    });

    // ================= Mise à jour code pays =================
    window.updateCountryCode = function() {
        const select = document.getElementById('country');
        const code = select.value;
        document.getElementById('phone_country_code').value = code;
        document.getElementById('phone-code-display').textContent = code;
    };

    // ================= Toggle password =================
    window.togglePassword = function(inputId, icon) {
        const input = document.getElementById(inputId);
        const iconElement = icon.querySelector('i');
        
        if (input.type === 'password') {
            input.type = 'text';
            iconElement.classList.remove('bi-eye');
            iconElement.classList.add('bi-eye-slash');
        } else {
            input.type = 'password';
            iconElement.classList.remove('bi-eye-slash');
            iconElement.classList.add('bi-eye');
        }
    };

    // ================= Confirmation reset =================
    $('button[type="reset"]').on('click', function(e) {
        e.preventDefault();
        if (confirm('Réinitialiser le formulaire ? Toutes les modifications seront perdues.')) {
            location.reload();
        }
    });

    // ================= Validation =================
    $('#profileForm').on('submit', function(e) {
        const password = $('input[name="password"]').val();
        if (password && password.length > 0) {
            e.preventDefault();
            if (confirm('Confirmer le changement de mot de passe ? Vous devrez vous reconnecter.')) {
                $('#profileForm').off('submit').submit();
            }
        }
    });

});
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@endsection