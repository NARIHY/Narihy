<?php

namespace App\Listeners;

use App\Events\ContacteEvent;
use App\Models\Contacte;
use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ContacteListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ContacteEvent $contacteEvent): void
    {
        $donner = $contacteEvent->donner;
        $data = [
            'nom' => $donner['nom'],
            'prenon' => $donner['prenon'],
            'email' => $donner['email'],
            'sujet_conversation' => $donner['sujet_conversation'],
            'message' => $donner['message'],
        ];
        $contact = Contacte::create($data);
        $notification = Notification::create([
            'titre' => $data['prenon'].' ' . $data['prenon'] . 'souhaites vous contactez',
            'icons' => '<i class="bi bi-chat-quote-fill" style="color:green"></i>',
            'contenu' => $data['sujet_conversation']
        ]);
    }
}
