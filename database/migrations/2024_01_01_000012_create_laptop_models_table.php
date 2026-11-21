<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laptop_models', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained('brands')->cascadeOnDelete();
            $table->string('nama_model', 100);
            $table->string('seri', 100)->nullable();
            $table->enum('kategori_laptop', ['gaming', 'business', 'ultrabook', 'workstation', 'mainstream'])->default('mainstream');
            $table->year('tahun_rilis')->nullable();
            $table->timestamps();

            $table->unique(['brand_id', 'nama_model', 'seri']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laptop_models');
    }
};
