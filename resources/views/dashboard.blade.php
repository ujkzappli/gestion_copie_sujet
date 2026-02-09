{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard')

@section('sidebar')
    @include('partials.sidebar') {{-- On inclura le sidebar ici --}}
@endsection

@section('content')
    @php
        $user = auth()->user();
    @endphp

    @if($user->isAdmin())
        @include('dashboards.admin')
    @elseif($user->isPresident())
        @include('dashboards.president')
    @elseif($user->isEnseignant())
        @include('dashboards.enseignant')
    @elseif($user->isCD())
        @include('dashboards.cd')
    @elseif($user->isCS())
        @include('dashboards.cs')
    @elseif($user->isDA())
        @include('dashboards.da')
    @else
        <p>Rôle non reconnu.</p>
    @endif
@endsection
