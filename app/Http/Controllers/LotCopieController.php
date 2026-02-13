<?php

namespace App\Http\Controllers;

use App\Models\LotCopie;
use App\Models\Module;
use App\Models\User;
use App\Models\Option;
use App\Models\SessionExamen;
use App\Models\Semestre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\CopiesDisponiblesNotification;
use Carbon\Carbon;

class LotCopieController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            abort(403);
        }

        if ($user->type === 'DA') {
            $lots = LotCopie::whereHas('module', function ($q) use ($user) {
                $q->whereHas('semestre', function ($q2) use ($user) {
                    $q2->whereHas('options', function ($q3) use ($user) {
                        $q3->whereHas('departement', function ($q4) use ($user) {
                            $q4->whereHas('etablissement', function ($q5) use ($user) {
                                $q5->where('id', $user->etablissement_id);
                            });
                        });
                    });
                });
            })->with('module.enseignant')->get();
        } elseif ($user->type === 'Enseignant') {
            $lots = LotCopie::whereHas('module', function ($q) use ($user) {
                $q->where('enseignant_id', $user->id);
            })->with('module.enseignant')->get();
        } else {
            $lots = LotCopie::with('module.enseignant')->get();
        }

        
        $lotCopies = $lots;

        return view('lot_copies.index', compact('lotCopies'));
    }


    public function create()
    {
        $user = auth()->user(); // utilisateur connecté

        if (!$user) {
            abort(403);
        }

        // --- 1. Années académiques, semestres et sessions ---
        $annees = SessionExamen::select('annee_academique')->distinct()->pluck('annee_academique');
        $semestres = Semestre::all();
        $sessions = SessionExamen::TYPES;

        // --- 2. Options selon rôle ---
        if ($user->isAdmin() || $user->isDA() || $user->isCS()) {
            $options = Option::whereHas('departement', function($q) use ($user) {
                $q->where('etablissement_id', $user->etablissement_id);
            })->get();
        } elseif ($user->isCD()) {
            $options = Option::where('departement_id', $user->departement_id)->get();
        } else {
            $options = $user->departementsEnseignes()->with('options')->get()->pluck('options')->flatten();
        }

        // --- 3. Modules selon rôle ---
        // ⚠️ On ne fait plus $option->modules en Blade, on récupère tous les modules filtrables via JS
        if ($user->isAdmin() || $user->isCS()) {
            $modules = Module::with('enseignant', 'semestre.options')->get();
        } elseif ($user->isDA()) {
            $modules = Module::whereHas('semestre.options.departement', function($q) use ($user) {
                $q->where('etablissement_id', $user->etablissement_id);
            })->with('enseignant', 'semestre.options')->get();
        } elseif ($user->isCD()) {
            $modules = Module::whereHas('semestre.options', function($q) use ($user) {
                $q->where('departement_id', $user->departement_id);
            })->with('enseignant', 'semestre.options')->get();
        } else {
            // Enseignant -> seulement les modules qu'il enseigne
            $modules = $user->modulesEnseignes()->with('enseignant', 'semestre.options')->get();
        }

        // --- 4. Enseignants ---
        if ($user->isAdmin() || $user->isDA() || $user->isCS()) {
            $enseignants = User::where('type', 'Enseignant')->get();
        } else {
            $enseignants = collect([$user]); // l’enseignant connecté
        }

        // --- 5. Retour de la vue ---
        return view('lot_copies.create', compact(
            'annees',
            'sessions',
            'semestres',
            'options',
            'modules',
            'enseignants'
        ));
    }



    public function store(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            abort(403); // sécurité
        }

        // --- 1. Validation des champs ---
        $data = $request->validate([
            'module_id'       => 'required|exists:modules,id',
            'nombre_copies'   => 'required|integer|min:1',
            'date_disponible' => 'required|date',
            'option_id'       => 'required|exists:options,id',
            'semestre_id'     => 'required|exists:semestres,id',
            'session_type'    => 'required|string',
            'annee_academique'=> 'required|string',
        ]);

        // --- 2. Création du lot de copies ---
        $lot = LotCopie::create([
            'module_id'       => $data['module_id'],
            'nombre_copies'   => $data['nombre_copies'],
            'date_disponible' => $data['date_disponible'],
            'date_recuperation' => null,
            'date_remise'       => null,
            'utilisateur_id'  => $user->id,
        ]);

        // --- 3. Association avec la session examen ---
        $session = SessionExamen::where('annee_academique', $data['annee_academique'])
                                ->where('type', strtoupper($data['session_type']))
                                ->where('semestre_id', $data['semestre_id'])
                                ->first();
        if ($session) {
            $lot->sessionExamens()->attach($session->id);
        }

        // --- 4. Notification à l'enseignant ---
        $enseignant = $lot->module->enseignant;
        if ($enseignant) {
            $enseignant->notify(new CopiesDisponiblesNotification($lot));
        }

        // --- 5. Redirection avec message de succès ---
        return redirect()
            ->route('lot-copies.index')
            ->with('success', 'Lot de copies créé et notification envoyée à l’enseignant.');
    }



    //  CORRECTED: use $lot_copy here to match the route parameter {lot_copy}
    public function edit(LotCopie $lot_copy)
    {
        $modules = Module::with('enseignant')->get();
        $enseignants = User::where('type', 'Enseignant')->get();

        return view('lot_copies.edit', compact('lot_copy', 'modules', 'enseignants'));
    }

    public function update(Request $request, LotCopie $lot_copy)
    {
        $validated = $request->validate([
            'module_id'         => 'required|exists:modules,id',
            'nombre_copies'     => 'required|integer|min:1',
            'date_disponible'   => 'required|date',
            'date_recuperation' => 'nullable|date',
            'date_remise'       => 'nullable|date',
        ]);

        $lot_copy->update($validated);

        return redirect()
            ->route('lot-copies.index')
            ->with('success', 'Lot de copies mis à jour');
    }

    public function destroy(LotCopie $lot_copy)
    {
        $lot_copy->delete();

        return redirect()
            ->route('lot-copies.index')
            ->with('success', 'Lot de copies supprimé');
    }
}
