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
        Schema::create('lot_copies', function (Blueprint $table) {
            $table->id();
            $table->integer('nombre_copies');
            $table->date('date_disponible');
            $table->date('date_recuperation')->nullable();
            $table->date('date_remise')->nullable();
            $table->enum('statut', ['Valider', 'Retard'])->default('Valider');
            
            // Clé étrangère vers utilisateur (Enseignant qui a le lot)
            $table->foreignId('utilisateur_id')->constrained('users')->onDelete('cascade');
            
            // Clé étrangère vers module
            $table->foreignId('module_id')->constrained('modules')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lot_copies');
    }
};
