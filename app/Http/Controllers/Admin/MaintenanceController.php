<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MaintenanceRequest;
use App\Models\Maintenance;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Permet de gerer les maintenance des site
 * @author RANDRIANARISOA <maheninarandrianarisoa@gmail.com>
 * @copyright 2024 RANDRIANARISOA
 */
class MaintenanceController extends Controller
{
    /**
     * Liste tous les maintenance du site
     *
     * @return View
     */
    public function liste(): View
    {
        $maintenance = Maintenance::orderBy('created_at','desc')
                                        ->paginate(10);
        return view('admin.maintenance.liste', [
            'maintenance' => $maintenance
        ]);
    }

    /**
     * Pemret de creer une maintenance
     *
     * @return View
     */
    public function creation(): View
    {
        return view('admin.maintenance.action.random');
    }

    /**
     * Permet de sauvgarder une maintenance
     *
     * @param MaintenanceRequest $request
     * @return RedirectResponse
     */
    public function sauvgarde(MaintenanceRequest $request): RedirectResponse
    {
        try {
            Maintenance::create($request->validated());
            return redirect()->route('Admin.SiteMaintenance.liste')->with('succes', 'Ajout de la date de la maintenance réussi!!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Il y a eu une erreur lors de l\'ajout.');
        }
    }

    /**
     * Permet d'editer une maintenance
     *
     * @param string $id
     * @return View
     */
    public function edition(string $id): View
    {
        $maintenance = Maintenance::findOrFail($id);
        return view('admin.maintenance.action.random', [
            'maintenance' => $maintenance
        ]);
    }

    /**
     * Sauvgarder les modification
     *
     * @param string $id
     * @param MaintenanceRequest $request
     * @return RedirectResponse
     */
    public function maj(string $id,MaintenanceRequest $request): RedirectResponse
    {
        $maintenance = Maintenance::findOrFail($id);
        try {
            $maintenance->update($request->validated());
            return redirect()->back()->with('succes', 'Ajout de la date de la maintenance réussi!!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Il y a eu une erreur lors de l\'ajout.');
        }
    }


    /**
     * Permet de supprimer la maintenance
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function supression(string $id): RedirectResponse
    {
        $maintenance = Maintenance::findOrFail($id);
        try {
            $maintenance->delete();
            return redirect()->back()->with('succes', 'Ajout de la date de la maintenance réussi!!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Il y a eu une erreur lors de l\'ajout.');
        }
    }


}
