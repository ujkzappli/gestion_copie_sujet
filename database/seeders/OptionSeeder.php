<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OptionSeeder extends Seeder
{
    public function run(): void
    {
        // Récupérer les IDs des départements par sigle
        $departements = DB::table('departements')->pluck('id', 'sigle');

        // Récupérer les IDs des semestres par code
        $semestres = DB::table('semestres')->pluck('id', 'code');

        // Liste des options
        $options = [
            // ================= LICENCE =================
            ['code' => 'DEDA-L', 'libelle' => 'Développement et Éducation des Adultes (Licence)', 'departement_sigle' => 'SOCIO', 'semestre_code' => 'L1-S1'],
            ['code' => 'LM-L', 'libelle' => 'Lettres Modernes (Licence)', 'departement_sigle' => 'LM', 'semestre_code' => 'L1-S1'],
            ['code' => 'TI-L', 'libelle' => 'Traduction et Interprétation (Licence)', 'departement_sigle' => 'TI', 'semestre_code' => 'L1-S1'],

            // ================= MASTER =================
            ['code' => 'DEDA-M', 'libelle' => 'Développement et Éducation des Adultes (Master)', 'departement_sigle' => 'SOCIO', 'semestre_code' => 'M1-S1'],
            ['code' => 'MHSC-M', 'libelle' => 'Master Santé Communautaire', 'departement_sigle' => 'SOCIO', 'semestre_code' => 'M1-S1'],

            // ================= AUTRES =================
            ['code' => 'PHYS-L', 'libelle' => 'Physique (Licence)', 'departement_sigle' => 'PHYS', 'semestre_code' => 'L1-S1'],
            ['code' => 'MATH-L', 'libelle' => 'Mathématiques (Licence)', 'departement_sigle' => 'MATH', 'semestre_code' => 'L1-S1'],
        ];

        foreach ($options as $opt) {
            DB::table('options')->insert([
                'code' => $opt['code'],
                'libelle_option' => $opt['libelle'],
                'departement_id' => $departements[$opt['departement_sigle']] ?? null,
                'semestre_id' => $semestres[$opt['semestre_code']] ?? null, // <-- ici on lie le semestre
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
