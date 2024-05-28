<?php

namespace App\Http\Controllers\Admin;

use App\Events\ActualiterCreationEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\ActualiteAdminRequest;
use App\Http\Requests\ActualiteAdminUpdateRequest;
use App\Models\Actualite;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Permet de gérer la partie administration de l'actualité
 * @author RANDRIANARISOA <maheninarandrianarisoa@gmail.com>
 * @copyright 2024 RANDRIANARISOA
 */
class ActualiteController extends Controller
{
    /**
     * Permet de changer la status d'une actualité en actif ou en inactif
     *
     * @param string $actualiteId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changer_status_actu(string $actualiteId): RedirectResponse
    {
        /** @var \App\Models\Actualite $actualite Instance du actualite a modifier */
        $actualite = Actualite::findOrFail($actualiteId);
        try {
            if($actualite->status === 1) {
                $actualite->update([
                    'status' => false
                ]);
            } else {
                $actualite->update([
                    'status' => true
                ]);
            }
            return redirect()->back()->with('succes','Changement de status réussi!!');
        } catch (\Exception $e) {
            return redirect()->back()->with('erreur','Il y a eu une erreur lors du changement de status.');
        }
    }
    /**
     * Suprimer directement une actualiter
     *
     * @param string $actualiteId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function supresion_direct_actualite(string $actualiteId): RedirectResponse
    {
        /** @var \App\Models\Actualite $actualite Instance du actualite a suprimer */
        $actualite = Actualite::findOrFail($actualiteId);
        try {
            $actualite->delete();
            return redirect()->back()->with('succes','Supréssion de l\'actualité réussi!!');
        } catch(\Exception $e) {
            return redirect()->back()->with('erreur','Il y a eu une erreur lors de la supréssion.');
        }
    }
    /**
     * Permet de mettre en corbeil une actualite
     *
     * @param string $actualiteId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function supression_simple_actu(string $actualiteId): RedirectResponse
    {
        /** @var \App\Models\Actualite $actualite Instance du actualite a suprimer */
        $actualite = Actualite::findOrFail($actualiteId);
        try {
            if($actualite->suprimer === 1) {
                return redirect()->route('Administration.Exception.not_found');
            }
            $actualite->update([
                'suprimer' => true
            ]);
            return redirect()->back()->with('succes','l\'actualités a bien été suprimer!!');
        } catch (\Exception $e) {
            return redirect()->back()->with('erreur','Il y a eu une erreur lors de la suppréssion.');
        }
    }
    /**
     * PErmet de modifier une actualiter
     *
     * @param string $actualiteId
     * @param \App\Http\Requests\ActualiteAdminUpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sauvgarder_modification_actualite(string $actualiteId, ActualiteAdminUpdateRequest $request): RedirectResponse
    {
        /** @var \App\Models\Actualite $actualite Instance du actualite a modifier */
        $actualite = Actualite::findOrFail($actualiteId);
        try {
            //MAJ
            $array = [
                'titre' => $request->validated('titre'),
                'contenu' => $request->validated('contenu')
            ];
            $actualite->update($array);
            //Si il y a une photo
            if($request->hasFile('media')) {
                $medias = $request->validated('media');
                $dataFolder ="public/actualite_picture/" . date('Y-m-d');
                $files = $medias->store($dataFolder, 'public');
                $actualite->update([
                    'media' => $files
                ]);
            }
            return redirect()->back()->with('succes','Modification du blog réussi!!');
        } catch (\Exception $e) {
            return redirect()->back()->with('erreur','Il y a eu une erreur lors de la modification.');
        }
    }
    /**
     * Redirige vers l'edition d'une actualite
     *
     * @param string $actualiteId
     * @return \Illuminate\View\View
     */
    public function edition_actualite(string $actualiteId):View
    {
        /** @var \App\Models\Actualite $actualite Instance du blog a modifier */
        $actualite = Actualite::findOrFail($actualiteId);
        if($actualite->suprimer === 1) {
            return redirect()->route('Administration.Exception.not_found');
        }
        return view($this->viewPath().'action.random', [
            'actualite' => $actualite
        ]);
    }
    /**
     * Le principe est le meme que celui du blog controlleur
     *
     * @param \App\Http\Requests\ActualiteAdminRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sauvgarde_actualite(ActualiteAdminRequest $request): RedirectResponse
    {
        try {
            /** @var \App\Models\Actualite $actualite creation d'une nouvelle actu */
            $actualite = new Actualite($request->validated());
            if($request->hasFile('media')) {
                $fileName = uniqid('',true) . '.'. $request->file('media')->getClientOriginalExtension();
                $dataFolder = date('Y-m-d');
                ///save files
                $filePath = $request->file('media')->storeAs($dataFolder, $fileName, 'public');
                $actualite->media = $filePath;
            }
            $actualite->users_id = Auth::user()->id;
            $actualite->save();
            //Creation d'une évenement
            event(new ActualiterCreationEvent($actualite));
            return redirect()->route('Administration.Actualite.liste_des_actualite')->with('succes','Félicitation, l\' actualité a été enrergistrer avec succès!!');
        } catch (\Exception $e) {
            return redirect()->back()->with('erreur','Il y a eu une erreur lors de l\'enregistrement de l\'actualités.');
        }
    }
    /**
     * Permet de créer une  nouvelle actualite
     *
     * @return View
     */
    public function creer_actualite(): View
    {
        return view($this->viewPath().'action.random');
    }
    /**
     * Liste tous les actualités de notre application
     *
     * @return  \Illuminate\View\View
     */
    public function liste_des_actualite(): View
    {
        /** @var \App\Models\Actualite $actualite Liste tous les actualite */
        $actualite = Actualite::orderBy('created_at', 'desc')
                                    ->where('suprimer', '==', false)
                                    ->paginate(10);
        return view($this->viewPath().'index', [
            'actualites' => $actualite
        ]);
    }
    /**
     * Chemin de base des vues
     *
     * @return string
     */
    private function viewPath(): string
    {
        return "admin.actualite.";
    }
}
