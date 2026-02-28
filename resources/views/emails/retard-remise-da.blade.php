@extends('emails.base')

@section('content')
    <p style="margin: 0 0 20px 0; color: #667eea; font-size: 18px; font-weight: 600;">
        Bonjour {{ $notifiable->prenom_utilisateur }} {{ $notifiable->nom_utilisateur }},
    </p>

    <table role="presentation" style="width: 100%; border-left: 4px solid #dc3545; background-color: #f8d7da; margin: 20px 0;">
        <tr>
            <td style="padding: 20px;">
                <p style="margin: 0 0 10px 0; color: #721c24; font-size: 16px; font-weight: 600;">
                    🚨 ALERTE - Enseignant en retard de remise
                </p>
                <p style="margin: 0; color: #721c24; font-size: 15px; line-height: 1.6;">
                    Un enseignant de votre établissement est en retard pour la remise des copies.
                </p>
            </td>
        </tr>
    </table>

    <table role="presentation" style="width: 100%; background-color: #f8f9fa; border-radius: 8px; margin: 25px 0;">
        <tr>
            <td style="padding: 25px;">
                <p style="margin: 0 0 20px 0; color: #667eea; font-size: 16px; font-weight: 600;">
                    📊 Informations sur le retard
                </p>
                
                <table role="presentation" style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 12px 0; border-bottom: 1px solid #dee2e6; color: #495057; font-size: 14px;">
                            <strong>Enseignant :</strong>
                        </td>
                        <td style="padding: 12px 0; border-bottom: 1px solid #dee2e6; color: #212529; font-size: 14px;">
                            {{ $data['enseignant_nom'] }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 12px 0; border-bottom: 1px solid #dee2e6; color: #495057; font-size: 14px;">
                            <strong>Email :</strong>
                        </td>
                        <td style="padding: 12px 0; border-bottom: 1px solid #dee2e6;">
                            <a href="mailto:{{ $data['enseignant_email'] }}" style="color: #667eea; text-decoration: none; font-size: 14px;">
                                {{ $data['enseignant_email'] }}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 12px 0; border-bottom: 1px solid #dee2e6; color: #495057; font-size: 14px;">
                            <strong>WhatsApp :</strong>
                        </td>
                        <td style="padding: 12px 0; border-bottom: 1px solid #dee2e6;">
                            <a href="https://wa.me/{{ $data['enseignant_phone'] }}" style="color: #25D366; text-decoration: none; font-size: 14px;">
                                {{ $data['enseignant_phone'] }}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 12px 0; border-bottom: 1px solid #dee2e6; color: #495057; font-size: 14px;">
                            <strong>Module :</strong>
                        </td>
                        <td style="padding: 12px 0; border-bottom: 1px solid #dee2e6; color: #212529; font-size: 14px;">
                            {{ $data['module'] }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 12px 0; border-bottom: 1px solid #dee2e6; color: #495057; font-size: 14px;">
                            <strong>Date limite :</strong>
                        </td>
                        <td style="padding: 12px 0; border-bottom: 1px solid #dee2e6; color: #dc3545; font-size: 14px; font-weight: 600;">
                            {{ $data['date_limite'] }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 12px 0; color: #495057; font-size: 14px;">
                            <strong>Jours de retard :</strong>
                        </td>
                        <td style="padding: 12px 0; color: #dc3545; font-size: 18px; font-weight: 700;">
                            {{ $data['jours_retard'] }} jour(s)
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table role="presentation" style="width: 100%; border-left: 4px solid #ffc107; background-color: #fff3cd; margin: 25px 0;">
        <tr>
            <td style="padding: 20px;">
                <p style="margin: 0 0 15px 0; color: #856404; font-size: 16px; font-weight: 600;">
                    📞 Actions recommandées
                </p>
                <ul style="margin: 0; padding-left: 20px; color: #856404; font-size: 14px; line-height: 1.8;">
                    <li>Contactez l'enseignant par téléphone ou WhatsApp</li>
                    <li>Vérifiez la raison du retard</li>
                    <li>Établissez un nouveau délai si nécessaire</li>
                    <li>Prenez les mesures appropriées selon le règlement</li>
                </ul>
            </td>
        </tr>
    </table>

    <table role="presentation" style="width: 100%; margin: 30px 0;">
        <tr>
            <td align="center">
                <a href="https://wa.me/{{ $data['enseignant_phone'] }}" style="display: inline-block; padding: 15px 40px; background-color: #25D366; color: #ffffff; text-decoration: none; border-radius: 5px; font-size: 16px; font-weight: 600;">
                    💬 Contacter via WhatsApp
                </a>
            </td>
        </tr>
    </table>

    <hr style="border: none; border-top: 1px solid #dee2e6; margin: 30px 0;">

    <p style="margin: 0; color: #6c757d; font-size: 13px; font-style: italic;">
        Cette alerte a été générée automatiquement par le système de gestion des copies.
    </p>
@endsection