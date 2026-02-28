<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
// use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RetardCopieNotification extends Notification 
{
    use Queueable;

    protected $titre;
    protected $message;
    protected $type;
    protected $data;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $titre, string $message, string $type = 'general', array $data = [])
    {
        $this->titre = $titre;
        $this->message = $message;
        $this->type = $type;
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        // Sélectionner le bon template selon le type
        $view = $this->getEmailView();

        return (new MailMessage)
            ->subject($this->titre)
            ->view($view, [
                'titre' => $this->titre,
                'message' => $this->message,
                'data' => $this->data,
                'notifiable' => $notifiable
            ]);
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'titre' => $this->titre,
            'message' => $this->message,
            'type' => $this->type,
            'data' => $this->data,
            'created_at' => now()->toDateTimeString()
        ];
    }

    /**
     * Déterminer quel template email utiliser selon le type
     */
    protected function getEmailView(): string
    {
        return match($this->type) {
            'recuperation_rappel' => 'emails.recuperation-rappel',
            'avertissement_remise' => 'emails.avertissement-remise',
            'retard_remise_enseignant' => 'emails.retard-remise-enseignant',
            'retard_remise_da' => 'emails.retard-remise-da',
            default => 'emails.general',
        };
    }
}