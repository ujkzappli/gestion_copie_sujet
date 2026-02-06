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
        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Ex: DEDA-L
            $table->string('libelle_option'); // Nom complet de l'option
            $table->foreignId('departement_id')
                  ->constrained('departements')
                  ->onDelete('cascade');
            $table->foreignId('semestre_id')
                  ->constrained('semestres')
                  ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('options');
    }
};
