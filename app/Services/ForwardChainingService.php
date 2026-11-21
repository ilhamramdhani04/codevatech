<?php

namespace App\Services;

use App\Models\Rule;
use App\Models\DiagnosisHistory;
use App\Models\DiagnosisGejala;
use App\Models\DiagnosisResult;
use App\Models\Kerusakan;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ForwardChainingService
{
    /**
     * Jalankan mesin inferensi Forward Chaining.
     *
     * Algoritma:
     * 1. Load semua rules dengan eager-load ruleGejala.
     * 2. Untuk tiap rule:
     *    - Semua gejala is_negated=false harus ADA dalam $gejalaIds
     *    - Semua gejala is_negated=true harus TIDAK ADA dalam $gejalaIds
     * 3. Rule yang lolos → kerusakan_id-nya masuk hasil (deduplikasi).
     *
     * @param  array<int> $gejalaIds  ID gejala yang dipilih pengguna
     * @return Collection<Kerusakan>  Koleksi Kerusakan yang match, dengan penyebab & solusi
     */
    public function diagnose(array $gejalaIds): Collection
    {
        if (empty($gejalaIds)) {
            return collect();
        }

        $gejalaSet = collect($gejalaIds)->map(fn($id) => (int) $id);

        // Load semua rules beserta kondisi gejala-nya
        $rules = Rule::with('ruleGejala')->get();

        $matchedKerusakanIds = [];

        foreach ($rules as $rule) {
            if ($this->isRuleFired($rule, $gejalaSet)) {
                $matchedKerusakanIds[] = $rule->kerusakan_id;
            }
        }

        if (empty($matchedKerusakanIds)) {
            return collect();
        }

        // Deduplikasi dan ambil data lengkap kerusakan
        $uniqueIds = array_unique($matchedKerusakanIds);

        return Kerusakan::with(['kategori', 'penyebabs', 'solusis'])
                        ->whereIn('id', $uniqueIds)
                        ->get();
    }

    /**
     * Cek apakah satu rule terpenuhi oleh fakta yang ada.
     */
    private function isRuleFired(Rule $rule, Collection $gejalaSet): bool
    {
        foreach ($rule->ruleGejala as $rg) {
            $gejalaId = (int) $rg->gejala_id;

            if ($rg->is_negated) {
                // Gejala ini TIDAK BOLEH ada
                if ($gejalaSet->contains($gejalaId)) {
                    return false;
                }
            } else {
                // Gejala ini HARUS ada
                if (!$gejalaSet->contains($gejalaId)) {
                    return false;
                }
            }
        }

        // Rule tanpa kondisi tidak dihitung (data corrupt)
        return $rule->ruleGejala->isNotEmpty();
    }

    /**
     * Jalankan diagnosis dan simpan riwayat ke database.
     *
     * @param  array<int>   $gejalaIds
     * @param  string|null  $namaPengguna  Nama opsional dari guest
     * @param  int|null     $userId        Null = guest
     * @return array{ history: DiagnosisHistory, results: Collection }
     */
    public function diagnoseAndSave(
        array $gejalaIds,
        ?string $namaPengguna = null,
        ?int $userId = null,
        ?int $brandId = null,
        ?int $laptopModelId = null,
        ?string $laptopInfoManual = null,
    ): array
    {
        return DB::transaction(function () use ($gejalaIds, $namaPengguna, $userId, $brandId, $laptopModelId, $laptopInfoManual) {
            // 1. Buat history
            $history = DiagnosisHistory::create([
                'user_id'             => $userId,
                'nama_pengguna'       => $namaPengguna,
                'brand_id'            => $brandId,
                'laptop_model_id'     => $laptopModelId,
                'laptop_info_manual'  => $laptopInfoManual,
                'tanggal_diagnosis'   => now(),
            ]);

            // 2. Simpan gejala yang dipilih
            foreach ($gejalaIds as $gejalaId) {
                DiagnosisGejala::create([
                    'diagnosis_history_id' => $history->id,
                    'gejala_id'            => $gejalaId,
                ]);
            }

            // 3. Jalankan Forward Chaining
            $kerusakans = $this->diagnose($gejalaIds);

            // 4. Simpan hasil
            foreach ($kerusakans as $kerusakan) {
                DiagnosisResult::create([
                    'diagnosis_history_id' => $history->id,
                    'kerusakan_id'         => $kerusakan->id,
                ]);
            }

            return [
                'history' => $history,
                'results' => $kerusakans,
            ];
        });
    }
}
