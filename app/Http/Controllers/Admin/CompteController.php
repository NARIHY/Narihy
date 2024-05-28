<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Permet de gérer le compte d'un seule utilisateurs
 *
 * @author RANDRIANARISOA <maheninarandrianarisoa@gmail.com>
 * @copyright 2024 RANDRIANARISOA
 */
class CompteController extends Controller
{
    /**
     * Affiche l'utilisateur qui est connecté
     *
     * @return \Illuminate\View\View
     */
    public function mon_compte(): View
    {
        /** @var \Illuminate\Support\Facades\Auth $utilisateur récuperation d'une utilisateur connecter */
        $utilisateur = Auth::user();
        /** Récupération du blog poster par l'utilisateur @var \App\Models\Blog $blogs */
        $blogs = Blog::orderBy('created_at', 'desc')
                                ->where('users_id', Auth::user()->id)
                                ->where('suprimer',false)
                                ->limit(1)
                                ->get();
        /** @var \App\Models\Portfolio $portfolio Portfolio récemment publié par l'utilisateur */
        $portfolio = Portfolio::orderBy('created_at', 'desc')
                                ->where('users_id', Auth::user()->id)
                                ->where('suprimer',false)
                                ->limit(1)
                                ->get();
        return view($this->viewPath().'index', [
            'utilisateur' => $utilisateur,
            'blogs' => $blogs,
            'portfolio' => $portfolio
        ]);
    }

    /**
     * Parametre
     *
     * @return \Illuminate\View\View
     */
    public function parametre(): View
    {
        return view($this->viewPath().'parametre');
    }


    /**
     * Chemin de vue de base
     *
     * @return string
     */
    private function viewPath(): string
    {
        return "admin.profile.";
    }
}
