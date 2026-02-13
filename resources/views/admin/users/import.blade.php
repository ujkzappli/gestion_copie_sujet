@extends('layouts.app')

@section('title', 'Importer des utilisateurs')

@section('content')
<div class="container py-4">
    <h4>Importer des utilisateurs depuis un CSV</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('import_errors'))
        <div class="alert alert-danger">
            <ul>
                @foreach(session('import_errors') as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.import.process') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Fichier CSV</label>
            <input type="file" name="csv_file" class="form-control" required>
            @error('csv_file')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Importer</button>
    </form>

    @if(session('import_errors'))
        <div class="alert alert-warning mt-3">
            <ul class="mb-0">
                @foreach(session('import_errors') as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
@endsection
