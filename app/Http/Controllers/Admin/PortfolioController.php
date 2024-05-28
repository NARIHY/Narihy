<?php

namespace App\Http\Controllers\Admin;

use App\Events\PortfolioCreateEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoriPortfolioRequest;
use App\Http\Requests\PortfolioRequest;
use App\Http\Requests\PortfolioUpdateRequest;
use App\Models\CategoryPortfolio;
use App\Models\Portfolio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Permet de gérer les portfolio
 * dans mon site
 * @author RANDRIANARISOA <maheninarandrianarisoa@gmail.com>
 * @copyright 2024 RANDRIANARISOA
 */
class PortfolioController extends Controller
{

    /**
     * Permet de changer le status du portofolio en actif ou en inanctif
     *
     * @param string $portfolioId
     * @return  \Illuminate\Http\RedirectResponse
     */
    public function changer_status(string $portfolioId): RedirectResponse
    {
        /** @var \App\Models\Portfolio $portfolio instance des portfolio */
        $portfolio = Portfolio::findOrFail($portfolioId);
        try {
            if($portfolio->status === 1) {
                $portfolio->update([
                    'status' => false
                ]);
            } else {
                $portfolio->update([
                    'status' => true
                ]);
            }
            return redirect()->back()->with('succes','Status modifier avec succès!!');
        } catch(\Exception $e) {
            return redirect()->back()->with('erreur','Il y a eu une erreur lors du changement du status.');
        }
    }

