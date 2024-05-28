<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SocialLinkRequest;
use App\Models\Actualite;
use App\Models\Blog;
use App\Models\Contacte;
use App\Models\Portfolio;
use App\Models\Publicite;
use App\Models\Service;
use App\Models\SocialLink;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Pour gérer les tous les parties administration
 * @author RANDRIANARISOA <maheninarandrianarisoa@gmail.com>
 * @copyright 2024 RANDRIANARISOA
 */
class SiteController extends Controller
{
    /**
     * Not found page
     *
     * @return View
     */
    public function not_found(): View
    {
        return view('admin.not_found.404');
    }
    /**
     * Tableau de bord
     *
     * @return \Illuminate\View\view
     */
    public function tableau_de_bord(): View
    {
        /** @var \App\Models\Actualite $actualite_count Compter l'actu totale */
        $actualite_count = Actualite::where('suprimer','==', false)
                                            ->count();
        /** @var \App\Models\Actualite $actualite_count Compter l'actu totale publier */
        $actualite_count_publier = Actualite::where('status', true)
                                                ->where('suprimer','==', false)
                                                ->count();
        //blog
        /** @var \App\Models\Blog $blog_count tous les blogs */
        $blog = Blog::orderBy('created_at', 'desc')
                        ->limit(8)
                        ->get();
        /** @var \App\Models\Blog $blog_count tous les blogs */
        $blog_count = Blog::where('suprimer','==', false)
                                ->count();
        /** @var \App\Models\Blog $blog_count_publier tous les blogs publier */
        $blog_count_publier = Blog::where('status', true)
                                ->where('suprimer','==', false)
                                ->count();

        //Contacte
        /** @var \App\Models\Contacte $contact_count Contacte totale */
        $contact_count = Contacte::count();
         /** @var \App\Models\Contacte $contact_count_repondu Contacte totale */
        $contact_count_repondu = Contacte::where('reponse', true)
                                            ->count();

        //Portfolio
        /** @var \App\Models\Portfolio $portfolio_count nbr totale des portfolio */
        $portfolio_count = Portfolio::where('suprimer', '==', false)
                                        ->count();
        /** @var \App\Models\Portfolio $portfolio_count_publier nbr totale des portfolio */
        $portfolio_count_publier = Portfolio::where('suprimer', '==', false)
                                                ->where('status',true)
                                                ->count();

        //Publiciter
        $publiciter_count = Publicite::where('suprimer', '==', false)
                                        ->count();
        $publiciter_count_envoyer = Publicite::where('suprimer', '==', false)
                                        ->where('status',true)
                                        ->count();
        //Service
        $service_count = Service::count();
        $service_count_publier = Service::where('status', true)
                                            ->count();
        return view($this->viewPath().'base', [
            'actualite_count' => $actualite_count,
            'actualite_count_publier' => $actualite_count_publier,
            'blog_count' => $blog_count,
            'blogs' => $blog,
            'blog_count_publier' => $blog_count_publier,
            'contact_count' => $contact_count,
            'contact_count_repondu' => $contact_count_repondu,
            'portfolio_count' => $portfolio_count,
            'portfolio_count_publier' => $portfolio_count_publier,
            'publiciter_count' => $publiciter_count,
            'publiciter_count_envoyer' =>$publiciter_count_envoyer,
            'service_count' => $service_count,
            'service_count_publier' => $service_count_publier
        ]);
    }

//
    /**
     * liste des Lien sociale
     *
     * @return \Illuminate\View\view
     */
    public function social_link(): View
    {
        $social = SocialLink::orderBy('created_at','asc')
                                ->paginate(10);
        return view($this->viewPath().'social.index', [
            'social' => $social
        ]);
    }

    /**
     * Permet de sauvgarder le lien sociale
     *
     * @param SocialLinkRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sauvgarder_lien_sociale(SocialLinkRequest $request): RedirectResponse
    {
        try {
            $socialLink = SocialLink::create($request->validated());
            return redirect()->route('Administration.SocialLinks.social_link')->with('succes','Ajout du lien réussi.');
        } catch (\Exception $e) {
            return redirect()->back()->with('erreur','Il y a eu une erreur lors de l\'ajout.');
        }
    }

    /**
     * Edition d'un lien sociale
     *
     * @param string $id identification du lien sociale
     * @return \Illuminate\View\View
     */
    public function edition_social_link(string $id): View
    {
        /** @var SocialLink $social Le sociale */
        $social = SocialLink::findOrFail($id);
        return view($this->viewPath().'social.action.random', [
            'social' => $social
        ]);
    }

    /**
     * Permet de sauvgarder les modification d'une  lien sociale
     *
     * @param string $id
     * @param SocialLinkRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function maj_lien_sociale(string $id,SocialLinkRequest $request): RedirectResponse
    {
        /** @var SocialLink $social Le sociale */
        $social = SocialLink::findOrFail($id);
        try {
            $social->update($request->validated());
            return redirect()->back()->with('succes','Ajout du lien réussi.');
        } catch (\Exception $e) {
            return redirect()->back()->with('erreur','Il y a eu une erreur lors de l\'ajout.');
        }
    }

    /**
     * Suprimer un lien sociale
     *
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function suprimer_lien_sociale(string $id): RedirectResponse
    {
        /** @var SocialLink $social Le sociale */
        $social = SocialLink::findOrFail($id);
        try {
            $social->delete();
            return redirect()->back()->with('succes','Suppression du lien réussi.');
        } catch(\Exception $e) {
            return redirect()->back()->with('erreur','Il y a eu une erreur lors de la supréssion.');
        }
    }
    /**
     *  Ajouter une nouvelle lien sociale
     *
     * @return \Illuminate\View\view
     */
    public function creer_lien_social():View
    {
        return view($this->viewPath().'social.action.random');
    }
//

    /**
     * Retourne le chemin de base de nos vues
     *
     * @return string
     */
    private function viewPath(): string
    {
        return "admin.";
    }
}
