<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gejalas', function (Blueprint $table) {
            $table->string('diagnosis_group', 20)->nullable();
        });

        // Preserve the former diagnosis tab assignments, including soft-deleted rows.
        // Keep this migration self-contained so future UI changes do not alter it.
        $groups = [
            'power' => ['G01', 'G02', 'G03', 'G04', 'G15', 'G16', 'G17', 'G18', 'G19', 'G20', 'G56', 'G63', 'G64'],
            'display' => ['G05', 'G06', 'G07', 'G08', 'G57', 'G58'],
            'performance' => ['G09', 'G10', 'G11', 'G12', 'G13', 'G14', 'G30', 'G38', 'G39', 'G42', 'G65', 'G66'],
            'input' => ['G21', 'G22', 'G23', 'G24', 'G25', 'G26', 'G27', 'G28', 'G29', 'G43', 'G44', 'G45', 'G46', 'G47', 'G52', 'G53'],
            'system' => ['G31', 'G32', 'G33', 'G34', 'G35', 'G36', 'G37', 'G40', 'G41', 'G48', 'G49', 'G50', 'G51', 'G54', 'G55', 'G59', 'G60', 'G61', 'G62'],
        ];

        foreach ($groups as $group => $codes) {
            DB::table('gejalas')->whereIn('kode_gejala', $codes)->update(['diagnosis_group' => $group]);
        }
    }

    public function down(): void
    {
        Schema::table('gejalas', function (Blueprint $table) {
            $table->dropColumn('diagnosis_group');
        });
    }
};
