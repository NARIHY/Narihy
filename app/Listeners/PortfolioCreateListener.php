<?php

namespace App\Listeners;

use App\Events\PortfolioCreateEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;

class PortfolioCreateListener
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
    public function handle(PortfolioCreateEvent $event): void
    {
        /** @var \App\Models\Portfolio $portfolio Instance d'une blog */
        $portfolio = $event->portfolio;
        $chemin_fichier = $portfolio->media;

        if($chemin_fichier) {
            $nom_fichier_unique = uniqid() . '.'. pathinfo($chemin_fichier, PATHINFO_EXTENSION);
            $nomFichierFinale = date('Y-m-d');
            //Deplacer le fichier dans storage
            Storage::disk('public')->move($chemin_fichier, "public/portfolio_picture/$nomFichierFinale/$nom_fichier_unique");
            //Mettre a jour le chemin du fichier
            $portfolio->media = "public/portfolio_picture/$nomFichierFinale/$nom_fichier_unique";

            //Sauvgarder le fichier
            $portfolio->save();
        }
        $notification = \App\Models\Notification::create([
            'titre' => 'Un nouveau portfolio nommée '.$portfolio->titre . 'est récement créer',
            'icons' => '<i class="bi bi-star-fill" style="color:blue"></i>',
            'contenu' => $portfolio->description
        ]);
    }
}
