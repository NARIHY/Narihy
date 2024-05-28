<?php

namespace App\Http\Controllers\Public;

use App\Events\ContacteEvent;
use App\Events\InscriptionEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContacteRequest;
use App\Http\Requests\InscriptionUtilisateurRequest;
use App\Models\Portfolio;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * gérer tous les partie public de notre application
 * @author RANDRIANARISOA <maheninarandrianarisoa@gmail.com>
 * @copyright 2024 RANDRIANARISOA
 */
class SiteController extends Controller
{

    public function utilisateur_suprimer(): View
    {
        return view('supprimer.compte');
    }
    /**
     * Vue pour la création d'un compte chez moi
     *
     * @return \Illuminate\View\View
     */
    public function creation_compte(): View
    {
        return view($this->viewPath().'compte.random');
    }

    /**
     * Permet d'enregistrer un utilisateur dans la base de donnée
     *
     * @return RedirectResponse
     */
    public function sauvgarde_compte(InscriptionUtilisateurRequest $request): RedirectResponse
    {
        try {
            event(new InscriptionEvent($request->validated()));
            return redirect()->route('Public.Auth.se_connecter')->with('succes','Félicitation vous êtes inscrit avec succès!.');
        } catch (\Exception $e) {
            return redirect()->back()->with('erreur','Il y a eu une erreur lors de l\'inscription'.$e->getMessage());
        }
    }

    /**
     * Vue pour se connecter
     *
     * @return \Illuminate\View\View
     */
    public function se_connecter(): View
    {
        return view($this->viewPath().'compte.random');
    }
    /**
     * Partie accceuil de notre application
     *
     * @return \Illuminate\View\View
     */
    public function base(): View
    {
        $service = Service::orderBy('created_at', 'asc')
                                                ->where('status', '!=', '0')
                                                ->get();
        $portfolio = Portfolio::orderBy('created_at', 'desc')
                                                ->where('status', '!=', 0)
                                                ->where('suprimer', '!=', 1)
                                                ->limit(4)
                                                ->get();

        return view($this->viewPath().'acceuil.index', [
            'service' => $service,
            'portfolio' => $portfolio
        ]);
    }

    /**
     * Pour le propos de notre application
     *
     * @return \Illuminate\View\View
     */
    public function propos():View
    {
        return view($this->viewPath().'propos.index');
    }

    /**
     * Pour la partie service de notre application
     *
     * @return \Illuminate\View\View
     */
    public function service(): View
    {
        return view($this->viewPath().'service.index');
    }

    /**
     * Pour la partie portfolio
     *
     * @return \Illuminate\View\View
     */
    public function portfolio(): View
    {
        /** @var \App\Models\Portfolio $portfolio */
        $portfolio = Portfolio::where('status', true)
                                    ->where('suprimer', false)
                                    ->orderBy('created_at','desc')
                                    ->paginate(10);
        /** @var \App\Models\Portfolio $portfolio_count */
        $portfolio_count = Portfolio::where('status', true)
                                    ->where('suprimer', false)
                                    ->count();
        return view($this->viewPath().'portfolio.index', [
            'portfolio' => $portfolio,
            'portfolio_count' => $portfolio_count
        ]);
    }

    /**
     * Permet de voir un portfolio en particulier
     *
     * @param string $portfolioId
     * @return \Illuminate\View\View
     */
    public function voir_portfolio(string $portfolioId): View
    {
        /** @var \App\Models\Portfolio $portfolio instance de portfolio */
        $portfolio = Portfolio::findOrFail($portfolioId);
        return view($this->viewPath().'portfolio.voir', [
            'portfolio' => $portfolio
        ]);
    }
    /**
     * Pour la partie blog
     *
     * @return \Illuminate\View\View
     */
    public function blog(): View
    {
        return view($this->viewPath().'blog.index');
    }

    /**
     * Pour la partie contact
     *
     * @return \Illuminate\View\View
     */
    public function contact(): View
    {
        return view($this->viewPath().'contact.index');
    }

    /**
     * Permet de sauvgarder les contactes envoyez par les utilisateur
     * X
     *
     * @param ContacteRequest $request
     * @return RedirectResponse
     */
    public function nous_contacter(ContacteRequest $request): RedirectResponse
    {
        try {
            event(new ContacteEvent($request->validated()));
            return redirect()->back()->with('succes','Merçi de m\'avoir contactez.');
        } catch (\Exception $e) {
            return redirect()->back()->with('erreur','Il y a eu une erreur lors de l\'envoye de votre message. Veuillez rééseiller plus-tard.');
        }
    }
    public function actualite(): View
    {
        return view($this->viewPath().'actualite.index');
    }

    /**
     * REtourne le chemin de base de la vue
     *
     * @return string
     */
    private function viewPath(): string
    {
        return 'public.';
    }
}