    /**
     * Permet de mettre en corbeil un portfolio
     *
     * @param string $portfolioId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function suprimer_portfolio(string $portfolioId): RedirectResponse
    {
        /** @var \App\Models\Portfolio $portfolio instance des portfolio */
        $portfolio = Portfolio::findOrFail($portfolioId);
        try {
            if($portfolio->suprimer === 1) {
                return redirect()->route('Administration.Exception.not_found');
            }
            $portfolio->update([
                'suprimer' => true
            ]);
            return redirect()->back()->with('succes','Supression réussi!!');
        } catch (\Exception $e) {
            return redirect()->back()->with('erreur','Il y a eu une erreur lors de la supression.');
        }
    }

    /**
     * Permet d'enregistrer une modification sur un portfolio
     *
     * @param string $portfolioId
     * @param \App\Http\Requests\PortfolioUpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function maj_edition_portfolio(string $portfolioId, PortfolioUpdateRequest $request): RedirectResponse
    {
        /** @var \App\Models\Portfolio $portfolio instance des portfolio */
        $portfolio = Portfolio::findOrFail($portfolioId);
        /** @var array $array Instance des donner à valider */
        $array = [
            'titre' => $request->validated('titre'),
            'description' => $request->validated('description'),
            'contenu' => $request->validated('contenu'),
            'category_portfolio_id' => $request->validated('category_portfolio_id[]')
        ];
        try {
            $portfolio->update($array);
            //Si il y a une photo
            if($request->hasFile('media')) {
                $medias = $request->validated('media');
                $dataFolder ="public/portfolio_picture/" . date('Y-m-d');
                $files = $medias->store($dataFolder, 'public');
                $portfolio->update([
                    'media' => $files
                ]);
            }
            return redirect()->back()->with('succes','Modification réussi!!!');
        } catch(\Exception $e) {
            return redirect()->back()->with('erreur','Il y a eu une erreur lors du modification.');
        }
    }

    /**
     * Permet d'editer une portfolio
     *
     * @param string $portfolioId
     * @return \Illuminate\View\View
     */
    public function edition_portfolio(string $portfolioId): View
    {
        /** @var \App\Models\Portfolio $portfolio instance des portfolio */
        $portfolio = Portfolio::findOrFail($portfolioId);
        /** @var \App\Models\CategoryPortfolio $category Categori du portfolio */
        $category = CategoryPortfolio::pluck('id','titre');
        //return 404 if portfolio is in corbeil
        if($portfolio->suprimer === 1) {
            return redirect()->route('Administration.Exception.not_found');
        }
        return view($this->viewPath().'action.random_index', [
            'portfolio' => $portfolio,
            'category' => $category
        ]);
    }

    /**
     * Permet de sauvgarder un portfolio en ajoutons quelques fonctionnalité pour
     * qu'on peut mettre en file d'attente
     * Important: Probleme sur category_portfolio select multiple
     *              A corriger plus tard!!
     *
     * @param \App\Http\Requests\CategoriPortfolioRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sauvgarder_portfolio(PortfolioRequest $request): RedirectResponse
    {
        try {
            $portfolio = new Portfolio($request->validated());
            if($request->hasFile('media')) {
                $fileName = uniqid('',true) . '.'. $request->file('media')->getClientOriginalExtension();
                $dataFolder = date('Y-m-d');
                $filePath = $request->file('media')->storeAs($dataFolder, $fileName, 'public');
                //create this
                $portfolio->media = $filePath;
            }
            $portfolio->users_id = Auth::user()->id;
            $portfolio->save();
            //partage de l'evenement
            event(new PortfolioCreateEvent($portfolio));
            return redirect()->route('Administration.Portfolio.MesPortfolio.lister_portfolio')->with('succes','Sauvgarde réussi!!!');
        } catch(\Exception $e) {
            return redirect()->back()->with('erreur','Il y a eu une erreur lors du sauvgarde.'.$e->getMessage());
        }
    }
    /**
     * Ajouter une nouvelle portfolio
     *
     * @return \Illuminate\View\View
     */
    public function ajouter_portfolio(): View
    {
        /** @var \App\Models\CategoryPortfolio $category Categori du portfolio */
        $category = CategoryPortfolio::pluck('id','titre');
        return view($this->viewPath().'action/random_index', [
            'category' => $category
        ]);
    }

    /**
     * Permet de lister les portfolio disponible
     *
     * @return \Illuminate\View\View
     */
    public function lister_portfolio(): View
    {
        /** @var \App\Models\Portfolio $portfolio instance des portfolio */
        $portfolio = Portfolio::orderBy('created_at', 'desc')
                                    ->where('suprimer', false)
                                    ->paginate(10);
        return view($this->viewPath().'index', [
            'portfolio' => $portfolio
        ]);
    }
    // fin

    /**
     * Permet de suprimer une catégorie
     *
     * @param string $categPortfolioId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function suprimer_categorie_portfolio(string $categPortfolioId): RedirectResponse
    {
        /** @var \App\Models\CategoryPortfolio $categorie Instance de categori a suprimer */
        $categorie = CategoryPortfolio::findOrFail($categPortfolioId);
        try{
            $categorie->delete();
            return redirect()->back()->with('succes','Le catégorie a été suprimer avec succès!!');
        } catch(\Exception $e) {
            return redirect()->back()->with('erreur','Il y a eu une erreur lors de la supréssion.');
        }
    }

    /**
     * Enregistre les modification faite
     *
     * @param string $categPortfolioId
     * @param \App\Http\Requests\CategoriPortfolioRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sauvgarder_edition_categorie_portfolio(string $categPortfolioId, CategoriPortfolioRequest $request) : RedirectResponse
    {
        /** @var \App\Models\CategoryPortfolio $categorie Instance de categori a modifier */
        $categorie = CategoryPortfolio::findOrFail($categPortfolioId);
        try {
            $categorie->update($request->validated());
            return redirect()->back()->with('succes','Modification réussi');
        } catch(\Exception $e) {
            return redirect()->back()->with('erreur','Il y a eu une erreur lors de la modification.');
        }
    }
    /**
     * Permet d'éditer une nouvelle catégorie
     *
     * @param string $categPortfolioId
     * @return  \Illuminate\View\View
     */
    public function edition_categorie_portfolio(string $categPortfolioId): View
    {
        /** @var \App\Models\CategoryPortfolio $categorie Instance de categori a modifier */
        $categorie = CategoryPortfolio::findOrFail($categPortfolioId);
        return view($this->viewPath().'action.random_categ', [
            'categorie' => $categorie
        ]);
    }
    /**
     * Sauvgarder la nouvelle catégorie
     *
     * @param \App\Http\Requests\CategoriPortfolioRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sauvgarder_categorie_portfolio(CategoriPortfolioRequest $request): RedirectResponse
    {
        try {
            $categ = CategoryPortfolio::create($request->validated());
            return redirect()->route('Administration.Portfolio.Categorie.liste_category_portfolio')->with('succes', 'La nouvelle catégorie a bien été ajouter!!');
        } catch(\Exception $e) {
            return redirect()->back()->with('erreur', 'Il y a eu une erreur lors de l\'ajout du nouvelle catégorie.');
        }
    }
    /**
     * Pour créer une nouvelle catégorie
     *
     * @return \Illuminate\View\View
     */
    public function creer_categorie_portfolio(): View
    {
        return view($this->viewPath().'action.random_categ');
    }
    /**
     * Liste tous les catégorie de portfolio dans notre appication
     *
     * @return \Illuminate\View\View
     */
    public function liste_category_portfolio(): View
    {
        /** @var \App\Models\CategoryPortfolio $category Instance des catégory */
        $category = CategoryPortfolio::orderBy('created_at', 'desc')
                                            ->paginate(10);
        return view($this->viewPath().'categorie', [
            'category' => $category
        ]);
    }
    /**
     * Chemin de base dans portfolio
     *
     * @return string
     */
    private function viewPath(): string
    {
        return "admin.portfolio.";
    }
}
