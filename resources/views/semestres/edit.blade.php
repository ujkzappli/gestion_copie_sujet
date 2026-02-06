@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">Modifier le semestre</div>
        <div class="card-body">
            <form method="POST" action="{{ route('semestres.update', $semestre) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Numéro</label>
                    <input type="number" name="numero" class="form-control"
                           value="{{ $semestre->numero }}" required>
                </div>

                <div class="mb-3">
                    <label>Libellé</label>
                    <input type="text" name="libelle" class="form-control"
                           value="{{ $semestre->libelle }}" required>
                </div>

                <button class="btn btn-primary">Mettre à jour</button>
            </form>
        </div>
    </div>
</div>
@endsection
