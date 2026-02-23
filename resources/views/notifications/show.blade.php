@extends('layouts.app')

@section('title', $notification->data['title'] ?? $notification->data['titre'] ?? 'Notification')

@push('styles')
<style>
.notification-detail-card {
    background: white;
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    margin-bottom: 20px;
}
.notification-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 15px;
    padding: 30px;
    color: white;
    margin-bottom: 30px;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
}
.notification-icon-large {
    width: 80px;
    height: 80px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    color: white;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
}
.notification-content {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 25px;
    line-height: 1.8;
    font-size: 1.05rem;
}
.notification-meta {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 12px;
}
.meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #6c757d;
}
.meta-item i {
    color: #667eea;
}
.btn-action {
    padding: 12px 24px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
}
.btn-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
</style>
@endpush

@section('content')
<div class="container-fluid py-4">

    {{-- Header avec gradient --}}
    <div class="notification-header">
        <div class="d-flex align-items-start gap-4">
            <div class="notification-icon-large">
                @php
                    $icon = 'bi-bell-fill';
                    if(isset($notification->data['type'])) {
                        switch($notification->data['type']) {
                            case 'success':
                                $icon = 'bi-check-circle-fill';
                                break;
                            case 'warning':
                                $icon = 'bi-exclamation-triangle-fill';
                                break;
                            case 'danger':
                                $icon = 'bi-x-circle-fill';
                                break;
                            default:
                                $icon = 'bi-info-circle-fill';
                        }
                    }
                @endphp
                <i class="bi {{ $icon }}"></i>
            </div>
            <div class="flex-grow-1">
                <h2 class="mb-2 fw-bold">
                    {{ $notification->data['title'] ?? $notification->data['titre'] ?? 'Notification' }}
                </h2>
                <div class="d-flex gap-3 flex-wrap opacity-90">
                    <span>
                        <i class="bi bi-calendar-event me-1"></i>
                        {{ $notification->created_at->format('d/m/Y') }}
                    </span>
                    <span>
                        <i class="bi bi-clock me-1"></i>
                        {{ $notification->created_at->format('H:i') }}
                    </span>
                    <span>
                        <i class="bi bi-hourglass-split me-1"></i>
                        {{ $notification->created_at->diffForHumans() }}
                    </span>
                </div>
            </div>
            @if(!$notification->read_at)
                <span class="badge bg-white text-primary px-3 py-2 fs-6">
                    <i class="bi bi-star-fill me-1"></i>Nouveau
                </span>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">

            {{-- Contenu de la notification --}}
            <div class="notification-detail-card">
                <h5 class="fw-bold mb-3 text-primary">
                    <i class="bi bi-file-text me-2"></i>Message
                </h5>
                <div class="notification-content">
                    {!! nl2br(e($notification->data['message'])) !!}
                </div>
            </div>

            {{-- Métadonnées --}}
            <div class="notification-detail-card">
                <h5 class="fw-bold mb-3 text-primary">
                    <i class="bi bi-info-circle me-2"></i>Informations
                </h5>
                <div class="notification-meta">
                    <div class="meta-item">
                        <i class="bi bi-calendar-check-fill"></i>
                        <div>
                            <small class="text-muted d-block">Date de réception</small>
                            <strong>{{ $notification->created_at->format('d/m/Y à H:i') }}</strong>
                        </div>
                    </div>
                    <div class="meta-item">
                        <i class="bi bi-clock-history"></i>
                        <div>
                            <small class="text-muted d-block">Il y a</small>
                            <strong>{{ $notification->created_at->diffForHumans() }}</strong>
                        </div>
                    </div>
                    <div class="meta-item">
                        <i class="bi bi-{{ $notification->read_at ? 'envelope-open-fill' : 'envelope-fill' }}"></i>
                        <div>
                            <small class="text-muted d-block">Statut</small>
                            <strong>{{ $notification->read_at ? 'Lue' : 'Non lue' }}</strong>
                        </div>
                    </div>
                    @if($notification->read_at)
                        <div class="meta-item">
                            <i class="bi bi-check-circle-fill"></i>
                            <div>
                                <small class="text-muted d-block">Lue le</small>
                                <strong>{{ $notification->read_at->format('d/m/Y à H:i') }}</strong>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Détails supplémentaires si disponibles --}}
            @if(isset($notification->data['details']) || isset($notification->data['lot_id']) || isset($notification->data['module']))
                <div class="notification-detail-card">
                    <h5 class="fw-bold mb-3 text-primary">
                        <i class="bi bi-card-list me-2"></i>Détails complémentaires
                    </h5>
                    <div class="notification-content">
                        @if(isset($notification->data['details']))
                            <p class="mb-2"><strong>Détails :</strong> {{ $notification->data['details'] }}</p>
                        @endif
                        @if(isset($notification->data['lot_id']))
                            <p class="mb-2">
                                <strong>Lot concerné :</strong> Lot #{{ $notification->data['lot_id'] }}
                            </p>
                        @endif
                        @if(isset($notification->data['module']))
                            <p class="mb-2"><strong>Module :</strong> {{ $notification->data['module'] }}</p>
                        @endif
                        @if(isset($notification->data['enseignant']))
                            <p class="mb-0"><strong>Enseignant :</strong> {{ $notification->data['enseignant'] }}</p>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Actions --}}
            <div class="d-flex gap-3 justify-content-center align-items-center">
                <a href="{{ route('notifications.index') }}" class="btn btn-outline-secondary btn-action">
                    <i class="bi bi-arrow-left me-2"></i>Retour aux notifications
                </a>
            </div>

        </div>
    </div>

</div>
@endsection