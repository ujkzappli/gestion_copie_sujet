@extends('layouts.app')

@section('title', 'Mes notifications')

@push('styles')
<style>
.card-modern {
    border: none;
    border-radius: 15px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
}
.card-modern:hover {
    box-shadow: 0 4px 20px rgba(0,0,0,0.12);
}
.stats-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    border-left: 4px solid;
    transition: all 0.3s ease;
}
.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.1);
}
.notification-item {
    background: white;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 12px;
    transition: all 0.3s ease;
    border-left: 4px solid #e9ecef;
    position: relative;
}
.notification-item:hover {
    transform: translateX(5px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
.notification-item.unread {
    background: rgba(102, 126, 234, 0.05);
    border-left-color: #667eea;
}
.notification-item.unread::before {
    content: '';
    position: absolute;
    left: -8px;
    top: 50%;
    transform: translateY(-50%);
    width: 12px;
    height: 12px;
    background: #667eea;
    border-radius: 50%;
    border: 2px solid white;
}
.notification-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
}
.notification-icon.info {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
.notification-icon.success {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
}
.notification-icon.warning {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}
.notification-icon.danger {
    background: linear-gradient(135deg, #eb3349 0%, #f45c43 100%);
}
.empty-state {
    padding: 60px 20px;
    text-align: center;
}
.empty-state i {
    font-size: 4rem;
    color: #dee2e6;
    margin-bottom: 20px;
}
</style>
@endpush

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h2 class="mb-1 fw-bold text-primary">
                        <i class="bi bi-bell-fill me-2"></i>Mes notifications
                    </h2>
                    <p class="text-muted mb-0">Consultez toutes vos notifications</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistiques --}}
    <div class="row g-3 mb-4">
        @php
            $totalNotifications = $notifications->total();
            $nonLues = $notifications->where('read_at', null)->count();
            $lues = $notifications->where('read_at', '!=', null)->count();
            $aujourdhui = $notifications->filter(function($n) {
                return $n->created_at->isToday();
            })->count();
        @endphp

        <div class="col-xl-3 col-md-6">
            <div class="stats-card" style="border-color: #667eea;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small fw-semibold">TOTAL</p>
                        <h3 class="mb-0 fw-bold text-primary">{{ $totalNotifications }}</h3>
                    </div>
                    <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                        <i class="bi bi-bell-fill text-primary fs-2"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stats-card" style="border-color: #ffc107;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small fw-semibold">NON LUES</p>
                        <h3 class="mb-0 fw-bold" style="color: #ffc107;">{{ $nonLues }}</h3>
                    </div>
                    <div class="rounded-circle p-3" style="background: rgba(255, 193, 7, 0.1);">
                        <i class="bi bi-envelope-fill fs-2" style="color: #ffc107;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stats-card" style="border-color: #28a745;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small fw-semibold">LUES</p>
                        <h3 class="mb-0 fw-bold text-success">{{ $lues }}</h3>
                    </div>
                    <div class="bg-success bg-opacity-10 rounded-circle p-3">
                        <i class="bi bi-envelope-check-fill text-success fs-2"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stats-card" style="border-color: #17a2b8;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small fw-semibold">AUJOURD'HUI</p>
                        <h3 class="mb-0 fw-bold text-info">{{ $aujourdhui }}</h3>
                    </div>
                    <div class="bg-info bg-opacity-10 rounded-circle p-3">
                        <i class="bi bi-calendar-check-fill text-info fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Liste des notifications --}}
    <div class="row">
        <div class="col-12">
            @forelse($notifications as $notif)
                @php
                    // Déterminer le type d'icône selon le type de notification
                    $iconType = 'info';
                    $icon = 'bi-bell-fill';
                    
                    if(isset($notif->data['type'])) {
                        switch($notif->data['type']) {
                            case 'success':
                                $iconType = 'success';
                                $icon = 'bi-check-circle-fill';
                                break;
                            case 'warning':
                                $iconType = 'warning';
                                $icon = 'bi-exclamation-triangle-fill';
                                break;
                            case 'danger':
                                $iconType = 'danger';
                                $icon = 'bi-x-circle-fill';
                                break;
                            default:
                                $iconType = 'info';
                                $icon = 'bi-info-circle-fill';
                        }
                    }
                @endphp

                <a href="{{ route('notifications.show', $notif->id) }}" class="text-decoration-none">
                    <div class="notification-item {{ $notif->read_at ? '' : 'unread' }}">
                        <div class="d-flex align-items-start gap-3">
                            <div class="notification-icon {{ $iconType }}">
                                <i class="bi {{ $icon }}"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="mb-0 fw-bold {{ $notif->read_at ? 'text-muted' : 'text-dark' }}">
                                        {{ $notif->data['title'] ?? $notif->data['titre'] ?? 'Notification' }}
                                    </h6>
                                    <small class="text-muted">
                                        <i class="bi bi-clock me-1"></i>
                                        {{ $notif->created_at->diffForHumans() }}
                                    </small>
                                </div>
                                <p class="mb-0 {{ $notif->read_at ? 'text-muted' : 'text-secondary' }}">
                                    {!! Str::limit(strip_tags($notif->data['message']), 150) !!}
                                </p>
                                @if(!$notif->read_at)
                                    <span class="badge bg-primary mt-2">
                                        <i class="bi bi-star-fill me-1"></i>Nouveau
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="card-modern">
                    <div class="card-body">
                        <div class="empty-state">
                            <i class="bi bi-bell-slash"></i>
                            <h5 class="text-muted mb-2">Aucune notification</h5>
                            <p class="text-muted">Vous n'avez aucune notification pour le moment</p>
                        </div>
                    </div>
                </div>
            @endforelse

            {{-- Pagination --}}
            @if($notifications->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>
    </div>

</div>
@endsection