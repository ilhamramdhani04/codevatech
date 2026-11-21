<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah soft deletes ke tabel-tabel penting
     * agar data recoverable dari kesalahan hapus.
     */
    public function up(): void
    {
        $tables = ['kerusakans', 'gejalas', 'rules', 'diagnosis_histories'];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $t) {
                $t->softDeletes();
            });
        }
    }

    public function down(): void
    {
        $tables = ['kerusakans', 'gejalas', 'rules', 'diagnosis_histories'];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $t) {
                $t->dropSoftDeletes();
            });
        }
    }
};
