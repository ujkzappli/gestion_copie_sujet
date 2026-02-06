<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EtablissementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('etablissements')->insert([
            [
                'libelle' => 'UFR/Scinces Humaines',
                'sigle' => 'UFR/SH',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'UFR/Lettre Arts et Communication',
                'sigle' => 'UFR/LAC',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'UFR/Sciences de la santé',
                'sigle' => 'UFR/SDS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'UFR/Sciences Excates et Appliquées',
                'sigle' => 'UFR/SEA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'UFR/Sciences de la Vie et de la Terre',
                'sigle' => 'UFR/SVT',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Istitut Burkinabè des Arts et Métiers',
                'sigle' => 'IBAM',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Istitut des Supérieurs des Sciences de la Population',
                'sigle' => 'ISSP',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Institut de Formations Ouvertes et a Distance',
                'sigle' => 'IFOAD',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => "INSTITUT DES SCIENCES DU SPORT ET DU DEVELOPPEMENT HUMAIN",
                'sigle' => 'ISSDH',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => "INSTITUT DE GENIE DE L' ENVIRONNEMENT ET DU DEVELOPPEMENT DURABLE",
                'sigle' => 'IGEDD',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => "Institu Panafricain d'Etudes et de Recherche sur les Média, l'Information et la Communication",
                'sigle' => 'IPERMIC',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'UFR/Sciences et Technologie',
                'sigle' => 'UFR/ST',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Institut Universitaire de Technologie (IUT)',
                'sigle' => 'IUT',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'libelle' => 'Centre Universitaire de ZINIARE',
                'sigle' => 'CUZ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
