<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\LaptopModel;
use App\Models\DiagnosisHistory;
use App\Models\Kerusakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $selectedBrandId = $request->input('brand_id');
        $selectedModelId = $request->input('laptop_model_id');
        $startDate       = $request->input('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate         = $request->input('end_date', now()->format('Y-m-d'));

        $brands = Brand::orderBy('nama_brand')->get();
        $laptopModels = $selectedBrandId 
            ? LaptopModel::where('brand_id', $selectedBrandId)->orderBy('nama_model')->get()
            : collect();

        $analytics = $this->calculateAnalytics($selectedBrandId, $selectedModelId, $startDate, $endDate);

        return view('admin.analytics.index', compact(
            'brands',
            'laptopModels',
            'selectedBrandId',
            'selectedModelId',
            'startDate',
            'endDate',
            'analytics'
        ));
    }

    public function data(Request $request)
    {
        $selectedBrandId = $request->input('brand_id');
        $selectedModelId = $request->input('laptop_model_id');
        $startDate       = $request->input('start_date');
        $endDate         = $request->input('end_date');

        $analytics = $this->calculateAnalytics($selectedBrandId, $selectedModelId, $startDate, $endDate);
        
        $laptopModels = $selectedBrandId 
            ? LaptopModel::where('brand_id', $selectedBrandId)->orderBy('nama_model')->get(['id', 'nama_model', 'seri'])
            : [];

        return response()->json([
            'success'      => true,
            'analytics'    => $analytics,
            'laptopModels' => $laptopModels,
        ]);
    }

    private function calculateAnalytics($brandId = null, $modelId = null, $startDate = null, $endDate = null): array
    {
        // 1. All Brands Summary Cards Data
        $brandsList = Brand::orderBy('nama_brand')->get();
        $brandCards = $brandsList->map(function ($b) use ($startDate, $endDate) {
            $hQuery = DB::table('diagnosis_histories')->where('brand_id', $b->id);
            if ($startDate) $hQuery->whereDate('tanggal_diagnosis', '>=', $startDate);
            if ($endDate) $hQuery->whereDate('tanggal_diagnosis', '<=', $endDate);
            $totalDiagnoses = $hQuery->count();

            $topDamage = DB::table('diagnosis_results')
                ->join('diagnosis_histories', 'diagnosis_results.diagnosis_history_id', '=', 'diagnosis_histories.id')
                ->join('kerusakans', 'diagnosis_results.kerusakan_id', '=', 'kerusakans.id')
                ->where('diagnosis_histories.brand_id', $b->id)
                ->select('kerusakans.kode_kerusakan', 'kerusakans.nama_kerusakan', DB::raw('COUNT(diagnosis_results.id) as cnt'))
                ->groupBy('kerusakans.kode_kerusakan', 'kerusakans.nama_kerusakan')
                ->orderByDesc('cnt')
                ->first();

            return [
                'id'              => $b->id,
                'nama_brand'      => $b->nama_brand,
                'logo_url'        => $b->logo_url,
                'total_diagnoses' => $totalDiagnoses,
                'top_damage_code' => $topDamage ? $topDamage->kode_kerusakan : null,
                'top_damage_name' => $topDamage ? $topDamage->nama_kerusakan : 'Belum Ada Kasus',
                'top_damage_count'=> $topDamage ? $topDamage->cnt : 0,
            ];
        });

        // Base Query for Damage Breakdown
        $baseQuery = DB::table('diagnosis_results')
            ->join('diagnosis_histories', 'diagnosis_results.diagnosis_history_id', '=', 'diagnosis_histories.id')
            ->join('kerusakans', 'diagnosis_results.kerusakan_id', '=', 'kerusakans.id')
            ->leftJoin('kategoris', 'kerusakans.kategori_id', '=', 'kategoris.id')
            ->leftJoin('brands', 'diagnosis_histories.brand_id', '=', 'brands.id')
            ->leftJoin('laptop_models', 'diagnosis_histories.laptop_model_id', '=', 'laptop_models.id');

        if ($brandId) {
            $baseQuery->where('diagnosis_histories.brand_id', $brandId);
        }

        if ($modelId) {
            $baseQuery->where('diagnosis_histories.laptop_model_id', $modelId);
        }

        if ($startDate) {
            $baseQuery->whereDate('diagnosis_histories.tanggal_diagnosis', '>=', $startDate);
        }

        if ($endDate) {
            $baseQuery->whereDate('diagnosis_histories.tanggal_diagnosis', '<=', $endDate);
        }

        // Total Case Count
        $totalCases = (clone $baseQuery)->count();

        // Breakdown per Kerusakan (Raw collection for Chart & Analytics)
        $damageBreakdownRaw = (clone $baseQuery)
            ->select(
                'kerusakans.id as kerusakan_id',
                'kerusakans.kode_kerusakan',
                'kerusakans.nama_kerusakan',
                'kategoris.nama_kategori',
                DB::raw('COUNT(diagnosis_results.id) as total_count')
            )
            ->groupBy('kerusakans.id', 'kerusakans.kode_kerusakan', 'kerusakans.nama_kerusakan', 'kategoris.nama_kategori')
            ->orderByDesc('total_count')
            ->get()
            ->map(function ($item) use ($totalCases) {
                $item->percentage = $totalCases > 0 ? round(($item->total_count / $totalCases) * 100, 1) : 0;
                return $item;
            })
            ->values();

        // Native LengthAwarePaginator (Reuse code from Laravel pagination system)
        $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage('page') ?: 1;
        $perPage = 10;
        $currentPageItems = $damageBreakdownRaw->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $damageBreakdown = new \Illuminate\Pagination\LengthAwarePaginator(
            $currentPageItems,
            $damageBreakdownRaw->count(),
            $perPage,
            $currentPage,
            [
                'path' => \Illuminate\Pagination\Paginator::resolveCurrentPath(),
                'pageName' => 'page',
            ]
        );
        $damageBreakdown->appends(request()->query());

        // Breakdown per Brand Comparison
        $brandComparisonQuery = DB::table('diagnosis_histories')
            ->leftJoin('brands', 'diagnosis_histories.brand_id', '=', 'brands.id')
            ->select(
                DB::raw("COALESCE(brands.nama_brand, 'Lainnya / Non-Brand') as brand_name"),
                DB::raw('COUNT(diagnosis_histories.id) as total_histories')
            )
            ->groupBy(DB::raw("COALESCE(brands.nama_brand, 'Lainnya / Non-Brand')"))
            ->orderByDesc('total_histories');

        if ($startDate) $brandComparisonQuery->whereDate('tanggal_diagnosis', '>=', $startDate);
        if ($endDate) $brandComparisonQuery->whereDate('tanggal_diagnosis', '<=', $endDate);

        $brandComparison = $brandComparisonQuery->get();

        // Breakdown Kategori (Hardware vs Software)
        $kategoriBreakdown = (clone $baseQuery)
            ->select(
                DB::raw("COALESCE(kategoris.nama_kategori, 'Umum') as kategori_name"),
                DB::raw('COUNT(diagnosis_results.id) as total_count')
            )
            ->groupBy(DB::raw("COALESCE(kategoris.nama_kategori, 'Umum')"))
            ->get();

        // Automated Insights
        $insights = $this->generateInsights($damageBreakdownRaw, $brandId, $modelId, $totalCases);

        $activeBrandObj = $brandId ? Brand::find($brandId) : null;
        $activeBrandName = $activeBrandObj ? $activeBrandObj->nama_brand : 'Semua Brand';
        $activeModelName = $modelId ? (LaptopModel::find($modelId)->full_name ?? 'Semua Model') : 'Semua Model';

        return [
            'total_cases'          => $totalCases,
            'total_histories'      => DiagnosisHistory::count(),
            'brand_cards'          => $brandCards,
            'damage_breakdown'     => $damageBreakdown, // Paginated for Table
            'damage_breakdown_raw' => $damageBreakdownRaw, // Raw for Charts
            'brand_comparison'     => $brandComparison,
            'kategori_breakdown'   => $kategoriBreakdown,
            'insights'             => $insights,
            'active_brand_id'      => $brandId,
            'active_brand_name'    => $activeBrandName,
            'active_brand_logo'    => $activeBrandObj ? $activeBrandObj->logo_url : null,
            'active_model_name'    => $activeModelName,
            'pagination_html'      => $damageBreakdown->links()->toHtml(),
        ];
    }

    private function generateInsights($damageBreakdown, $brandId, $modelId, $totalCases): array
    {
        $insights = [];

        if ($totalCases === 0) {
            $insights[] = [
                'type' => 'info',
                'title' => 'Belum Ada Data Riwayat',
                'message' => 'Belum ada data diagnosa yang tercatat untuk filter terpilih. Lakukan tes diagnosa untuk membangun dataset analitis.'
            ];
            return $insights;
        }

        $topDamage = $damageBreakdown->first();
        if ($topDamage) {
            $brandName = $brandId ? (Brand::find($brandId)->nama_brand ?? 'Brand Terpilih') : 'Keseluruhan System';
            $insights[] = [
                'type' => 'danger',
                'title' => "Dominasi Kerusakan Utama ({$brandName})",
                'message' => "Kerusakan terbanyak pada {$brandName} adalah [{$topDamage->kode_kerusakan}] {$topDamage->nama_kerusakan} sebanyak {$topDamage->total_count} kasus ({$topDamage->percentage}% dari total diagnosa)."
            ];
        }

        if ($damageBreakdown->count() > 1) {
            $secondDamage = $damageBreakdown->skip(1)->first();
            $insights[] = [
                'type' => 'warning',
                'title' => "Kerusakan Posisi Kedua",
                'message' => "Posisi kedua ditempati oleh [{$secondDamage->kode_kerusakan}] {$secondDamage->nama_kerusakan} dengan {$secondDamage->total_count} kasus ({$secondDamage->percentage}%)."
            ];
        }

        if ($topDamage) {
            $insights[] = [
                'type' => 'success',
                'title' => "Rekomendasi Evaluasi Pakar & Rule",
                'message' => "Disarankan bagi Admin untuk mengevaluasi ketersediaan stok suku cadang/komponen untuk [{$topDamage->kode_kerusakan}], serta meninjau kecukupan rule inferensi terkait."
            ];
        }

        return $insights;
    }
}
