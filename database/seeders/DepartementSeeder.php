<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartementSeeder extends Seeder
{
    public function run(): void
    {
        // Map sigle_etablissement => id
        $etablissements = DB::table('etablissements')->pluck('id', 'sigle');

        $departements = [

            // ================= UFR/SH =================
            ['UFR/SH', 'Histoire et Archéologie', 'HA'],
            ['UFR/SH', 'Géographie', 'GEO'],
            ['UFR/SH', 'Sociologie', 'SOCIO'],
            ['UFR/SH', 'Philosophie', 'PHYLO'],
            ['UFR/SH', 'Psychologie', 'PSHYCO'],

            // ================= UFR/LAC =================
            ['UFR/LAC', 'Lettres Modernes', 'LM'],
            ['UFR/LAC', 'Traduction et Interprétation', 'TI'],
            ['UFR/LAC', 'Etudes anglophones', 'EA'],
            ['UFR/LAC', 'Etudes germaniques', 'EG'],
            ['UFR/LAC', 'Linguistique', 'LING'],
            ['UFR/LAC', 'Langues Appliquées au Tourisme et aux Affaires', 'LATA'],
            ['UFR/LAC', 'Arts, Gestion et Administration Culturelle', 'AGAC'],
            ['UFR/LAC', 'Etudes Arabophones et des Langues Orientales', 'EALO'],

            // ================= UFR/SDS =================
            ['UFR/SDS', 'Médecine et Spécialités médicales', 'MSM'],
            ['UFR/SDS', 'Chirurgie et Spécialités Chirurgicales', 'DCS'],
            ['UFR/SDS', 'Gynécologie Obstétrique', 'DGYO'],
            ['UFR/SDS', 'Pédiatrie', 'DP'],
            ['UFR/SDS', 'Sciences Fondamentales et Mixtes', 'SFM'],
            ['UFR/SDS', 'Santé Publique', 'SP'],
            ['UFR/SDS', 'Sciences Biologiques Appliquées', 'SB'],
            ['UFR/SDS', 'Sciences Pharmaceutiques Appliquées', 'SPA'],
            ['UFR/SDS', 'Sciences fondamentales et Physico-Chimiques', 'SPC'],
            ['UFR/SDS', 'Médecine', 'MEDE'],
            ['UFR/SDS', 'Pharmacie', 'PHAR'],
            ['UFR/SDS', 'Chirurgie dentaire', 'ED'],
            ['UFR/SDS', 'TSS', 'TSS'],

            // ================= UFR/SEA =================
            ['UFR/SEA', 'Physique', 'PHYS'],
            ['UFR/SEA', 'Mathématique', 'MATH'],
            ['UFR/SEA', 'Chimie', 'CHIM'],
            ['UFR/SEA', 'Informatique', 'INFO'],
            ['UFR/SEA', 'Tronc Commun SEA', 'TC_SEA'],

            // ================= UFR/SVT =================
            ['UFR/SVT', 'Biochimie et microbiologie', 'PH-BI'],
            ['UFR/SVT', 'Biologie Animale Physiologie Animale', 'BAPA'],
            ['UFR/SVT', 'Biologie Végétale Physiologie Végétale', 'BVPV'],
            ['UFR/SVT', 'Sciences de la Terre', 'ST'],
            ['UFR/SVT', "Centre d'Etudes pour la Promotion, l'Aménagement et la Protection de l'Environnement", 'CEPAPE'],
            ['UFR/SVT', 'Tronc Commun Sciences et Technologies', 'TC_ST'],

            // ================= IBAM =================
            ['IBAM', 'Assurance Banque Finance', 'ABF'],
            ['IBAM', 'Gestion', 'GEST'],
            ['IBAM', 'Technique Administrative', 'TA'],
            ['IBAM', 'Informatique Multimédia et Télécom', 'IMT'],

            // ================= ISSP =================
            ['ISSP', 'Statistique', 'STAT'],
            ['ISSP', 'Démographie', 'DEMO'],

            // ================= IFOAD =================
            ['IFOAD', 'IFOAD', 'IFOAD_UJKZ'],

            // ================= ISSDH =================
            ['ISSDH', 'Sciences et Technique des Activités Physiques et Sportives', 'STAPS'],
            ['ISSDH', 'Sciences et Techniques des Activités Socio-éducatives', 'STASE'],

            // ================= IGEDD =================
            ['IGEDD', 'Eau et Assainissement', 'PH-EA'],
            ['IGEDD', 'Qualité, Gestion des Risques Environnementaux', 'PH-QU'],
            ['IGEDD', 'Energie', 'ENG'],
            ['IGEDD', 'Ingénierie et Gestion des Ressources Naturelles', 'IGRN'],

            // ================= IPERMIC =================
            ['IPERMIC', 'Tronc Commun IPERMIC', 'IPERMIC_TC'],
            ['IPERMIC', 'Journalisme', 'JNL'],
            ['IPERMIC', "Communication d'entreprise / Relation Publique", 'COM-RP'],
            ['IPERMIC', 'Communication pour le Développement', 'CPD'],

            // ================= UFR/ST =================
            ['UFR/ST', 'Sciences et Technologies', 'ST'],
            ['UFR/ST', 'Mathématiques et Informatique', 'MI'],
            ['UFR/ST', 'Physique et Chimie', 'PC'],
            ['UFR/ST', 'Biologie et Psychologie', 'BP'],

            // ================= IUT =================
            ['IUT', 'Economie et Gestion', 'ECO-GEST'],

            // ================= CUZ =================
            ['CUZ', 'Département de Agroeconomie', 'AGRO'],
            ['CUZ', 'Département de Production animale', 'PA'],
            ['CUZ', 'Département de Production Végétale', 'PVA'],
            ['CUZ', "Département de Sciences de l'Homme et de la Société", 'SHS'],
            ['CUZ', 'Département Tronc Commun PA-PVA-AGE', 'TC-CUZ'],
        ];

        foreach ($departements as [$sigleEtab, $libelle, $sigle]) {

            // Sécurité : si l’établissement n’existe pas, on ignore
            if (!isset($etablissements[$sigleEtab])) {
                continue;
            }

            DB::table('departements')->insert([
                'libelle' => $libelle,
                'sigle' => $sigle,
                'etablissement_id' => $etablissements[$sigleEtab],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
