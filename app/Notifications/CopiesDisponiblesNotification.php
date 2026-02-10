<?php

namespace App\Notifications;

use App\Models\LotCopie;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;

class CopiesDisponiblesNotification extends Notification
{
    use Queueable;

    public LotCopie $lot;

    public function __construct(LotCopie $lot)
    {
        $this->lot = $lot;
    }

    /**
     * Canaux utilisés
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    /**
     * Notification stockée en base
     */
    public function toDatabase($notifiable)
    {
        $dateDisponible = Carbon::parse($this->lot->date_disponible);
        $dateLimite = $dateDisponible->copy()->addDay();

        return [
            'title' => "Copies disponibles pour {$this->lot->module->nom}",
            'message' => "Les copies du module {$this->lot->module->nom} sont disponibles depuis le {$dateDisponible->format('d/m/Y')}. Merci de passer à la scolarité au plus tard le {$dateLimite->format('d/m/Y')}.",
            'lot_id' => $this->lot->id,
            'module' => $this->lot->module->nom,
            'date_disponible' => $dateDisponible->format('Y-m-d'),
            'date_limite' => $dateLimite->format('Y-m-d'),
        ];
    }

    /**
     * Email envoyé
     */
    public function toMail($notifiable)
    {
        $dateDisponible = Carbon::parse($this->lot->date_disponible)->format('d/m/Y');
        $dateLimite = Carbon::parse($this->lot->date_disponible)->addDay()->format('d/m/Y');

        return (new MailMessage)
            ->title('Copies disponibles pour correction')
            ->message("Bonjour {$notifiable->prenom_utilisateur} ! Les copies de {$this->lot->module->nom} sont disponibles à partir du {$this->lot->date_disponible->format('d/m/Y')}..."),
            'lot_id' => $this->lot->id,
            'date_disponible' => $this->lot->date_disponible->format('Y-m-d'),
    }
