<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel audit trail untuk mencatat semua aksi sensitif admin.
     */
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('action', 20);           // created, updated, deleted
            $table->string('model_type', 100);       // App\Models\Kerusakan dll
            $table->unsignedBigInteger('model_id')->nullable();
            $table->string('description');           // Pesan ringkas
            $table->ipAddress('ip_address')->nullable();
            $table->json('changes')->nullable();     // Data sebelum/sesudah
            $table->timestamps();

            // Index untuk query audit trail
            $table->index(['model_type', 'model_id']);
            $table->index('user_id');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
