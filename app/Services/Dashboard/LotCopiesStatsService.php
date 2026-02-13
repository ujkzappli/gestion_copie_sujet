<?php

namespace App\Services\Dashboard;

use App\Models\LotCopie;

class LotCopiesStatsService
{
    public function getGlobalStats($filters = [])
    {
        $query = LotCopie::query();

        // Filtres dynamiques
        if (!empty($filters['etablissement_id'])) {
            $query->whereHas('module.enseignant', fn($q) =>
                $q->where('etablissement_id', $filters['etablissement_id'])
            );
        }

        if (!empty($filters['departement_id'])) {
            $query->whereHas('module.enseignant', fn($q) =>
                $q->where('departement_id', $filters['departement_id'])
            );
        }

        if (!empty($filters['annee_academique'])) {
            $query->whereHas('sessionExamens', fn($q) =>
                $q->where('annee_academique', $filters['annee_academique'])
            );
        }

        if (!empty($filters['session'])) {
            $query->whereHas('sessionExamens', fn($q) =>
                $q->where('type', $filters['session'])
            );
        }

        if (!empty($filters['semestre_id'])) {
            $query->whereHas('module.semestre', fn($q) =>
                $q->where('id', $filters['semestre_id'])
            );
        }

        $lots = $query->get();

        return [
            'en_cours' => $lots->filter(fn($l) => $l->statut_calcule === 'En cours')->count(),
            'valide'   => $lots->filter(fn($l) => $l->statut_calcule === 'Validé')->count(),
            'retard'   => $lots->filter(fn($l) => $l->statut_calcule === 'En retard')->count(),
        ];
    }
}
