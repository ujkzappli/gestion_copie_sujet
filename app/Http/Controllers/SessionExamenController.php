<?php

namespace App\Http\Controllers;

use App\Models\SessionExamen;
use App\Models\Semestre;
use App\Models\Option;
use Illuminate\Http\Request;

class SessionExamenController extends Controller
{
    public function index()
    {
        $sessions = SessionExamen::with('semestre')->get();
        return view('session_examens.index', compact('sessions'));
    }

    public function create()
    {
        $semestres = Semestre::all();
        $options = Option::with('departement')->get();

        return view('session_examens.create', compact('semestres', 'options'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'annee_academique' => 'required|string|max:11',
            'type' => 'required|string|max:255',
            'semestre_id' => 'required|exists:semestres,id',
            'options' => 'nullable|array',
        ]);

        $session = SessionExamen::create($request->only([
            'annee_academique',
            'type', 
            'semestre_id'
        ]));

        if ($request->options) {
            $session->options()->sync($request->options);
        }

        return redirect()
            ->route('session_examens.index')
            ->with('success', 'Session d’examen créée avec succès');
    }

    public function show(SessionExamen $session_examen)
    {
        $session_examen->load('semestre', 'options.departement');

        return view('session_examens.show', compact('session_examen'));
    }

    public function edit(SessionExamen $session_examen)
    {
        $semestres = Semestre::all();
        $options = Option::all();

        return view('session_examens.edit', compact(
            'session_examen',
            'semestres',
            'options'
        ));
    }

    public function update(Request $request, SessionExamen $session_examen)
    {
        $request->validate([
            'annee_academique' => 'required|string|max:11',
            'semestre_id' => 'required|exists:semestres,id',
            'options' => 'nullable|array',
        ]);

        $session_examen->update($request->only([
            'annee_academique',
            'semestre_id'
        ]));

        $session_examen->options()->sync($request->options ?? []);

        return redirect()
            ->route('session_examens.index')
            ->with('success', 'Session d’examen mise à jour');
    }

    public function destroy(SessionExamen $session_examen)
    {
        $session_examen->delete();

        return redirect()
            ->route('session_examens.index')
            ->with('success', 'Session d’examen supprimée');
    }
}
