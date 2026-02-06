<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SemestreSeeder extends Seeder
{
    public function run(): void
    {
        $semestres = [
            // ================= LICENCE (6 semestres) =================
            ['code' => 'L1-S1', 'numero' => 1, 'cycle' => 'LICENCE', 'libelle' => 'Semestre 1'],
            ['code' => 'L1-S2', 'numero' => 2, 'cycle' => 'LICENCE', 'libelle' => 'Semestre 2'],
            ['code' => 'L2-S3', 'numero' => 3, 'cycle' => 'LICENCE', 'libelle' => 'Semestre 3'],
            ['code' => 'L2-S4', 'numero' => 4, 'cycle' => 'LICENCE', 'libelle' => 'Semestre 4'],
            ['code' => 'L3-S5', 'numero' => 5, 'cycle' => 'LICENCE', 'libelle' => 'Semestre 5'],
            ['code' => 'L3-S6', 'numero' => 6, 'cycle' => 'LICENCE', 'libelle' => 'Semestre 6'],

            // ================= MASTER (4 semestres) =================
            ['code' => 'M1-S1', 'numero' => 1, 'cycle' => 'MASTER', 'libelle' => 'Semestre 1 Master 1'],
            ['code' => 'M1-S2', 'numero' => 2, 'cycle' => 'MASTER', 'libelle' => 'Semestre 2 Master 1'],
            ['code' => 'M2-S3', 'numero' => 3, 'cycle' => 'MASTER', 'libelle' => 'Semestre 3 Master 2'],
            ['code' => 'M2-S4', 'numero' => 4, 'cycle' => 'MASTER', 'libelle' => 'Semestre 4 Master 2'],

            // ================= DOCTORAT =================
            ['code' => 'D-S1', 'numero' => 1, 'cycle' => 'DOCTORAT', 'libelle' => 'Semestre Doctorat 1'],
            ['code' => 'D-S2', 'numero' => 2, 'cycle' => 'DOCTORAT', 'libelle' => 'Semestre Doctorat 2'],
            ['code' => 'D-S3', 'numero' => 3, 'cycle' => 'DOCTORAT', 'libelle' => 'Semestre Doctorat 3'],
            ['code' => 'D-S4', 'numero' => 4, 'cycle' => 'DOCTORAT', 'libelle' => 'Semestre Doctorat 4'],
        ];

        foreach ($semestres as $sem) {
            DB::table('semestres')->insert([
                'code' => $sem['code'],
                'numero' => $sem['numero'],
                'cycle' => $sem['cycle'],
                'libelle' => $sem['libelle'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
