<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Gejala;
use App\Services\ForwardChainingService;
use Illuminate\Http\Request;

class DiagnosisController extends Controller
{
    public function __construct(
        private readonly ForwardChainingService $forwardChaining
    ) {}

    /**
     * Pastikan role Admin tidak dapat mengakses/melakukan diagnosis.
     */
    private function authorizeDiagnosis()
    {
        if (auth()->check() && auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard')
                             ->with('error', 'Role Admin tidak diizinkan melakukan diagnosis.');
        }
        return null;
    }

    /**
     * Tampilkan form pemilihan gejala + pilihan brand/model laptop.
     */
    public function index()
    {
        if ($redirect = $this->authorizeDiagnosis()) {
            return $redirect;
        }

        $gejalas       = Gejala::orderBy('kode_gejala')->get();
        $brands        = Brand::with(['laptopModels' => fn($q) => $q->orderBy('nama_model')])
                              ->orderBy('nama_brand')
                              ->get();

        $modelsByBrand = $brands->mapWithKeys(function ($b) {
            return [
                $b->id => $b->laptopModels->map(function ($m) {
                    return [
                        'id'              => $m->id,
                        'nama_model'      => $m->nama_model,
                        'seri'            => $m->seri,
                        'kategori_laptop' => $m->kategori_laptop,
                    ];
                })->values()
            ];
        });

        return view('guest.diagnosis.index', compact('gejalas', 'brands', 'modelsByBrand'));
    }

    /**
     * Proses diagnosis: jalankan Forward Chaining dan simpan riwayat.
     */
    public function process(Request $request)
    {
        if ($redirect = $this->authorizeDiagnosis()) {
            return $redirect;
        }

        $validated = $request->validate([
            'gejala_ids'         => ['required', 'array', 'min:1'],
            'gejala_ids.*'       => ['integer', 'exists:gejalas,id'],
            'nama_pengguna'      => ['nullable', 'string', 'max:100'],
            'brand_id'           => ['nullable', 'integer', 'exists:brands,id'],
            'laptop_model_id'    => ['nullable', 'integer', 'exists:laptop_models,id'],
            'laptop_info_manual' => ['nullable', 'string', 'max:150'],
        ], [
            'gejala_ids.required' => 'Pilih minimal satu gejala untuk melakukan diagnosis.',
            'gejala_ids.min'      => 'Pilih minimal satu gejala untuk melakukan diagnosis.',
        ]);

        $gejalaIds        = $validated['gejala_ids'];
        $namaPengguna     = $validated['nama_pengguna'] ?? null;
        $brandId          = $validated['brand_id'] ?? null;
        $laptopModelId    = $validated['laptop_model_id'] ?? null;
        $laptopInfoManual = $validated['laptop_info_manual'] ?? null;

        $diagnosis = $this->forwardChaining->diagnoseAndSave(
            gejalaIds:        $gejalaIds,
            namaPengguna:     $namaPengguna,
            userId:           auth()->id(),
            brandId:          $brandId,
            laptopModelId:    $laptopModelId,
            laptopInfoManual: $laptopInfoManual,
        );

        // Simpan history ID ke session untuk ditampilkan di halaman hasil
        session(['diagnosis_history_id' => $diagnosis['history']->id]);

        return redirect()->route('diagnosis.result');
    }

    /**
     * Tampilkan hasil diagnosis.
     */
    public function result(Request $request)
    {
        if ($redirect = $this->authorizeDiagnosis()) {
            return $redirect;
        }

        $historyId = session('diagnosis_history_id');

        if (!$historyId) {
            return redirect()->route('diagnosis.index')
                             ->with('error', 'Sesi diagnosis tidak ditemukan. Silakan mulai diagnosis baru.');
        }

        $history = \App\Models\DiagnosisHistory::with([
            'user',
            'brand',
            'laptopModel',
            'diagnosisGejala.gejala',
            'diagnosisResults.kerusakan.kategori',
            'diagnosisResults.kerusakan.penyebabs',
            'diagnosisResults.kerusakan.solusis',
        ])->findOrFail($historyId);

        return view('guest.diagnosis.result', compact('history'));
    }
}
