<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            EtablissementSeeder::class,
            DepartementSeeder::class,
            SemestreSeeder::class,
            OptionSeeder::class,
            SessionExamenSeeder::class,
            UserSeeder::class,
            EnseignantDepartementSeeder::class,
            ModuleSeeder::class,
        ]);
    }
}
