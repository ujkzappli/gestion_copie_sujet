@extends('layouts.app')

@section('title', $notification->data['title'] ?? $notification->data['titre'])

@section('content')
<div class="container">
    <h4>{{ $notification->data['title'] ?? $notification->data['titre'] }}</h4>
    <p>{{ $notification->data['message'] }}</p>
    <p>
        <small class="text-muted">
            Envoyé le {{ $notification->created_at->format('d/m/Y H:i') }}
        </small>
    </p>
    <a href="{{ route('notifications.index') }}" class="btn btn-secondary">Retour</a>
</div>
@endsection
