@extends('layouts.app')

@section('title', 'Gestion des départements')

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">Ajouter un département</h4>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('departements.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Sigle</label>
                        <input type="text" name="sigle" class="form-control @error('sigle') is-invalid @enderror" value="{{ old('sigle') }}">
                        @error('sigle') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Libellé</label>
                        <input type="text" name="libelle" class="form-control @error('libelle') is-invalid @enderror" value="{{ old('libelle') }}">
                        @error('libelle') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Établissement</label>
                    <select name="etablissement_id" class="form-select @error('etablissement_id') is-invalid @enderror">
                        <option value="">-- Choisir un établissement --</option>
                        @foreach($etablissements as $etablissement)
                            <option value="{{ $etablissement->id }}" {{ old('etablissement_id') == $etablissement->id ? 'selected' : '' }}>
                                {{ $etablissement->sigle }} — {{ $etablissement->libelle }}
                            </option>
                        @endforeach
                    </select>
                    @error('etablissement_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('departements.index') }}" class="btn btn-secondary me-2">Annuler</a>
                    <button class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <h4 class="mb-3">Liste des départements</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <table id="departementTable" class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Sigle</th>
                        <th>Libellé</th>
                        <th>Établissement</th>
                        <th width="160">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($departements as $departement)
                        <tr>
                            <td>{{ $departement->id }}</td>
                            <td>{{ $departement->sigle }}</td>
                            <td>{{ $departement->libelle }}</td>
                            <td><span class="badge bg-info">{{ $departement->etablissement->sigle }}</span></td>
                            <td class="text-center">
                                <a href="{{ route('departements.show', $departement) }}" class="btn btn-sm btn-outline-info" title="Voir"><i class="bi bi-eye-fill"></i></a>
                                <a href="{{ route('departements.edit', $departement) }}" class="btn btn-sm btn-outline-warning" title="Modifier"><i class="bi bi-pencil-square"></i></a>
                                <form action="{{ route('departements.destroy', $departement) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce département ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer"><i class="bi bi-trash-fill"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted">Aucun département enregistré</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#departementTable').DataTable({
        responsive: false,
        pageLength: 25,
        order: [[0, 'asc']], // trier par ID
        language: {
            search: "Recherche :",
            lengthMenu: "Afficher _MENU_ entrées",
            info: "Affichage de _START_ à _END_ sur _TOTAL_ entrées",
            paginate: { first: "Premier", last: "Dernier", next: "Suivant", previous: "Précédent" }
        }
    });
});
</script>
@endpush
