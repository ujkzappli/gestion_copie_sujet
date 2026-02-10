<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class RetardCopieNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $title,
        public string $message
    ) {}

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->title)
            ->greeting('Bonjour ' . $notifiable->prenom_utilisateur)
            ->line($this->message)
            ->salutation('Cordialement, la scolarité');
    }
}
