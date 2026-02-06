<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nom_utilisateur');
            $table->string('prenom_utilisateur');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('must_change_password')->default(true);
            $table->string('matricule_utilisateur')->unique();
            $table->string('photo')->nullable();
            $table->string('adresse')->nullable();
            $table->enum('type', ['Admin', 'President', 'Enseignant', 'CD', 'CS', 'DA']);
            $table->foreignId('departement_id')->nullable()->constrained('departements')->onDelete('set null');
            $table->foreignId('etablissement_id')->nullable()->constrained('etablissements')->onDelete('set null');
            $table->string('phone_country_code', 5)->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
