<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiagnosisHistory;
use Illuminate\Http\Request;

class DiagnosisHistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = DiagnosisHistory::with(['user', 'brand', 'laptopModel', 'diagnosisResults.kerusakan']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_pengguna', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($uq) => $uq->where('name', 'like', "%{$search}%"))
                  ->orWhere('laptop_info_manual', 'like', "%{$search}%")
                  ->orWhereHas('brand', fn($bq) => $bq->where('nama_brand', 'like', "%{$search}%"))
                  ->orWhereHas('laptopModel', fn($mq) => $mq->where('nama_model', 'like', "%{$search}%")->orWhere('seri', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        $histories = $query->latest('tanggal_diagnosis')->paginate(20)->withQueryString();
        $brands = \App\Models\Brand::orderBy('nama_brand')->get();

        return view('admin.riwayat.index', compact('histories', 'brands'));
    }

    public function show(DiagnosisHistory $riwayat)
    {
        $riwayat->load([
            'user',
            'brand',
            'laptopModel',
            'diagnosisGejala.gejala',
            'diagnosisResults.kerusakan.kategori',
            'diagnosisResults.kerusakan.penyebabs',
            'diagnosisResults.kerusakan.solusis',
        ]);

        return view('admin.riwayat.show', compact('riwayat'));
    }

    /**
     * Tampilkan cetak / PDF laporan perbaikan individual untuk pelanggan & teknisi.
     */
    public function print(DiagnosisHistory $riwayat)
    {
        abort(403, 'Akses cetak laporan riwayat tidak tersedia.');
    }

    /**
     * Download file PDF asli langsung dari server (Content-Disposition attachment).
     */
    public function downloadPdf(DiagnosisHistory $riwayat)
    {
        if (!auth()->user()->isTeknisi()) {
            abort(403, 'Akses ditolak. Hanya teknisi yang dapat mengunduh PDF riwayat diagnosis.');
        }

        $riwayat->load([
            'user',
            'brand',
            'laptopModel',
            'diagnosisGejala.gejala',
            'diagnosisResults.kerusakan.kategori',
            'diagnosisResults.kerusakan.penyebabs',
            'diagnosisResults.kerusakan.solusis',
        ]);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.riwayat.pdf', compact('riwayat'));
        $filename = 'Laporan_Diagnosa_DIAG-' . str_pad($riwayat->id, 5, '0', STR_PAD_LEFT) . '_' . preg_replace('/[^a-zA-Z0-9]/', '_', $riwayat->nama_pengguna ?? 'Guest') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Export rekapitulasi riwayat diagnosis ke format CSV (bisa dibuka di MS Excel / Google Sheets).
     */
    public function export(Request $request)
    {
        abort(403, 'Akses export data riwayat tidak tersedia.');
    }
}
