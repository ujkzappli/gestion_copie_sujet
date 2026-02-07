<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        switch ($user->type) {
            case 'DA':
                return redirect()->route('dashboard.da');
            case 'CS':
                return redirect()->route('dashboard.cs');
            case 'CD':
                return redirect()->route('dashboard.cd');
            case 'Enseignant':
                return redirect()->route('dashboard.enseignant');
            case 'President':
                return redirect()->route('dashboard.president');
            case 'Admin':
                return redirect()->route('dashboard.admin');
            default:
                return redirect()->route('login')->with('error', "Type d'utilisateur inconnu !");
        }
    }
}
