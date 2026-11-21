<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('solusis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kerusakan_id')->constrained('kerusakans')->cascadeOnDelete();
            $table->text('deskripsi');
            $table->tinyInteger('urutan')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solusis');
    }
};
