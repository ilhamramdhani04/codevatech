<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('diagnosis_histories', function (Blueprint $table) {
            $table->foreignId('brand_id')->nullable()->after('nama_pengguna')
                  ->constrained('brands')->nullOnDelete();
            $table->foreignId('laptop_model_id')->nullable()->after('brand_id')
                  ->constrained('laptop_models')->nullOnDelete();
            $table->string('laptop_info_manual', 150)->nullable()->after('laptop_model_id');
        });
    }

    public function down(): void
    {
        Schema::table('diagnosis_histories', function (Blueprint $table) {
            $table->dropForeign(['laptop_model_id']);
            $table->dropForeign(['brand_id']);
            $table->dropColumn(['laptop_info_manual', 'laptop_model_id', 'brand_id']);
        });
    }
};
