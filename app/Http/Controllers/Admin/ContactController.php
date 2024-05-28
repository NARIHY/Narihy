<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnswerUserRequest;
use App\Models\Contacte;
use App\Models\User;
use App\Notifications\AnswerUserNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Pour gérer tous les message envoyez par les utilisateur
 * dans la partie admin
 * @author RANDRIANARISOA <maheninarandrianarisoa@gmail.com>
 * @copyright 2024 RANDRIANARISOA
 */
class ContactController extends Controller
{
    /**
     * Lister les contactes reçu
     *
     * @return \Illuminate\View\View
     */
    public function liste_contacte(): View
    {
        /** @var \App\Models\Contacte $contacts Récupération des contactes envoyez */
        $contacts = Contacte::orderBy('created_at', 'desc')
                                    ->paginate(15);
        $user = Auth::user();
        return view($this->viewPath().'index', [
            'contacts' => $contacts,
            'user' => $user
        ]);
    }

    /**
     * Permet de voir les contacts reçu
     *
     * @param string $contactId
     * @return \Illuminate\View\View
     */
    public function voir_contacte(string $contactId):View
    {
        /** @var \App\Models\Contacte $contacts Récupération du contacte à voir */
        $contact = Contacte::findOrFail($contactId);
        if($contact->status !== 'lue') {
            $contact->update(
                [
                    'status' => 'lue'
                ]
            );
        }
        return view($this->viewPath().'action.voir', [
            'contact' => $contact
        ]);
    }

    /**
     * Answering view of one user guest
     *
     * @param string $contactId
     * @return \Illuminate\View\View
     */
    public function answer_users(string $contactId): View
    {
        /** @var \App\Models\Contacte $contact instance of one contact to reply */
        $contact = Contacte::findOrFail($contactId);
        return view($this->viewPath().'action.reply', [
            'contact' => $contact
        ]);
    }

    /**
     * Send the answer of one message of one user (Guest)
     * Just use a notification to send it
     *
     * @param string $contactId get contact id to find the user to reply
     * @param AnswerUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function answer_users_contacts(string $contactId, AnswerUserRequest $request): RedirectResponse
    {
        /** @var \App\Models\Contacte $contact instance of one contact to reply */
        $contact = Contacte::findOrFail($contactId);
        $data = $request->validated();
        try {
            if($contact->reponse === 1) {
                return redirect()->route('Administration.Contacte.voir_contacte', ['contactId' => $contact->id])->with('erreur','L\'utilisateur a déjàs été répondu. ');
            }
            $contact->notify(new AnswerUserNotification($data));
            $contact->update(
                [
                    'reponse' => true,
                    'publie_par' => Auth::user()->id
                ]
            );
            return redirect()->route('Administration.Contacte.voir_contacte', ['contactId' => $contact->id])->with('succes','L\'utilisateur a été répondu avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('erreur','Il y a eu une erreur lors de l\'envoye de la réponse');
        }
    }
    /**
     * Retourne une instance de chemin de la base de la vue
     *
     * @return string
     */
    private function viewPath(): string
    {
        return "admin.contacte.";
    }
}
