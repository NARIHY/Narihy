<?php

namespace App\Notifications;

use App\Models\Publicite;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PubliciteNotification extends Notification
{
   // use Queueable;

    /** @var \App\Models\Publicite $publicite instance de la publiciter */
    private Publicite $publicite;

    /**
     * Create a new notification instance.
     */
    public function __construct(Publicite $publicite)
    {
        $this->publicite = $publicite;
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
                    ->subject($this->publicite->titre)
                    ->greeting('Bonjour!')
                    ->line($this->publicite->description_pub)
                    ->line($this->publicite->contenu_pub)
                    ->line('Merci de nous faire confiance, A la prochaine!!');
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
