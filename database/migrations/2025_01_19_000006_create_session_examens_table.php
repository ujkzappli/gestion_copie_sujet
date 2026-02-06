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
        Schema::create('session_examens', function (Blueprint $table) {
            $table->id();

            // Année académique au format '2024-2025'
            $table->string('annee_academique', 9);

            // Type de session
            $table->enum('type', ['NORMALE', 'RATTRAPAGE', 'SPECIALE']);

            $table->foreignId('semestre_id')
                  ->constrained('semestres')
                  ->onDelete('cascade');

            $table->timestamps();

            // Une seule session par type / semestre / année
            $table->unique(['annee_academique', 'type', 'semestre_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_examens');
    }
};
