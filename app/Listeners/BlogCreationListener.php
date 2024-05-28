<?php

namespace App\Listeners;

use App\Models\Notification;
use App\Events\BlogCreationEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;

class BlogCreationListener
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
    public function handle(BlogCreationEvent $event): void
    {
        /** @var \App\Models\Blog $blog Instance d'une blog */
        $blog = $event->blog;
        $chemin_fichier = $blog->media;

        if($chemin_fichier) {
            $nom_fichier_unique = uniqid() . '.'. pathinfo($chemin_fichier, PATHINFO_EXTENSION);
            $nomFichierFinale = date('Y-m-d');
            //Deplacer le fichier dans storage
            Storage::disk('public')->move($chemin_fichier, "public/blogs_picture/$nomFichierFinale/$nom_fichier_unique");
            //Mettre a jour le chemin du fichier
            $blog->media = "public/blogs_picture/$nomFichierFinale/$nom_fichier_unique";

            //Sauvgarder le fichier
            $blog->save();
        }
        $notification = Notification::create([
            'titre' => 'Création d\'une nouvelle blog',
            'icons' => '<i class="bi bi-diagram-3-fill" style="color:blue"></i>',
            'contenu' => $blog->titre. ' '. 'Publier par: '. $blog->users->username
        ]);
    }
}
