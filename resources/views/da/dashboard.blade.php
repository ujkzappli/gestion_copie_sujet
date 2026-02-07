@extends('layouts.app')

@section('title', 'Dashboard - Directeur Académique')

@section('content')

{{-- ====== CARTES STATISTIQUES ====== --}}
<div class="row g-3 mb-3 row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-2 row-cols-xl-4">

    {{-- Départements --}}
    <div class="col">
        <div class="alert-success alert mb-0">
            <div class="d-flex align-items-center">
                <div class="avatar rounded no-thumbnail bg-success text-light">
                    <i class="fa fa-building fa-lg"></i>
                </div>
                <div class="flex-fill ms-3 text-truncate">
                    <div class="h6 mb-0">Départements</div>
                    <span class="small">{{ $departementsCount }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Enseignants --}}
    <div class="col">
        <div class="alert-danger alert mb-0">
            <div class="d-flex align-items-center">
                <div class="avatar rounded no-thumbnail bg-danger text-light">
                    <i class="fa fa-users fa-lg"></i>
                </div>
                <div class="flex-fill ms-3 text-truncate">
                    <div class="h6 mb-0">Enseignants</div>
                    <span class="small">{{ $enseignantsCount }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Chefs de scolarité --}}
    <div class="col">
        <div class="alert-warning alert mb-0">
            <div class="d-flex align-items-center">
                <div class="avatar rounded no-thumbnail bg-warning text-light">
                    <i class="fa fa-id-badge fa-lg"></i>
                </div>
                <div class="flex-fill ms-3 text-truncate">
                    <div class="h6 mb-0">Chefs de scolarité</div>
                    <span class="small">{{ $csCount }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Chefs de département --}}
    <div class="col">
        <div class="alert-info alert mb-0">
            <div class="d-flex align-items-center">
                <div class="avatar rounded no-thumbnail bg-info text-light">
                    <i class="fa fa-user-secret fa-lg"></i>
                </div>
                <div class="flex-fill ms-3 text-truncate">
                    <div class="h6 mb-0">Chefs de département</div>
                    <span class="small">{{ $cdCount }}</span>
                </div>
            </div>
        </div>
    </div>

</div>
{{-- ====== FIN CARTES ====== --}}


{{-- ====== TABLE : ENSEIGNANTS DE L’ÉTABLISSEMENT ====== --}}
<div class="row g-3 mb-3">
    <div class="col-md-12">
        <div class="card">

            <div class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                <h6 class="m-0 fw-bold">Enseignants de l’établissement</h6>
            </div>

            <div class="card-body">
                <table id="myDataTable" class="table table-hover align-middle mb-0" style="width:100%;">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nom & Prénom</th>
                            <th>Email</th>
                            <th>Département</th>
                            <th>Statut</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($enseignants as $enseignant)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    {{ $enseignant->nom_utilisateur }}
                                    {{ $enseignant->prenom_utilisateur }}
                                </td>
                                <td>{{ $enseignant->email }}</td>
                                <td>
                                    {{ $enseignant->departement->libelle ?? '—' }}
                                </td>
                                <td>
                                    <span class="badge bg-success">Actif</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    Aucun enseignant trouvé
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $('#myDataTable')
        .addClass('nowrap')
        .dataTable({
            responsive: true
        });
</script>
@endpush
