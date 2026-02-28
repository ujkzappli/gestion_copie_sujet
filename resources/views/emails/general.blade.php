@extends('emails.base')

@section('content')
    <p style="margin: 0 0 20px 0; color: #667eea; font-size: 18px; font-weight: 600;">
        Bonjour {{ $notifiable->prenom_utilisateur ?? '' }} {{ $notifiable->nom_utilisateur ?? '' }},
    </p>

    <p style="margin: 20px 0; color: #495057; font-size: 15px; line-height: 1.6;">
        {{ $message }}
    </p>

    <hr style="border: none; border-top: 1px solid #dee2e6; margin: 30px 0;">

    <p style="margin: 0; color: #6c757d; font-size: 13px; font-style: italic;">
        Pour toute question, veuillez contacter l'administration.
    </p>
@endsection