@extends('emails.base')

@section('content')
    <p style="margin: 0 0 20px 0; color: #667eea; font-size: 18px; font-weight: 600;">
        Bonjour {{ $notifiable->prenom_utilisateur }} {{ $notifiable->nom_utilisateur }},
    </p>

    <table role="presentation" style="width: 100%; border-left: 4px solid #dc3545; background-color: #f8d7da; margin: 20px 0;">
        <tr>
            <td style="padding: 20px;">
                <p style="margin: 0 0 10px 0; color: #721c24; font-size: 16px; font-weight: 600;">
                    🚨 URGENT - Retard de remise des copies
                </p>
                <p style="margin: 0; color: #721c24; font-size: 15px; line-height: 1.6;">
                    Vous êtes actuellement en retard pour la remise des copies du module 
                    <strong>{{ $data['module'] }}</strong>.
                </p>
            </td>
        </tr>
    </table>

    <table role="presentation" style="width: 100%; background-color: #fff5f5; border-radius: 8px; margin: 25px 0;">
        <tr>
            <td style="padding: 30px; text-align: center;">
                <p style="margin: 0 0 10px 0; color: #dc3545; font-size: 18px; font-weight: 600;">
                    ⏱️ Retard de
                </p>
                <p style="margin: 0; color: #dc3545; font-size: 40px; font-weight: 700;">
                    {{ $data['jours_retard'] }} jour(s)
                </p>
            </td>
        </tr>
    </table>

    <p style="margin: 20px 0; color: #495057; font-size: 15px; line-height: 1.6;">
        <strong>Date limite dépassée :</strong> 
        <span style="color: #dc3545; font-weight: 600;">{{ $data['date_limite'] }}</span>
    </p>

    <p style="margin: 20px 0; color: #495057; font-size: 15px; line-height: 1.8;">
        Ce retard peut avoir des conséquences sur le calendrier académique et la publication des résultats 
        des étudiants. Il est impératif de régulariser cette situation dans les plus brefs délais.
    </p>

    <table role="presentation" style="width: 100%; border-left: 4px solid #ffc107; background-color: #fff3cd; margin: 25px 0;">
        <tr>
            <td style="padding: 20px;">
                <p style="margin: 0 0 15px 0; color: #856404; font-size: 16px; font-weight: 600;">
                    ⚡ Actions urgentes requises
                </p>
                <ul style="margin: 0; padding-left: 20px; color: #856404; font-size: 14px; line-height: 1.8;">
                    <li>Contactez <strong>immédiatement</strong> votre chef de département</li>
                    <li>Ou contactez le directeur académique</li>
                    <li>Remettez les copies corrigées ou envoyez la version scannée</li>
                    <li>Justifiez votre retard si nécessaire</li>
                </ul>
            </td>
        </tr>
    </table>

    <hr style="border: none; border-top: 1px solid #dee2e6; margin: 30px 0;">

    <p style="margin: 0; color: #6c757d; font-size: 13px; font-style: italic;">
        Une notification a également été envoyée au directeur académique concernant cette situation.
    </p>
@endsection