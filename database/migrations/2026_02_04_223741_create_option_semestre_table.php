<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('option_semestre', function (Blueprint $table) {
            $table->id();
            $table->foreignId('option_id')->constrained('options')->onDelete('cascade');
            $table->foreignId('semestre_id')->constrained('semestres')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['option_id','semestre_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('option_semestre');
    }
};
