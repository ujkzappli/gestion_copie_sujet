<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Table pivot pour la relation Many-to-Many entre LotCopies et SessionExamens
     */
    public function up(): void
    {
        Schema::create('lot_copies_session_examen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lot_copies_id')->constrained('lot_copies')->onDelete('cascade');
            $table->foreignId('session_examen_id')->constrained('session_examens')->onDelete('cascade');
            $table->timestamps();
            
            // Index unique pour éviter les doublons
            $table->unique(['lot_copies_id', 'session_examen_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lot_copies_session_examen');
    }
};
