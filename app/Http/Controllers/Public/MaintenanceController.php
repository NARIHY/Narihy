<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Pour la maintenance de notre application
 * @author RANDRIANARISOA <maheninarandrianarisoa@gmail.com>
 * @copyright 2024 RANDRIANARISOA
 */
class MaintenanceController extends Controller
{
    /**
     * Retourne la vue de maintenance
     *
     * @return \Illuminate\View\View
     */
    public function site(): View
    {
        return view('maintenance.index');
    }
}
