<?php

namespace App\Http\Controllers\Admin;

use App\Events\BlogCreationEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlogAdminRequest;
use App\Http\Requests\BlogAdminUpdateRequest;
use App\Models\Blog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * PErmet de gérer mon blog cotés administration
 * @author RANDRIANARISOA <maheninarandrianarisoa@gmail.com>
 * @copyright 2024 RANDRIANARISOA
 */
class BlogController extends Controller
{
    /**
     * Suprimer directement un blog
     *
     * @param string $blogId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forcer_suppression(string $blogId): RedirectResponse
    {
        /** @var \App\Models\Blog $blog Instance du blog a suprimer */
        $blog = Blog::findOrFail($blogId);
        try {
            $blog->delete();
            return redirect()->back()->with('succes','Suppression réussi!!');
        } catch(\Exception $e) {
            return redirect()->back()->with('erreur','echec de la suppréssion');
        }
    }

    /**
     * Permet de mettre en actif ou en inactif une blog
     *
     * @param string $blogId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function change_status(string $blogId): RedirectResponse
    {
        /** @var \App\Models\Blog $blog Instance du blog a modifier */
        $blog = Blog::findOrFail($blogId);
        try {
            if($blog->status === 1) {
                $blog->update([
                    'status' => false
                ]);
            } else {
                $blog->update([
                    'status' => true
                ]);
            }
            return redirect()->back();
        } catch(\Exception $e) {
            return redirect()->back()->with('erreur', 'Il y a eu une erreur lors du changement du status.');
        }
    }

    /**
     * Mets en corbeille le blog
     *
     * @param string $blogId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function supression_simple(string $blogId): RedirectResponse
    {
        /** @var \App\Models\Blog $blog Instance du blog a suprimer */
        $blog = Blog::findOrFail($blogId);
        try{
            $blog->update(
                [
                    'suprimer' => true
                ]
            );
            return redirect()->back()->with('succes','Supression du blog réussi!!!');
        } catch (\Exception $e) {
            return redirect()->back()->with('erreur','Il y a eu une erreur lors de la supréssion.');
        }
    }

    /**
     * Pemet de modifier une blog
     *
     * @param string $blogId
     * @param BlogAdminUpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sauvgarder_modification_blog(string $blogId, BlogAdminUpdateRequest $request): RedirectResponse
    {
        /** @var \App\Models\Blog $blog Instance du blog a modifier */
        $blog = Blog::findOrFail($blogId);
        try {
            //MAJ
            $array = [
                'titre' => $request->validated('titre'),
                'contenu' => $request->validated('contenu')
            ];
            $blog->update($array);
            //Si il y a une photo
            if($request->hasFile('media')) {
                $medias = $request->validated('media');
                $dataFolder ="public/blogs_picture/" . date('Y-m-d');
                $files = $medias->store($dataFolder, 'public');
                $blog->update([
                    'media' => $files
                ]);
            }
            return redirect()->back()->with('succes','Modification du blog réussi!!');
        } catch (\Exception $e) {
            return redirect()->back()->with('erreur','Il y a eu une erreur lors de la modification.');
        }
    }
    /**
     * Permet de modifier un blog en particulier
     *
     * @param string $blogId
     * @return \Illuminate\View\View | \Illuminate\Http\RedirectResponse
     */
    public function modifier_blog(string $blogId): View | RedirectResponse
    {
        /** @var \App\Models\Blog $blog Instance du blog a modifier */
        $blog = Blog::findOrFail($blogId);
        if($blog->suprimer === 1) {
            return redirect()->route('Administration.Exception.not_found');
        }
        return view($this->viewPath().'action.random', [
            'blog' => $blog
        ]);
    }

    /**
     * On sauvgarder les données entrer par l'utilisateur dans la base de donnée
     * Le principe est un peut complexe, je veux que les donnée a entré sont enter
     * avec un évènements et un listeners.
     * Mais il y a un petit problèmes (Le media type fichier), C'est possible si il n'y a aucun fichier
     * mais pour que ça soit possible, on vas sauvgarder le fichier dans public dans un
     * dossier nommer blogs_event et on recupere que le chemin du fichier avec un nom unique encrer dans
     * une dossier perso (le nom de dossier est la date ou le fichier a été envoyer vers l'application)
     * Puis dans notre listener on recupere le fichier dans public en le stockant dans storage dans un dossier
     * blogs_picture et dans un sous dossier pour les differentier des autre images (le nom du sous dossier à stocker est la date ou le fichier
     * a été ajouter dans storage)
     * Cela est nécessaire pour permettre d'amelioration future afin qu'on puisse ajouter cette partie de notre application
     * dans notre file d'attente
     *
     * @param \App\Http\Requests\BlogAdminRequest  $blogAdminRequest Donner valider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sauvgarder_blog_creer(BlogAdminRequest $blogAdminRequest): RedirectResponse
    {
        try {
            /** @var \App\Models\Blog $blog ajout blog */
            $blog = new Blog($blogAdminRequest->validated());
            if($blogAdminRequest->hasFile('media')) {
                $fileName = uniqid('',true) . '.'. $blogAdminRequest->file('media')->getClientOriginalExtension();
                $dataFolder = date('Y-m-d');
                //$filePath = "public/blogs_event/$dataFolder/$fileName";
                //Erreur est ici
                $filePath = $blogAdminRequest->file('media')->storeAs($dataFolder, $fileName, 'public');

                $blog->media = $filePath;
            }
            $blog->users_id = Auth::user()->id;
            $blog->save();
            //creer l'evenement
            event(new BlogCreationEvent($blog));
            return redirect()->route('Administration.Blog.liste_les_blogs')->with('succes','Félicitation, le blog a été enrergistrer avec succès!!');
        } catch(\Exception $e) {
            return redirect()->back()->with('erreur','Il y a eu une erreur lors de l\'enregistrement du blog');
        }
    }
    /**
     * Permet de créer une nouvelles blog
     *
     * @return \Illuminate\View\View
     */
    public function creer_une_blog(): View
    {
        return view($this->viewPath().'action.random');
    }
    /**
     * Récupération des blogs avec pagination de 15/15
     * dans le listing
     *
     * @return \Illuminate\View\View
     */
    public function liste_les_blogs(): View
    {
        /** @var \App\Models\Blog $blog Récuperation par ordre décroissant + pagination */
        $blogs = Blog::orderBy('created_at','desc')
                        ->where('suprimer', '==',false)
                        ->paginate(15);
        return view($this->viewPath().'index', [
            'blogs' => $blogs
        ]);
    }
    /**
     * Chemin de base des vue pour le blog dans l'administration
     *
     * @return string
     */
    private function viewPath(): string
    {
        return "admin.blog.";
    }
}
