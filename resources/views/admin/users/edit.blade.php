@extends('layouts.app')

@section('title', 'Modifier un utilisateur')

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">Modifier l'utilisateur</h4>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Nom / Prénom --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nom</label>
                        <input type="text" name="nom_utilisateur"
                               class="form-control @error('nom_utilisateur') is-invalid @enderror"
                               value="{{ old('nom_utilisateur', $user->nom_utilisateur) }}">
                        @error('nom_utilisateur')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Prénom</label>
                        <input type="text" name="prenom_utilisateur"
                               class="form-control @error('prenom_utilisateur') is-invalid @enderror"
                               value="{{ old('prenom_utilisateur', $user->prenom_utilisateur) }}">
                        @error('prenom_utilisateur')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Email / Matricule --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $user->email) }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Matricule</label>
                        <input type="text" name="matricule_utilisateur"
                               class="form-control @error('matricule_utilisateur') is-invalid @enderror"
                               value="{{ old('matricule_utilisateur', $user->matricule_utilisateur) }}">
                        @error('matricule_utilisateur')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Type utilisateur --}}
                <div class="mb-3">
                    <label class="form-label">Type</label>
                    <select name="type"
                            class="form-select @error('type') is-invalid @enderror" id="user-type">
                        <option value="">-- Sélectionner un type --</option>
                        @foreach(['Admin','President','Enseignant','CD','CS','DA'] as $type)
                            <option value="{{ $type }}" @selected(old('type', $user->type) == $type)>{{ $type }}</option>
                        @endforeach
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Établissement --}}
                <div class="mb-3" id="etablissement-field" style="display:none;">
                    <label class="form-label">Établissement</label>
                    <select name="etablissement_id"
                            class="form-select @error('etablissement_id') is-invalid @enderror">
                        <option value="">-- Sélectionner un établissement --</option>
                        @foreach($etablissements as $etablissement)
                            <option value="{{ $etablissement->id }}"
                                {{ old('etablissement_id', $user->etablissement_id) == $etablissement->id ? 'selected' : '' }}>
                                {{ $etablissement->sigle }} — {{ $etablissement->libelle }}
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
                    <select name="departement_id"
                            class="form-select @error('departement_id') is-invalid @enderror">
                        <option value="">-- Sélectionner un département --</option>
                        @foreach($departements as $departement)
                            <option value="{{ $departement->id }}"
                                {{ old('departement_id', $user->departement_id) == $departement->id ? 'selected' : '' }}>
                                {{ $departement->sigle }} — {{ $departement->libelle }}
                            </option>
                        @endforeach
                    </select>
                    @error('departement_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Boutons --}}
                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary me-2">Retour</a>
                    <button class="btn btn-warning">Mettre à jour</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const typeField = document.getElementById('user-type');
    const etabField = document.getElementById('etablissement-field');
    const depField = document.getElementById('departement-field');

    function toggleFields() {
        const value = typeField.value;
        etabField.style.display = ['DA','CS','CD'].includes(value) ? 'block' : 'none';
        depField.style.display = ['Enseignant','CD'].includes(value) ? 'block' : 'none';
    }

    typeField.addEventListener('change', toggleFields);
    toggleFields(); // initial
});
</script>
@endpush
