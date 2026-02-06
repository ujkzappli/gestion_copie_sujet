<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SessionExamenSeeder extends Seeder
{
    public function run(): void
    {
        $anneeAcademique = '2025-2026';

        $typesSessions = ['NORMALE', 'RATTRAPAGE'];

        // Récupération de tous les semestres
        $semestres = DB::table('semestres')->pluck('id', 'id'); 
        // clé = id pour faciliter l'insertion

        $id = 1; // Pour avoir des id consécutifs, optionnel

        foreach ($semestres as $semestreId) {
            foreach ($typesSessions as $type) {
                DB::table('session_examens')->insert([
                    'id' => $id,
                    'type' => $type,
                    'annee_academique' => $anneeAcademique,
                    'semestre_id' => $semestreId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $id++;
            }
        }
    }
}
