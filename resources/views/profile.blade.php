@extends('layouts.app')

@section('content')
<div class="main px-lg-4 px-md-4">
    <div class="body d-flex py-3">
        <div class="container-xxl">
            <div class="row g-3">

                <!-- LEFT : profil photo + infos -->
                <div class="col-xl-4 col-lg-5 col-md-12">
                    <div class="card profile-card flex-column mb-3">
                        <div class="card-header py-3 bg-transparent">
                            <h6 class="mb-0 fw-bold">Profile</h6>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <div class="profile-block text-center mx-auto">
                                <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('assets/images/lg/avatar4.svg') }}"
                                     class="avatar xl rounded img-thumbnail shadow-sm"
                                     alt="Avatar">
                            </div>
                            <h6 class="mt-3 fw-bold text-center">
                                {{ Auth::user()->nom_utilisateur }} {{ Auth::user()->prenom_utilisateur }}
                            </h6>
                            <span class="text-muted text-center">
                                {{ Auth::user()->type }}
                            </span>
                            @if(Auth::user()->adresse)
                                <p class="mt-3 text-center">{{ Auth::user()->adresse }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- RIGHT : form -->
                <div class="col-xl-8 col-lg-7 col-md-12">
                    <div class="card mb-3">
                        <div class="card-header py-3 bg-transparent">
                            <h6 class="mb-0 fw-bold">Profile Settings</h6>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="row g-4">
                                @csrf
                                @method('PUT')

                                <div class="col-sm-6">
                                    <label class="form-label">Nom</label>
                                    <input type="text" name="nom_utilisateur" class="form-control"
                                        value="{{ old('nom_utilisateur', Auth::user()->nom_utilisateur) }}" required>
                                </div>

                                <div class="col-sm-6">
                                    <label class="form-label">Prénom</label>
                                    <input type="text" name="prenom_utilisateur" class="form-control"
                                        value="{{ old('prenom_utilisateur', Auth::user()->prenom_utilisateur) }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" value="{{ Auth::user()->email }}" disabled>
                                </div>

                                <!-- PHONE & COUNTRY -->
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label">Pays</label>
                                        <select class="form-select" id="country" onchange="updateCountryCode()">
                                            <option value="+226" {{ (old('phone_country_code', Auth::user()->phone_country_code) == '+226') ? 'selected' : '' }}>Burkina Faso (+226)</option>
                                            <option value="+221" {{ (old('phone_country_code', Auth::user()->phone_country_code) == '+221') ? 'selected' : '' }}>Sénégal (+221)</option>
                                            <option value="+225" {{ (old('phone_country_code', Auth::user()->phone_country_code) == '+225') ? 'selected' : '' }}>Côte d’Ivoire (+225)</option>
                                            <option value="+33" {{ (old('phone_country_code', Auth::user()->phone_country_code) == '+33') ? 'selected' : '' }}>France (+33)</option>
                                            <option value="+1" {{ (old('phone_country_code', Auth::user()->phone_country_code) == '+1') ? 'selected' : '' }}>USA (+1)</option>
                                            <option value="+223" {{ (old('phone_country_code', Auth::user()->phone_country_code) == '+223') ? 'selected' : '' }}>Mali (+223)</option>
                                            <option value="+227" {{ (old('phone_country_code', Auth::user()->phone_country_code) == '+227') ? 'selected' : '' }}>Niger (+227)</option>
                                            <option value="+1" {{ (old('phone_country_code', Auth::user()->phone_country_code) == '+1') ? 'selected' : '' }}>Canada (+1)</option>
                                            <option value="+32" {{ (old('phone_country_code', Auth::user()->phone_country_code) == '+32') ? 'selected' : '' }}>Belgique (+32)</option>
                                            <option value="+41" {{ (old('phone_country_code', Auth::user()->phone_country_code) == '+41') ? 'selected' : '' }}>Suisse (+41)</option>
                                            <option value="+49" {{ (old('phone_country_code', Auth::user()->phone_country_code) == '+49') ? 'selected' : '' }}>Allemagne (+49)</option>
                                            <option value="+34" {{ (old('phone_country_code', Auth::user()->phone_country_code) == '+34') ? 'selected' : '' }}>Espagne (+34)</option>
                                            <option value="+39" {{ (old('phone_country_code', Auth::user()->phone_country_code) == '+39') ? 'selected' : '' }}>Italie (+39)</option>
                                            <option value="+212" {{ (old('phone_country_code', Auth::user()->phone_country_code) == '+212') ? 'selected' : '' }}>Maroc (+212)</option>
                                            <option value="+216" {{ (old('phone_country_code', Auth::user()->phone_country_code) == '+216') ? 'selected' : '' }}>Tunisie (+216)</option>
                                            <option value="+213" {{ (old('phone_country_code', Auth::user()->phone_country_code) == '+213') ? 'selected' : '' }}>Algérie (+213)</option>
                                            <option value="+961" {{ (old('phone_country_code', Auth::user()->phone_country_code) == '+961') ? 'selected' : '' }}>Liban (+961)</option>
                                            <option value="+352" {{ (old('phone_country_code', Auth::user()->phone_country_code) == '+352') ? 'selected' : '' }}>Luxembourg (+352)</option>
                                            <option value="+351" {{ (old('phone_country_code', Auth::user()->phone_country_code) == '+351') ? 'selected' : '' }}>Portugal (+351)</option>
                                            <option value="+250" {{ (old('phone_country_code', Auth::user()->phone_country_code) == '+250') ? 'selected' : '' }}>Rwanda (+250)</option>
                                            <option value="+27" {{ (old('phone_country_code', Auth::user()->phone_country_code) == '+27') ? 'selected' : '' }}>Afrique du Sud (+27)</option>
                                            <option value="+20" {{ (old('phone_country_code', Auth::user()->phone_country_code) == '+20') ? 'selected' : '' }}>Égypte (+20)</option>
                                            <option value="+44" {{ (old('phone_country_code', Auth::user()->phone_country_code) == '+44') ? 'selected' : '' }}>Royaume-Uni (+44)</option>
                                            <option value="+91" {{ (old('phone_country_code', Auth::user()->phone_country_code) == '+91') ? 'selected' : '' }}>Inde (+91)</option>
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <label class="form-label">Code</label>
                                        <input type="text"
                                            id="phone_country_code"
                                            name="phone_country_code"
                                            class="form-control"
                                            value="{{ old('phone_country_code', Auth::user()->phone_country_code ?? '+221') }}"
                                            readonly>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Numéro de téléphone</label>
                                        <input type="text"
                                            name="phone_number"
                                            class="form-control"
                                            placeholder="Ex : 77 12 45 67"
                                            value="{{ old('phone_number', Auth::user()->phone_number) }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Matricule</label>
                                    <input type="text"
                                        class="form-control"
                                        value="{{ Auth::user()->matricule_utilisateur }}"
                                        readonly>
                                </div>


                                <div class="col-md-6">
                                    <label class="form-label">Mot de passe</label>
                                    <input type="password" name="password" class="form-control"
                                        placeholder="Laisser vide pour ne pas changer">
                                </div>

                                <!-- Type de compte (visible mais non modifiable) -->
                                <div class="col-md-6">
                                    <label class="form-label">Type de compte</label>
                                    <input type="text"
                                        class="form-control"
                                        value="{{ Auth::user()->type }}"
                                        readonly>
                                </div>

                                <!-- Département (si existant, visible mais non modifiable) -->
                                @if(Auth::user()->departement_id)
                                <div class="col-md-6">
                                    <label class="form-label">Département</label>
                                    <input type="text"
                                        class="form-control"
                                        value="{{ Auth::user()->departement_id }}"
                                        readonly>
                                </div>
                                @endif

                                <!-- Établissement (si existant, visible mais non modifiable) -->
                                @if(Auth::user()->etablissement_id)
                                <div class="col-md-6">
                                    <label class="form-label">Établissement</label>
                                    <input type="text"
                                        class="form-control"
                                        value="{{ Auth::user()->etablissement_id }}"
                                        readonly>
                                </div>
                                @endif


                                <!-- Photo -->
                                <div class="col-12">
                                    <label class="form-label">Photo de profil</label>

                                    <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror">
                                    @error('photo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Adresse -->
                                <div class="col-12">
                                    <label class="form-label">Adresse</label>
                                    <textarea name="adresse" class="form-control">{{ old('adresse', Auth::user()->adresse) }}</textarea>
                                </div>

                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn btn-primary px-5">Enregistrer</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>

function updateCountryCode() {
    const select = document.getElementById('country');
    document.getElementById('phone_country_code').value = select.value;
}

// initial display on page load
document.addEventListener('DOMContentLoaded', handleTypeChange);
</script>
@endsection
