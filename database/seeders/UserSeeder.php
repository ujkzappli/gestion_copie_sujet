<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $departements = DB::table('departements')->pluck('id', 'sigle');
        $etablissements = DB::table('etablissements')->pluck('id', 'sigle');

        $users = [
            // Admin
            [
                'nom_utilisateur' => 'ILBOUDO',
                'prenom_utilisateur' => 'Toussaint',
                'email' => 'admintoussaint@gmail.com',
                'password' => Hash::make('1234567'),
                'matricule_utilisateur' => 'UJKZ-0001',
                'photo' => null,
                'type' => 'Admin',
                'etablissement_id' => null,
                'departement_id' => null,
                'phone_country_code' => '+226',
                'phone_number' => '70000001',
            ],

            // President
            [
                'nom_utilisateur' => 'BERE',
                'prenom_utilisateur' => 'Antoine',
                'email' => 'presidentantoine@gmail.com',
                'password' => Hash::make('1234567'),
                'matricule_utilisateur' => 'UJKZ-0002',
                'photo' => null,
                'type' => 'President',
                'etablissement_id' => null,
                'departement_id' => null,
                'phone_country_code' => '+226',
                'phone_number' => '70000002',
            ],

            // DA UFR/SH
            [
                'nom_utilisateur' => 'SANKARA',
                'prenom_utilisateur' => 'Marie',
                'email' => 'damarie@gmail.com',
                'password' => Hash::make('1234567'),
                'matricule_utilisateur' => 'UJKZ-1001',
                'photo' => null,
                'type' => 'DA',
                'etablissement_id' => $etablissements['UFR/SH'] ?? null,
                'departement_id' => null,
                'phone_country_code' => '+226',
                'phone_number' => '70000003',
            ],

            // DA IFOAD
            [
                'nom_utilisateur' => 'TRAORE',
                'prenom_utilisateur' => 'Urbain',
                'email' => 'daurbain@gmail.com',
                'password' => Hash::make('1234567'),
                'matricule_utilisateur' => 'UJKZ-1002',
                'photo' => null,
                'type' => 'DA',
                'etablissement_id' => $etablissements['IFOAD'] ?? null,
                'departement_id' => null,
                'phone_country_code' => '+226',
                'phone_number' => '70000004',
            ],

            // CS exemple
            [
                'nom_utilisateur' => 'TRAORE',
                'prenom_utilisateur' => 'Jean',
                'email' => 'csjean@gmail.com',
                'password' => Hash::make('1234567'),
                'matricule_utilisateur' => 'UJKZ-2001',
                'photo' => null,
                'type' => 'CS',
                'departement_id' => null,
                'etablissement_id' => $etablissements['UFR/SEA'] ?? null,
                'phone_country_code' => '+226',
                'phone_number' => '60000001',
            ],
        ];

        // Génération automatique de 10 enseignants
        $prenom_enseignants = ['Alain','Fatou','Issa','Marie','Kadi','Alima','Paul','Aminata','Blaise','Rita'];
        $nom_enseignants = ['OUEDRAOGO','KABORE','ZONGO','KI','SANKARA','BADO','NANA','DIALLO','ILBOUDO','BERE'];

        for ($i = 0; $i < 10; $i++) {
            $users[] = [
                'nom_utilisateur' => $nom_enseignants[$i % count($nom_enseignants)],
                'prenom_utilisateur' => $prenom_enseignants[$i % count($prenom_enseignants)],
                'email' => strtolower($prenom_enseignants[$i % count($prenom_enseignants)]) . $i . '@gmail.com',
                'password' => Hash::make('1234567'),
                'matricule_utilisateur' => 'UJKZ-300' . ($i + 1),
                'photo' => null,
                'type' => 'Enseignant',
                'departement_id' => $departements->random() ?? null,
                'etablissement_id' => null,
                'phone_country_code' => '+226',
                'phone_number' => '7' . str_pad(rand(0, 9999999), 7, '0', STR_PAD_LEFT),
            ];
        }

        DB::table('users')->insert($users);
    }
}
