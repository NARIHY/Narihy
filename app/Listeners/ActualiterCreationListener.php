<?php

namespace App\Listeners;

use App\Events\ActualiterCreationEvent;
use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;
class ActualiterCreationListener
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
    public function handle(ActualiterCreationEvent $event): void
    {
        $actualite = $event->getActuaite();
        $chemin_fichier = $actualite->media;

        if($chemin_fichier) {
            $nom_fichier_unique = uniqid() . '.'. pathinfo($chemin_fichier, PATHINFO_EXTENSION);
            $nomFichierFinale = date('Y-m-d');
            //Deplacer le fichier dans storage
            Storage::disk('public')->move($chemin_fichier, "public/actualite_picture/$nomFichierFinale/$nom_fichier_unique");
            //Mettre a jour le chemin du fichier
            $actualite->media = "public/actualite_picture/$nomFichierFinale/$nom_fichier_unique";
            //Sauvgarder le fichier
            $actualite->save();
        }
        //Emettre une notification
        $notification = Notification::create([
            'titre' => 'Création d\'une nouvelle actualité',
            'icons' => '<i class="bi bi-pin-angle-fill" style="color:orange"></i>',
            'contenu' => $actualite->titre. ' '. $actualite->description
        ]);
    }
}
