<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiagnosisHistory;
use App\Models\Gejala;
use App\Models\Kerusakan;
use App\Models\Rule;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_gejala'    => Gejala::count(),
            'total_kerusakan' => Kerusakan::count(),
            'total_rule'      => Rule::count(),
            'total_diagnosis' => DiagnosisHistory::count(),
            'total_brand'     => \App\Models\Brand::count(),
            'total_model'     => \App\Models\LaptopModel::count(),
        ];

        $recentDiagnosis = DiagnosisHistory::with(['user', 'brand', 'laptopModel', 'diagnosisResults.kerusakan'])
                            ->latest('tanggal_diagnosis')
                            ->limit(5)
                            ->get();

        return view('admin.dashboard.index', compact('stats', 'recentDiagnosis'));
    }
}
