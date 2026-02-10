@extends('layouts.app')

@section('title', 'Mes notifications')

@section('content')
<div class="container">
    <h4>Notifications</h4>
    <ul class="list-group">
        @forelse($notifications as $notif)
            <li class="list-group-item @if(!$notif->read_at) fw-bold @endif">
                <a href="{{ route('notifications.show', $notif->id) }}">
                    {!! $notif->data['message'] !!}
                </a>
                <small class="text-muted float-end">{{ $notif->created_at->format('d/m/Y H:i') }}</small>
            </li>
        @empty
            <li class="list-group-item">Aucune notification</li>
        @endforelse
    </ul>

    <div class="mt-3">
        {{ $notifications->links() }}
    </div>
</div>
@endsection
