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
        Schema::table('lot_copies', function (Blueprint $table) {
            $table->date('last_recuperation_reminder_at')->nullable();
            $table->date('last_remise_reminder_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lot_copies', function (Blueprint $table) {
            //
        });
    }
};
