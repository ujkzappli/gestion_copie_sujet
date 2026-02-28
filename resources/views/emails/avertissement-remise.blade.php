@extends('emails.base')

@section('content')
    <p style="margin: 0 0 20px 0; color: #667eea; font-size: 18px; font-weight: 600;">
        Bonjour {{ $notifiable->prenom_utilisateur }} {{ $notifiable->nom_utilisateur }},
    </p>

    <table role="presentation" style="width: 100%; border-left: 4px solid #ffc107; background-color: #fff3cd; margin: 20px 0;">
        <tr>
            <td style="padding: 20px;">
                <p style="margin: 0 0 10px 0; color: #856404; font-size: 16px; font-weight: 600;">
                    ⚠️ Avertissement - Délai de remise approchant
                </p>
                <p style="margin: 0; color: #856404; font-size: 15px; line-height: 1.6;">
                    Attention ! Vous pourriez être en retard pour la remise des copies du module 
                    <strong>{{ $data['module'] }}</strong>.
                </p>
            </td>
        </tr>
    </table>

    <table role="presentation" style="width: 100%; background-color: #fff5f5; border-radius: 8px; margin: 25px 0;">
        <tr>
            <td style="padding: 30px; text-align: center;">
                <p style="margin: 0 0 10px 0; color: #dc3545; font-size: 18px; font-weight: 600;">
                    ⏰ Il vous reste
                </p>
                <p style="margin: 0; color: #dc3545; font-size: 36px; font-weight: 700;">
                    {{ $data['jours_restants'] }} jours
                </p>
            </td>
        </tr>
    </table>

    <p style="margin: 20px 0; color: #495057; font-size: 15px; line-height: 1.6;">
        <strong>Date limite de remise :</strong> 
        <span style="color: #dc3545; font-weight: 600;">{{ $data['date_remise_max'] }}</span>
    </p>

    <p style="margin: 20px 0; color: #495057; font-size: 15px; line-height: 1.6;">
        Veuillez renvoyer les copies corrigées avant cette date pour éviter tout retard.
    </p>

    <table role="presentation" style="width: 100%; border-left: 4px solid #667eea; background-color: #f8f9fa; margin: 25px 0;">
        <tr>
            <td style="padding: 20px;">
                <p style="margin: 0 0 15px 0; color: #667eea; font-size: 16px; font-weight: 600;">
                    📝 Actions recommandées
                </p>
                <ul style="margin: 0; padding-left: 20px; color: #495057; font-size: 14px; line-height: 1.8;">
                    <li>Terminez la correction des copies rapidement</li>
                    <li>Préparez les notes pour la remise</li>
                    <li>Contactez la scolarité en cas de difficulté</li>
                </ul>
            </td>
        </tr>
    </table>

    <hr style="border: none; border-top: 1px solid #dee2e6; margin: 30px 0;">

    <p style="margin: 0; color: #6c757d; font-size: 13px; font-style: italic;">
        En cas de problème, contactez votre chef de département ou le directeur académique.
    </p>
@endsection