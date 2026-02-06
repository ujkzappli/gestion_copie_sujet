<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EnseignantDepartementSeeder extends Seeder
{
    public function run(): void
    {
        // Récupérer tous les enseignants
        $enseignants = DB::table('users')->where('type', 'Enseignant')->pluck('id');

        // Récupérer tous les départements
        $departements = DB::table('departements')->pluck('id');

        foreach ($enseignants as $enseignantId) {
            // Chaque enseignant peut être assigné à 1 à 3 départements aléatoires
            $departementsAleatoires = $departements->shuffle()->take(rand(1,3));

            foreach ($departementsAleatoires as $depId) {
                DB::table('enseignant_departement')->updateOrInsert(
                    [
                        'utilisateur_id' => $enseignantId,
                        'departement_id' => $depId,
                    ],
                    [
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}
