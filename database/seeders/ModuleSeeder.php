<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuleSeeder extends Seeder
{
    public function run(): void
    {
        // Récupérer tous les semestres
        $semestres = DB::table('semestres')->pluck('id', 'numero');

        $modules = [
            // Sociologie Licence S1
            ['code' => 'SOC-S1-M1', 'nom' => 'Introduction à la Sociologie', 'semestre_id' => $semestres[1]],
            ['code' => 'SOC-S1-M2', 'nom' => 'Méthodologie', 'semestre_id' => $semestres[1]],
            ['code' => 'SOC-S1-M3', 'nom' => 'Histoire des sociétés', 'semestre_id' => $semestres[1]],

            // Sociologie Licence S2
            ['code' => 'SOC-S2-M1', 'nom' => 'Sociologie urbaine', 'semestre_id' => $semestres[2]],
            ['code' => 'SOC-S2-M2', 'nom' => 'Anthropologie', 'semestre_id' => $semestres[2]],
            ['code' => 'SOC-S2-M3', 'nom' => 'Statistiques sociales', 'semestre_id' => $semestres[2]],

            // Mathématiques Licence S1
            ['code' => 'MAT-S1-M1', 'nom' => 'Algèbre I', 'semestre_id' => $semestres[1]],
            ['code' => 'MAT-S1-M2', 'nom' => 'Analyse I', 'semestre_id' => $semestres[1]],
            ['code' => 'MAT-S1-M3', 'nom' => 'Informatique fondamentale', 'semestre_id' => $semestres[1]],

            // Mathématiques Licence S2
            ['code' => 'MAT-S2-M1', 'nom' => 'Algèbre II', 'semestre_id' => $semestres[2]],
            ['code' => 'MAT-S2-M2', 'nom' => 'Analyse II', 'semestre_id' => $semestres[2]],
            ['code' => 'MAT-S2-M3', 'nom' => 'Probabilités', 'semestre_id' => $semestres[2]],

            // Médecine Licence S1
            ['code' => 'MED-S1-M1', 'nom' => 'Biologie cellulaire', 'semestre_id' => $semestres[1]],
            ['code' => 'MED-S1-M2', 'nom' => 'Chimie générale', 'semestre_id' => $semestres[1]],
            ['code' => 'MED-S1-M3', 'nom' => 'Anatomie de base', 'semestre_id' => $semestres[1]],
        ];

        DB::table('modules')->insert($modules);
    }
}
