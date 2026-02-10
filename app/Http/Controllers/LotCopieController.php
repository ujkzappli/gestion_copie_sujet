<?php

namespace App\Http\Controllers;

use App\Models\LotCopie;
use App\Models\Module;
use App\Models\User;
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
        $user = Auth::user();
        if (!$user) {
            abort(403);
        }

        if ($user->type === 'DA') {
            $modules = Module::whereHas('semestre.options.departement', function ($q) use ($user) {
                $q->where('etablissement_id', $user->etablissement_id);
            })
            ->with('enseignant')
            ->get();
        } else {
            $modules = Module::with('enseignant')->get();
        }

        $enseignants = User::where('type', 'Enseignant')->get();

        return view('lot_copies.create', compact('modules', 'enseignants'));
    }


    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            abort(403);
        }

        $validated = $request->validate([
            'module_id'       => 'required|exists:modules,id',
            'nombre_copies'   => 'required|integer|min:1',
            'date_disponible' => 'required|date',
        ]);

        $lot = LotCopie::create([
            'module_id'       => $validated['module_id'],
            'nombre_copies'   => $validated['nombre_copies'],
            'date_disponible' => $validated['date_disponible'],
            'date_recuperation' => null, // ❗️IMPORTANT
            'date_remise'       => null, // ❗️IMPORTANT
            'utilisateur_id'  => $user->id,
        ]);

        // 🔔 + 📧 Notification à l’enseignant
        $enseignant = $lot->module->enseignant;

        if ($enseignant) {
            $enseignant->notify(new CopiesDisponiblesNotification($lot));
        }

        return redirect()
            ->route('lot-copies.index')
            ->with('success', 'Lot de copies créé et notification envoyée à l’enseignant');
    }


    // 🟢 CORRECTED: use $lot_copy here to match the route parameter {lot_copy}
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
