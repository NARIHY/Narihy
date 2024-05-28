<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Permet de gérer tous les services disponnible
 * dans mon application
 * @author RANDRIANARISOA <maheninarandrianarisoa@gmail.com>
 * @copyright 2024 RANDRIANARISOA
 */
class ServiceController extends Controller
{
    public function supprimer_service(string $serviceId): RedirectResponse
    {
        /** @var \App\Models\Service $service Instance de service à suprimer */
        $service = Service::findOrFail($serviceId);
        try {
            $service->delete();
            return redirect()->back()->with('succes','Suppréssion du service réussi!');
        } catch(\Exception $e) {
            return redirect()->back()->with('erreur','Il y a eu une erreur lors de la suppréssion.');
        }
    }
    /**
     * Permet de sauvgarder les modification lors de l'edition d'une service
     *
     * @param string $serviceId
     * @param \App\Http\Requests\ServiceRequest $serviceRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sauvgarder_edition_service(string $serviceId, ServiceRequest $serviceRequest): RedirectResponse
    {
        /** @var \App\Models\Service $service Instance de service à modifier */
        $service = Service::findOrFail($serviceId);
        try {
            $service->update($serviceRequest->validated());
            return redirect()->back()->with('succes','Modification du service réussi!');
        } catch (\Exception $e) {
            return redirect()->back()->with('erreur','Il y a eu une erreur lors de la modification du service.');
        }
    }

    /**
     * Edition d'un service en particulier
     *
     * @param string $serviceId
     * @return \Illuminate\View\View
     */
    public function edition_service(string $serviceId): View
    {
        /** @var \App\Models\Service $service Instance de service à modifier */
        $service = Service::findOrFail($serviceId);
        return view($this->viewPath().'action.random', [
            'service' => $service
        ]);
    }

    /**
     * Mets en active ou desactive un status un service
     *
     * @param string $serviceId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function set_status(string $serviceId): RedirectResponse
    {
        /** @var \App\Models\Service $service Instance de service à modifier */
        $service = Service::findOrFail($serviceId);
        try {
            if($service->status === '0') {
                $service->update([
                    'status' => '1'
                ]);
            } else {
                $service->update([
                    'status' => '0'
                ]);
            }
            return redirect()->back()->with('succes', 'Félicitacion, le service est activé!');
        } catch(\Exception $e) {
            return redirect()->back()->with('erreur', 'Il y a eu une erreur lors de l\'activation du service');
        }
    }

    /**
     * Permet de sauvgarder un nouveau service
     *
     * @param \App\Http\Requests\ServiceRequest $serviceRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sauvgarder_service_creer(ServiceRequest $serviceRequest): RedirectResponse
    {
        $data = [
            'nomService' => $serviceRequest->validated('nomService'),
            'description' => $serviceRequest->validated('description'),
            'icons' => $serviceRequest->validated('icons'),
            'status' => '0'
        ];
        try {
            $service = Service::create($data);
            return redirect()->route('Administration.Service.liste_service')->with('succes','Création du service réussi!');
        } catch(\Exception $e) {
            return redirect()->back()->with('erreur','Il y a eu une erreur lors de la création du service');
        }
    }
    /**
     * Permet de creer un service
     *
     * @return \Illuminate\View\View
     */
    public function creer_service():View
    {
        return view($this->viewPath().'action.random');
    }
    /**
     * Permet de lister tous mes services
     *
     * @return \Illuminate\View\View
     */
    public function liste_service():View
    {
        $service = Service::orderBy('created_at', 'asc')
                                ->paginate(10);
        return view($this->viewPath().'index', [
            'service' => $service
        ]);
    }

    /**
     * Chemin globale des vue de service
     *
     * @return string
     */
    private function viewPath(): string
    {
        return "admin.service.";
    }
}
