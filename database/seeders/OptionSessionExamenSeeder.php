<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OptionSessionExamenSeeder extends Seeder
{
    public function run(): void
    {
        // Récupérer toutes les sessions
        $sessions = DB::table('session_examens')->get()->keyBy(function ($item) {
            return $item->type . '-' . $item->semestre_id;
        });

        // Récupérer toutes les options
        $options = DB::table('options')->get();

        foreach ($options as $option) {
            // Déterminer si Licence ou Master
            $semesters = strpos($option->code, '-L') !== false ? range(1,6) : range(1,4);

            foreach ($semesters as $sem) {
                // Session normale
                if(isset($sessions['session normale-'.$sem])){
                    DB::table('option_session_examen')->insert([
                        'option_id' => $option->id,
                        'session_examen_id' => $sessions['session normale-'.$sem]->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                // Session de rattrapage
                if(isset($sessions['session de rattrappage-'.$sem])){
                    DB::table('option_session_examen')->insert([
                        'option_id' => $option->id,
                        'session_examen_id' => $sessions['session de rattrappage-'.$sem]->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
