<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PubliciteRequest;
use App\Models\Publicite;
use App\Models\User;
use App\Notifications\PubliciteNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Permet de gérer tous ce qui concernent les publicités de mon application
 * @author RANDRIANARISOA <maheninarandrianarisoa@gmail.com>
 * @copyright 2024 RANDRIANARISOA
 */
class PubliciteController extends Controller
{

    /**
     * Permet de notifier tous les utilisateurs de l'application
     *
     * @param string $publiciteId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function send_publicite(string $publiciteId): RedirectResponse
    {
        /** @var \App\Models\Publicite $publicite  Récupérer la publiciter */
        $publicite = Publicite::findOrFail($publiciteId);
        /** @var User $utilisateur Récupérer les utilisateur à notifier */
        $utilisateur = User::get();
        try {
            //Verifier si la publicité est déjas envoyer ou pas
            if($publicite->status === 1) {
                return redirect()->back()->with('warning','La publicité a déjàs été notifier aux utilisateur');
            }
            //Notifier les utilsiateur
            foreach($utilisateur as $user) {
                $user->notify(new PubliciteNotification($publicite));
            }
            $publicite->update([
                'status' => true
            ]);
            return redirect()->back()->with('succes','Tous nos utilisateur ont été notifié de cette publicité!!');
        } catch(\Exception $e) {
            return redirect()->back()->with('erreur','Il y a eu une erreur lors de l\'envoye du publicités.');
        }
    }
    /**
     * Met en corbeil une publiciter
     *
     * @param string $publiciteId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function suppression_simple_pub(string $publiciteId): RedirectResponse
    {
         /** @var \App\Models\Publicite $publicites instances d'une publicites à suprimer */
         $publicite = Publicite::findOrfail($publiciteId);
        try {
            if($publicite->suprimer === 1) {
                return redirect()->route('Administration.Exception.not_found');
            }
            $publicite->update([
                'suprimer' => true
            ]);
            return redirect()->back()->with('succes','Supression réussi');
        } catch(\Exception $e) {
            return redirect()->back()->with('erreur','Echec lors de la supression');
        }
    }
    /**
     * Permet de sauvgarder une modification fait dans une publiciter
     *
     * @param string $publiciteId
     * @param  \App\Http\Requests\PubliciteRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sauvgarde_modif_pub(string $publiciteId, PubliciteRequest $request): RedirectResponse
    {
        /** @var \App\Models\Publicite $publicites instances d'une publicites à modifier */
        $publicite = Publicite::findOrfail($publiciteId);
        try {
            $publicite->update($request->validated());
            return redirect()->back()->with('succes','Modification réussi!!!');
        } catch(\Exception $e) {
            return redirect()->back()->with('erreur','Il y a eu une erreur lors de la création de la publicité!!');
        }
    }
    /**
     * Permet de modifier une publiciter en particulier avant de le publier
     *
     * @param string $publiciteId
     * @return \Illuminate\View\View;
     */
    public function modifier_une_pub(string $publiciteId): View
    {
        /** @var \App\Models\Publicite $publicites instances d'une publicites */
        $publicite = Publicite::findOrfail($publiciteId);
        if($publicite->suprimer === 1) {
            return redirect()->route('Administration.Exception.not_found');
        }
        return view($this->viewPath().'action.random', [
            'publicite' => $publicite
        ]);
    }

    /**
     * Permet de sauvgarder une nouvelle publiciter dans la base de donnée
     *
     * @param \App\Http\Requests\PubliciteRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sauvgarder_une_publiciter(PubliciteRequest $request): RedirectResponse
    {
        try {
            /** @var \App\Models\Publicite $nouveau_pub création d'une nouvelle publiciter */
            $nouveau_pub = Publicite::create($request->validated());
            return redirect()->route('Administration.Publiciter.liste_publicite')->with('succes','La publicités a été créer avec succès!!');
        } catch(\Exception $e) {
            return redirect()->back()->with('erreur','Il y a eu une erreur lors de la création de la publicité!!');
        }
    }
    /**
     * Permet de creer une publiciter
     *
     * @return \Illuminate\View\View;
     */
    public function creer_une_publiciter():View
    {
        return view($this->viewPath().'action.random');
    }


    /**
     * Lister tous les publiciter
     *
     * @return \Illuminate\View\View;
     */
    public function liste_publicite(): View
    {
        /** @var \App\Models\Publicite $publicites instances des publicites */
        $publicites = Publicite::orderBy('created_at','desc')
                                            ->where('suprimer', '==', false)
                                            ->paginate(15);
        return view($this->viewPath().'index', [
            'publicites' => $publicites
        ]);
    }
    /**
     * Chemin de base des vue de mon publicité
     *
     * @return string
     */
    private function viewPath(): string
    {
        return "admin.publicite.";
    }
}
