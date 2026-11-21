<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diagnosis_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diagnosis_history_id')->constrained('diagnosis_histories')->cascadeOnDelete();
            $table->foreignId('kerusakan_id')->constrained('kerusakans')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diagnosis_results');
    }
};
