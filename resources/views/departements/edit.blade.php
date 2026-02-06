@extends('layouts.app')

@section('title', 'eBazar - Dashboard')

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">Modifier le département</h4>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('departements.update', $departement) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Code</label>
                        <input type="text" name="code"
                               class="form-control @error('code') is-invalid @enderror"
                               value="{{ old('code', $departement->code) }}">
                        @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Sigle</label>
                        <input type="text" name="sigle"
                               class="form-control @error('sigle') is-invalid @enderror"
                               value="{{ old('sigle', $departement->sigle) }}">
                        @error('sigle')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Libellé</label>
                    <input type="text" name="libelle"
                           class="form-control @error('libelle') is-invalid @enderror"
                           value="{{ old('libelle', $departement->libelle) }}">
                    @error('libelle')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Établissement</label>
                    <select name="etablissement_id"
                            class="form-select @error('etablissement_id') is-invalid @enderror">
                        @foreach($etablissements as $etablissement)
                            <option value="{{ $etablissement->id }}"
                                {{ $departement->etablissement_id == $etablissement->id ? 'selected' : '' }}>
                                {{ $etablissement->sigle }} — {{ $etablissement->libelle }}
                            </option>
                        @endforeach
                    </select>
                    @error('etablissement_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('departements.index') }}"
                       class="btn btn-secondary me-2">Retour</a>
                    <button class="btn btn-warning">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
