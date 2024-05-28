<?php

namespace App\Listeners;

use App\Events\InscriptionEvent;
use App\Models\User;
use App\Notifications\InscriptionNotification;
use Core\Text\RandomText;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Hash;

class InscriptionListener
{
    private $mailer;
    /**
     * Create the event listener.
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Handle the event.
     * Tous ce qui est logique dans notre application
     */
    public function handle(InscriptionEvent $event): void
    {
        $text = new RandomText();
        $donner = $event->data;
        $mots_de_passe = $text->generate();
        //Pour la notification
        $user_nonHashed = [
            'nom' => $donner['nom'],
            'prenon' => $donner['prenon'],
            'email' => $donner['email'],
            'username' => $donner['username'],
            'password' => $mots_de_passe
        ];
        //erreur est ici

        $utilisateur = User::create([
            'nom' => $donner['nom'],
            'prenon' => $donner['prenon'],
            'email' => $donner['email'],
            'username' => $donner['username'],
            'password' => Hash::make($mots_de_passe),
            'role_id' => 1,
        ]);
        $utilisateur->notify(new InscriptionNotification($user_nonHashed));
        // $this->mailer->send();
        $notification = \App\Models\Notification::create([
            'titre' => $donner['prenon']. ' '. $donner['nom'] .'vient de s\'inscrire dans notre application.',
            'icons' => '<i class="bi bi-person-plus-fill" style="color:black"></i>',
            'contenu' => 'Une personne s\'est inscrit dans notre application.'
        ]);
    }
}
