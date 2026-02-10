<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ScanRetardsService;

class SystemScanController extends Controller
{
    public function scan()
    {
        $service = new ScanRetardsService();
        $service->scan(); // lance le scan complet

        return redirect()->back()->with('success', 'Scan des retards effectué avec succès !');
    }
}
