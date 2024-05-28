<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Http\Requests\RoleUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Permet de gérer tous les comptes disponible dans notre application
 * @author RANDRIANARISOA <maheninarandiranarisoa>
 * @copyright 2024 RANDRIANARISOA
 */
class GestionDeCompteController extends Controller
{

    /**
     * Suprimer un compte en particulier seulement un administrateur peut le faire
     *
     * @param string $utilisateurId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function suprimer_compte_utilisateur(string $utilisateurId): RedirectResponse
    {
        /** @var \App\Models\User $utilisateur utilisateur a suprimer */
        $utilisateur = User::findOrFail($utilisateurId);
        try {
            //Suppression indirect
            $utilisateur->update([
                'status' => true
            ]);
            return redirect()->back()->with('succes','Le compte a été suprimer avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('erreur','Il y a eu une erreur lors de la suppréssion');
        }

    }

    /**
     * Permet de sauvgarder de nouvelle information
     *
     * @param string $utilisateurId
     * @param RoleUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sauv_compte_utilisateur(string $utilisateurId, RoleUserRequest $request): RedirectResponse
    {
        /** @var \App\Models\User $utilisateur Instance de l'utilisateur */
        $utilisateur = User::findOrFail($utilisateurId);
        try {
            $utilisateur->update($request->validated());
            return redirect()->back()->with('succes','Modification des rôles réussi');
        } catch(\Exception $e) {
            return redirect()->back()->with('erreur','Il y a eu une erreur lors la modification');
        }
    }


    /**
     * Permet de modifier un compte utilisateur
     * Reste plus qu'à faire la vue adéquat
     *
     * @param string $utilisateurId identification d'un utilisateur
     * @return \Illuminate\View\View
     */
    public function modifier_compte_utilisateur(string $utilisateurId): View
    {
        /** @var \App\Models\User $utilisateur Instance de l'utilisateur */
        $utilisateur = User::findOrFail($utilisateurId);
        /** @var \App\Models\Role $role instance de role sous tableau */
        $role = Role::pluck('id', 'status');
        return view($this->viewPath().'compte.action.modification', [
            'utilisateur' => $utilisateur,
            'role' => $role
        ]);
    }

    /**
     * liste tous les comptes inscrit dans notre application
     *
     * @return \Illuminate\View\View
     */
    public function liste_compte(): View
    {
        /** @var \App\Models\User $utilisateurs récupere tous les utilisateurs */
        $utilisateurs = User::where('id','!=','1')
                                ->orderBy('created_at','desc')
                                ->paginate(10);
        return view($this->viewPath().'compte.index', [
            'utilisateurs' => $utilisateurs
        ]);
    }
    //Gestion des rôle
    /**
     * Permet de voir la listes des rôles
     * inscrite dans notre site
     * @return \Illuminate\View\View
     */
    public function liste_role(): View
    {
        /** @var \App\Models\Role $roles Roles des utilisateurs */
        $roles = Role::orderBy('created_at', 'asc')
                            ->where('supprimer','!=','1')
                            ->get();
        return view($this->viewPath().'role.index', [
            'roles' => $roles
        ]);
    }

    /**
     * Pour Ajouter un nouveau role
     *
     * @return \Illuminate\View\View
     */
    public function creer_role(): View
    {
        return view($this->viewPath().'role.action.random');
    }

    /**
     * Permet de sauvgarder le nouveau rôle entrer par l'utilisateur
     * dans la base de données
     *
     * @param \App\Http\Requests\RoleRequest $roleRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sauvgarder_role(RoleRequest $roleRequest): RedirectResponse
    {
        try {
            /** @var \App\Models\Role $role */
            $role = Role::create($roleRequest->validated());
            return redirect()->route($this->routes().'Role.liste_role')->with('succes','Rôle ajouté avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('erreur','Il y a eu une erreur lors de l\'ajout du nouveau rôle');
        }
    }

    /**
     * Permet de modifier un role
     *
     * @param string $id
     * @return \Illuminate\View\View
     */
    public function modifier_role(string $id): View
    {
        $role = Role::findOrFail($id);
        return view($this->viewPath().'role.action.random', [
            'role' => $role
        ]);
    }
    /**
     * Mets à jours les modification fait par l'utilisateur
     *
     * @param string $id
     * @param \App\Http\Requests\RoleRequest $roleRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function maj_role(string $id, RoleRequest $roleRequest): RedirectResponse
    {
        try {
            /** @var \App\Models\Role $role */
            $role = Role::findOrFail($id);
            $role->update($roleRequest->validated());
            return redirect()->route($this->routes().'Role.modifier_role', ['id' => $role->id])->with('succes','Rôle ajouté avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('erreur','Il y a eu une erreur lors de l\'ajout du nouveau rôle');
        }
    }

    /**
     * Suprime indirectement un role
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function suprimer_role(string $id):RedirectResponse
    {
        $data = ['supprimer' => '1'];
        try {
            /** @var \App\Models\Role $role */
            $role = Role::findOrFail($id);
            $role->update($data);
            return redirect()->back()->with('succes','Rôle suprimer avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('erreur','Il y a eu une erreur lors de la supression du rôle');
        }
    }
    /**
     * Chemin de vue
     *
     * @return string
     */
    private function viewPath(): string
    {
        return 'admin.gestion_compte.';
    }

    /**
     * Route
     *
     * @return string
     */
    private function routes(): string
    {
        return 'Administration.GestionCompte.';
    }
}
