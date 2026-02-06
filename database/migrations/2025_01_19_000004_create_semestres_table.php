<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('semestres', function (Blueprint $table) {
            $table->id();

            // Numéro du semestre dans le cycle
            $table->unsignedTinyInteger('numero');

            // Cycle universitaire (LMD)
            $table->enum('cycle', ['LICENCE', 'MASTER', 'DOCTORAT']);

            // Libellé lisible pour affichage
            $table->string('libelle');

            // Code unique pour le seeder / référence (optionnel mais pratique)
            $table->string('code')->unique();

            $table->timestamps();

            // Un semestre est unique par cycle et numéro
            $table->unique(['numero', 'cycle']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semestres');
    }
};
