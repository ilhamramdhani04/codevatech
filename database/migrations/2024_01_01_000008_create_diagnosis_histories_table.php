<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diagnosis_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nama_pengguna', 100)->nullable();
            $table->timestamp('tanggal_diagnosis');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diagnosis_histories');
    }
};
