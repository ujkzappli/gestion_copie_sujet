@extends('emails.base')

@section('content')
    <p style="margin: 0 0 20px 0; color: #667eea; font-size: 18px; font-weight: 600;">
        Bonjour {{ $notifiable->prenom_utilisateur }} {{ $notifiable->nom_utilisateur }},
    </p>

    <table role="presentation" style="width: 100%; border-left: 4px solid #667eea; background-color: #f8f9fa; margin: 20px 0;">
        <tr>
            <td style="padding: 20px;">
                <p style="margin: 0 0 10px 0; color: #667eea; font-size: 16px; font-weight: 600;">
                    📋 Rappel Important
                </p>
                <p style="margin: 0; color: #495057; font-size: 15px; line-height: 1.6;">
                    Les copies du module <strong>{{ $data['module'] }}</strong> sont disponibles à la scolarité 
                    depuis <strong>{{ $data['jours_ecoules'] }} jours</strong> (depuis le {{ $data['date_disponible'] }}).
                </p>
            </td>
        </tr>
    </table>

    <p style="margin: 20px 0; color: #495057; font-size: 15px; line-height: 1.6;">
        Nous vous rappelons qu'il est important de récupérer ces copies au plus vite afin de procéder à leur correction.
    </p>

    <p style="margin: 20px 0; color: #495057; font-size: 15px; line-height: 1.6;">
        <strong style="color: #dc3545;">⏰ Date limite de remise :</strong> 
        <span style="color: #dc3545; font-weight: 600;">{{ $data['date_remise_max'] }}</span>
    </p>

    <table role="presentation" style="width: 100%; border-left: 4px solid #ffc107; background-color: #fff3cd; margin: 25px 0;">
        <tr>
            <td style="padding: 20px;">
                <p style="margin: 0 0 10px 0; color: #856404; font-size: 16px; font-weight: 600;">
                    ⚠️ Action requise
                </p>
                <p style="margin: 0; color: #856404; font-size: 15px; line-height: 1.6;">
                    Veuillez passer à la scolarité pour récupérer vos copies et les corriger dans les meilleurs délais.
                </p>
            </td>
        </tr>
    </table>

    <hr style="border: none; border-top: 1px solid #dee2e6; margin: 30px 0;">

    <p style="margin: 0; color: #6c757d; font-size: 13px; font-style: italic;">
        Pour toute question, n'hésitez pas à contacter votre chef de département.
    </p>
@endsection