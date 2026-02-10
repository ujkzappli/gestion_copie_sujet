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
        Schema::create('retard_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lot_copie_id')->constrained()->cascadeOnDelete();
            $table->string('type'); // recuperation | remise
            $table->date('sent_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retard_notifications');
    }
};
