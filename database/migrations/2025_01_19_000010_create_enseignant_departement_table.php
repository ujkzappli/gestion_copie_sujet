<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Table pivot pour la relation Many-to-Many entre Enseignant et Departement
     */
    public function up(): void
    {
        Schema::create('enseignant_departement', function (Blueprint $table) {
            $table->id();
            $table->foreignId('utilisateur_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('departement_id')->constrained('departements')->onDelete('cascade');
            $table->timestamps();
            
            // Index unique pour éviter les doublons
            $table->unique(['utilisateur_id', 'departement_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enseignant_departement');
    }
};
