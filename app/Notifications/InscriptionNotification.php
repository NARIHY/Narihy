<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InscriptionNotification extends Notification
{


    /**
     * Create a new notification instance.
     */
    public function __construct(public array $array)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Création de compte')
                    ->greeting('Bonjour!')
                    ->line('Félicitation, vous êtes inscrit chez nous avec succès, voici les informations concernant votre login.')
                    ->line('Nom: '. $this->array['nom'])
                    ->line('Prénon: '. $this->array['prenon'])
                    ->line('Nom d\'utilisateur: '. $this->array['username'])
                    ->line('Email: '. $this->array['email'])
                    ->line('Mots de passe: '. $this->array['password'])
                    ->line('')
                    ->line('Nb: ne vous inquiéter pas, tous les information incité ci-dessus sont crypter et seul est destiner à vous. Le mots de passe qu\'on a générer pour vous est sécurisé et hasher avec succès.')
                    ->line('Seul vous pouvez le voir en toutes sa forme')
                    ->line('Merci de nous avoir fait confiance')
                    ->salutation('A bientôt!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
